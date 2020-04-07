<?php

Route::get('/', 'MainController@index')->name('home');
Route::get('/contacts', 'MainController@contacts')->name('contacts');
Route::get('/about', 'MainController@about')->name('about');
Route::post('contacts', 'MainController@storeMessageFromUser')->name('message.store');

Route::get('/posts/tags/{tag}', 'TagController@index')->name('tags.list');
Route::resource('/posts', 'Post\PostController');

$adminGroupDataProperty = [
    'namespace' => 'Admin',
    'prefix'    => 'admin',
    'middleware' => ['auth' ,'admin']
];
Route::group($adminGroupDataProperty, function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/feedback', 'AdminController@feedback')->name('admin.feedback');

    Route::patch('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@update');
    Route::delete('/postsPanel/publish/{post}', 'Post\AdminPublishPostController@destroy');

    Route::group(['namespace'=>'Post'], function (){
        Route::get('/posts', 'AdminPostController@index')->name('admin.posts.index');
        Route::get('/posts/create', 'AdminPostController@create')->name('admin.post.create');
        Route::post('/posts', 'AdminPostController@store')->name('admin.post.store');
        Route::get('/posts/{post}/edit', 'AdminPostController@edit')->name('admin.post.edit');
        Route::put('/posts/{post}', 'AdminPostController@update')->name('admin.post.update');
        Route::delete('/posts/{post}', 'AdminPostController@destroy')->name('admin.post.destroy');
    });
});



Auth::routes();
