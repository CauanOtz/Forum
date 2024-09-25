<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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
Route::get('/', [AuthController::class, 'teste'])->name('teste');

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');

Route::match(['get', 'post'], '/register', [UserController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/users', [UserController::class, 'listAllUsers'])->name('listAllUsers');
    Route::get('/users/{id}', [UserController::class, 'listUserById'])->name('listUserById');
    Route::put('/users/{id}/update', [UserController::class, 'updateUser'])->name('updateUser');
    Route::get('/users/{id}/edit', [UserController::class, 'editUser'])->name('editUser');
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('deleteUser');

    Route::get('/topics', [TopicController::class, 'listAllTopics'])->name('listAllTopics');
    Route::get('/topics/{id}', [TopicController::class, 'listTopicById'])->name('listTopicById');
    Route::post('/topics', [TopicController::class, 'createTopic'])->name('createTopic');
    Route::put('/topics/{id}/update', [TopicController::class, 'updateTopic'])->name('updateTopic');
    Route::get('/topics/{id}/edit', [TopicController::class, 'editTopic'])->name('editTopic');
    Route::get('/topics/{id}/delete', [TopicController::class, 'deleteTopic'])->name('deleteTopic');

    Route::get('/posts', [PostController::class, 'listAllPosts'])->name('listAllPosts');
    Route::get('/posts/{id}', [PostController::class, 'listPostById'])->name('listPostById');
    Route::post('/posts', [PostController::class, 'createPost'])->name('createPost');
    Route::put('/posts/{id}/update', [PostController::class, 'updatePost'])->name('updatePost');
    Route::get('/posts/{id}/edit', [PostController::class, 'editPost'])->name('editPost');
    Route::get('/posts/{id}/delete', [PostController::class, 'deletePost'])->name('deletePost');

    Route::get('/tags', [TagController::class, 'listAllTags'])->name('listAllTags');
    Route::get('/tags/{id}', [TagController::class, 'listTagById'])->name('listTagById');
    Route::post('/tags', [TagController::class, 'createTag'])->name('createTag');
    Route::put('/tags/{id}/update', [TagController::class, 'updateTag'])->name('updateTag');
    Route::get('/tags/{id}/edit', [TagController::class, 'editTag'])->name('editTag');
    Route::get('/tags/{id}/delete', [TagController::class, 'deleteTag'])->name('deleteTag');

    Route::get('/myaccount', [UserController::class, 'myAccount'])->name('myAccount');
    Route::put('/myaccount/update', [UserController::class, 'updateAccount'])->name('updateAccount');
    Route::delete('/myaccount/delete', [UserController::class, 'deleteAccount'])->name('deleteAccount');

    
});
