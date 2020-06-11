<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\News;
use App\Models\Post;
use App\Services\CommentServices;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Добавление комменнтария к статье
     *
     * @param StoreCommentRequest $storeCommentRequest
     * @param Post $post
     * @param CommentServices $commentServices
     * @return RedirectResponse
     */
    public function storeForPost(StoreCommentRequest $storeCommentRequest, Post $post, CommentServices $commentServices)
    {
        $comment = $commentServices->store($post, $storeCommentRequest);
        return back();
    }

    /**
     * Добавление комменнтария к новости
     *
     * @param StoreCommentRequest $storeCommentRequest
     * @param News $news
     * @param CommentServices $commentServices
     * @return RedirectResponse
     */
    public function storeForNews(StoreCommentRequest $storeCommentRequest, News $news, CommentServices $commentServices)
    {
        $comment = $commentServices->store($news, $storeCommentRequest);
        return back();
    }
}
