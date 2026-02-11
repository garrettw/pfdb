#!/bin/bash

# Source EB environment variables
#source /opt/elasticbeanstalk/deployment/env

# Find the correct PHP-FPM config file
PHP_FPM_CONF=$(find /etc -name "www.conf" -path "*/php-fpm.d/*" 2>/dev/null | head -1)

if [ -f "$PHP_FPM_CONF" ]; then
    # Add environment variables
    /opt/elasticbeanstalk/bin/get-config environment | jq -r 'to_entries | .[] | "env[\(.key)] = \"\(.value)\""' >> $PHP_FPM_CONF

    # Ensure clear_env is disabled so PHP can see these variables
    if ! grep -q "clear_env = no" /etc/php-fpm.d/www.conf; then
        echo "clear_env = no" >> /etc/php-fpm.d/www.conf
    fi

    # Restart PHP-FPM
    systemctl restart php-fpm

    echo "Environment variables configured for PHP-FPM"
else
    echo "Could not find PHP-FPM www.conf file"
fi
