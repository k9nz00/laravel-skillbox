<?php

use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;

return [
    Comment::class => 'Комментарии',
    News::class => 'Новости',
    Post::class => 'Статьи',
    Tag::class => 'Теги',
    User::class => 'Пользователи',
];
