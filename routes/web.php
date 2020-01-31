<?php

Route::get('/', 'MainController@index')->name('home');
Route::get('/posts', 'Posts\PostController@index')->name('posts');
Route::get('/posts/create', 'Posts\PostController@create')->name('post.create');
Route::post('/posts', 'Posts\PostController@store');
Route::get('/posts/{post}', 'Posts\PostController@show')->name('post.show');


//Route::get('/tasks/{id}', function ($id) {
//    $task = Task::find($id);
//    return view('tasks.show', compact('task'));
//});

