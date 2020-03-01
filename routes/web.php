<?php

Route::get('/', 'MainController@index')->name('home');
Route::get('/contacts', 'MainController@contacts')->name('contacts');
Route::get('/about', 'MainController@about')->name('about');
Route::post('contacts', 'MainController@storeMessageFromUser')->name('message.store');

Route::get('/posts/tags/{tag}', 'TagController@index')->name('tags.list');

$adminGroupDataProperty = [
    'namespace' => 'Admin',
    'prefix'    => 'admin',
];

Route::group($adminGroupDataProperty, function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/feedbacks', 'AdminController@feedbacks')->name('admin.feedbacks');

});

Route::resource('/post', 'Post\PostController');
Auth::routes();