<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RateController;

Route::get('/', [TopicController::class, 'showTopics'])->name('home');

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [UserController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/search', [TopicController::class, 'searchTopics'])->name('searchTopics');
Route::get('/trending-topics', [TopicController::class, 'listMostViewedTopics'])->name('trendingTopics');

Route::post('/comments/create', [CommentController::class, 'createComment'])->name('createComment');

Route::post('/tags/create', [TagController::class, 'createTag'])->name('createTag');
Route::get('/tags/list', [TagController::class, 'showTags'])->name('showTags');

Route::post('/topics', [TopicController::class, 'createTopic'])->name('createTopic');
Route::get('/tags/{id}', [TagController::class, 'listTagById'])->name('listTagById');
Route::post('/categories/create', [CategoryController::class, 'createCategory'])->name('createCategory');
Route::get('/categories/{id}/show', [CategoryController::class, 'show'])->name('show');
Route::get('/categories/list', [CategoryController::class, 'showCategories'])->name('showCategories');

Route::get('/banned', function () {
    return view('users.banned');
})->name('banned');

Route::middleware('auth')->group(function () {

    Route::get('/myaccount', [UserController::class, 'myAccount'])->name('myAccount');
    Route::put('/myaccount/update', [UserController::class, 'updateAccount'])->name('updateAccount');
    Route::delete('/myaccount/delete', [UserController::class, 'deleteAccount'])->name('deleteAccount');
    Route::get('/person/{id}', [UserController::class, 'person'])->name('person');
    Route::put('/users/{id}/update', [UserController::class, 'updateUser'])->name('updateUser');
    Route::get('/question', [UserController::class, 'question'])->name('question');
    Route::get('/answers', [UserController::class, 'answers'])->name('answers');
    Route::get('/likes', [UserController::class, 'likes'])->name('likes');
    
    Route::post('/posts/{postId}/rate', [RateController::class, 'ratePost'])->name('ratePost');

    Route::put('/topics/{id}/update-home', [TopicController::class, 'updateTopicFromHome'])->name('updateTopicHome');
    Route::get('/topics/{id}', [TopicController::class, 'listTopicById'])->name('listTopicById');
    Route::delete('/topics/{id}/deleteFromHome', [TopicController::class, 'deleteTopicHome'])->name('deleteTopicHome');
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('deleteUser');
});

Route::middleware(['auth', 'role:moderator,admin'])->group(function () {
    // Gerenciamento de tópicos
    Route::get('/topics', [TopicController::class, 'listAllTopics'])->name('listAllTopics');
    
    Route::put('/topics/{id}/update', [TopicController::class, 'updateTopic'])->name('updateTopic');
    Route::get('/topics/{id}/edit', [TopicController::class, 'editTopic'])->name('editTopic');
    Route::get('/topics/{id}/delete', [TopicController::class, 'deleteTopic'])->name('deleteTopic');
    Route::get('newest-topics', [TopicController::class, 'listNewestTopics'])->name('newestTopics');

    // Gerenciamento de posts
    Route::get('/posts', [PostController::class, 'listAllPosts'])->name('listAllPosts');
    Route::post('/posts', [PostController::class, 'store'])->name('storePost');
    Route::get('/posts/{id}/edit', [PostController::class, 'editPost'])->name('editPost');
    Route::put('/posts/{id}/update', [PostController::class, 'updatePost'])->name('updatePost');
    Route::get('/posts/{id}', [PostController::class, 'deletePost'])->name('deletePost');

    // Gerenciamento de comentários
    Route::get('/comments', [CommentController::class, 'listAllComments'])->name('listAllComments');
    Route::get('/comments/{id}', [CommentController::class, 'listCommentById'])->name('listCommentById');
 
    Route::put('/comments/{id}/update', [CommentController::class, 'updateComment'])->name('updateComment');
    Route::get('/comments/{id}/edit', [CommentController::class, 'editComment'])->name('editComment');
    Route::delete('/comments/{id}/delete', [CommentController::class, 'deleteComment'])->name('deleteComment');

    Route::get('/tags', [TagController::class, 'listAllTags'])->name('listAllTags');

    Route::put('/tags/{id}/update', [TagController::class, 'updateTag'])->name('updateTag');
    Route::get('/tags/{id}/edit', [TagController::class, 'editTag'])->name('editTag');
    Route::get('/tags/{id}/delete', [TagController::class, 'deleteTag'])->name('deleteTag');

    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Gerenciamento de usuários
    Route::get('/users', [UserController::class, 'listAllUsers'])->name('listAllUsers');
    Route::get('/users/{id}', [UserController::class, 'listUserById'])->name('listUserById');

    Route::get('/users/{id}/edit', [UserController::class, 'editUser'])->name('editUser');
    
    Route::put('/users/{id}/ban', [UserController::class, 'banUser'])->name('banUser');
    Route::put('/users/{id}/unban', [UserController::class, 'unbanUser'])->name('unbanUser');

    // Gerenciamento de categorias
    Route::get('/categories', [CategoryController::class, 'listAllCategories'])->name('listAllCategories');
    Route::get('/categories/{id}', [CategoryController::class, 'listCategoryById'])->name('listCategoryById');
   
    Route::put('/categories/{id}/update', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('editCategory');
    Route::get('/categories/{id}/delete', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');

    Route::get('/routes-list', function () {
        return view('list_routes');
    })->name('routesList');
});



