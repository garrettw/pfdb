<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\CategoryView;
use App\Livewire\PageView;

Route::get('/', Home::class)->name('home');
Route::get('/category/{slug}', CategoryView::class)->name('category.view');
Route::get('/page/{slug}', PageView::class)->name('page.view');
