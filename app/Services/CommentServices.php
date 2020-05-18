<?php

namespace App\Services;

use App\Helpers\MessageHelpers;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\Contentable;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Services\ExternalServices\Pushall;
use Auth;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class CommentServices
{
    /**
     * Сохранение нового комментария и его привязка к $contentable
     *
     * @param Contentable $contentable
     * @param FormRequest $formRequest
     * @return Comment
     */
    public function store(Contentable $contentable, FormRequest $formRequest): Comment
    {
        $validatedDataForComment = $formRequest->validated();
        $comment = new Comment();
        $comment->body = $validatedDataForComment['body'];
        $comment->owner_id = Auth::id();

        $contentable->comments()->save($comment);
        $comment->save();

        return $comment;
    }


}
