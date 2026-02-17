<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layout_columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_table_layout_id');
            $table->integer('attribute_id');
            $table->string('label')->nullable();
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('category_table_layout_id');
            $table->index('attribute_id');
            $table->index('display_order');

            $table->foreign('category_table_layout_id')->references('id')->on('category_table_layouts')->cascadeOnDelete();
            $table->foreign('attribute_id')->references('id')->on('attributes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layout_columns');
    }
};
