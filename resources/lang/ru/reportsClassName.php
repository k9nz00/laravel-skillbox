<?php

use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;

return [
    Comment::class => 'Комментариев',
    News::class => 'Новостей',
    Post::class => 'Статей',
    Tag::class => 'Тегов',
    User::class => 'Пользователей',
];
