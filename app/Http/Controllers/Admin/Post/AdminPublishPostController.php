<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminPublishPostController extends Controller
{
    /**
     * Обновление статуса публикации поста (публикация)
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(Post $post)
    {
       $post->published();
       return back();
    }

    /**
     * Обновление статуса публикации поста (снятие с публикации)
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->anPublished();
        return back();
    }
}
