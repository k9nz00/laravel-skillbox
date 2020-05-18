<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Post;
use App\Services\CommentServices;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @param StoreCommentRequest $storeCommentRequest
     * @param Post $post
     * @param CommentServices $commentServices
     */
    public function storeForPost(StoreCommentRequest $storeCommentRequest, Post $post, CommentServices $commentServices)
    {
        $comment = $commentServices->store($post, $storeCommentRequest);
        return back();
    }
}
