<?php

Route::get('/', 'MainController@index')->name('home');
Route::get('/contacts', 'MainController@contacts')->name('contacts');
Route::get('/statistic', 'MainController@statistic')->name('statistic');
Route::get('/about', 'MainController@about')->name('about');
Route::post('contacts', 'MainController@storeMessageFromUser')->name('message.store');

Route::get('/posts/tags/{tag}', 'TagController@index')->name('tags.list');
Route::resource('/posts', 'Post\PostController');

/*
 * ->names([
    'index' => 'posts.index',
    'create' => 'posts.create',
    'store' => 'posts.store',
    'show' => 'posts.show',
    'edit' => 'posts.edit',
    'update' => 'posts.update',
    'destroy' => 'posts.destroy',
])
 */

Route::resource('/news', 'NewsController')->only(['index', 'show']);
Route::post('/post/comment/store/{post}', 'CommentController@storeForPost')->name('post.comment.store');
Route::post('/news/comment/store/{news}', 'CommentController@storeForNews')->name('news.comment.store');

$adminGroupDataProperty = [
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin'],
];
Route::group($adminGroupDataProperty, function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/feedback', 'AdminController@feedback')->name('admin.feedback');

    Route::patch('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@update');
    Route::delete('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@destroy');
    Route::resource('/posts', 'Post\AdminPostController')->names('admin.posts');
    Route::resource('/news', 'News\AdminNewsController')
        ->except(['show'])
        ->names('admin.news');
});

Auth::routes();
