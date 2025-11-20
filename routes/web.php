<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\CategoryView;

Route::get('/', Home::class)->name('home');
Route::get('/category/{slug}', CategoryView::class)->name('category.view');
