<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(PublicController::class)->group(function() {
    Route::get('/',  'index')->name('home');
    Route::get('/category/{category}',  'category')->name('category');
    Route::get('/destination/{slug}',  'destination_detail')->name('destination-detail');
    Route::post('/post-comment',  'post_comment');
});

Route::controller(AdminController::class)->group(function() {
    Route::get('/admin',  'index')->name('admin.login');
    Route::post('/login',  'login');
    Route::get('/dashboard',  'dashboard')->name('admin.dashboard');
    Route::post('/update',  'update_app');

    Route::get('/list-destination',  'list_destination')->name('admin.list-destination');
    Route::get('/add-destination',  'add_destination')->name('admin.add-destination');
    Route::get('/edit-destination/{slug}',  'edit_destination')->name('admin.edit-destination');
    Route::post('/add-destination',  'store_destination');
    Route::post('/delete-destination',  'delete_destination');
    Route::post('/edit-destination',  'update_destination');
    
    Route::get('/list-gallery',  'list_gallery')->name('admin.list-gallery');
    Route::get('/add-gallery',  'add_gallery')->name('admin.add-gallery');
    Route::get('/edit-gallery/{id}',  'edit_gallery')->name('admin.edit-gallery');
    Route::post('/add-gallery',  'store_gallery');
    Route::post('/delete-gallery',  'delete_gallery');
    Route::post('/edit-gallery',  'update_gallery');
    // Route::get('/admin',  'index')->name('admin-login');
});
