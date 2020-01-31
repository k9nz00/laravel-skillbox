<?php

Route::get('/', 'MainController@index')->name('home');

Route::get('/contacts', 'MainController@contacts')->name('contacts');
Route::post('contacts', 'MainController@storeMessage')->name('message.store');

Route::get('/about', 'MainController@about')->name('about');

Route::get('/posts/create', 'Post\PostController@create')->name('post.create');
Route::post('/posts', 'Post\PostController@store')->name('post.store');
Route::get('/posts/{post}', 'Post\PostController@index')->name('post.show');

$groupData = [
    'namespace' => 'Admin',
    'prefix'    => 'admin',
];

Route::group($groupData, function () {
    Route::get('/', 'AdminController@index')->name('home.admin');
});