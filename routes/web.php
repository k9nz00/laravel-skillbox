<?php

Route::get('/', 'MainController@index')->name('home');
Route::get('/contacts', 'MainController@contacts')->name('contacts');
Route::get('/about', 'MainController@about')->name('about');
Route::post('contacts', 'MainController@storeMessageFromUser')->name('message.store');

Route::get('/posts/tags/{tag}', 'TagController@index')->name('tags.list');
Route::resource('/posts', 'Post\PostController');

$adminGroupDataProperty = [
    'namespace'  => 'Admin',
    'prefix'     => 'admin',
    'middleware' => ['auth', 'admin'],
];
Route::group($adminGroupDataProperty, function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/feedback', 'AdminController@feedback')->name('admin.feedback');

    Route::patch('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@update');
    Route::delete('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@destroy');
    Route::resource('/posts', 'Post\AdminPostController')->names('admin.posts');
});

Auth::routes();
