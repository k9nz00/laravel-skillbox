<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Interfaces\Contentable;
use Auth;
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
