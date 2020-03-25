<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
       $posts = Post::latest()->get();
       return view('admin.post.index', compact('posts'));
    }

    /**
     * Создание поста из админки
     *
     * @return Factory|View
     */
    public function create()
    {
       return view('admin.post.create');
    }

    /**
     * Сохранение поста из админки
     *
     * @param StorePostRequest $storePostRequest
     * @return RedirectResponse
     */
    public function store(StorePostRequest $storePostRequest)
    {
        $validatedData = $storePostRequest->validated();
        $post = Post::create(array_merge($validatedData, [
            'publish'  => (boolean)$storePostRequest->publish,
            'owner_id' => Auth::id(),
        ]));

        $tagsIds = [];
        $tagsToAttach = explode(', ', $storePostRequest->tags);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIds[] = $tagToAttach->id;
        }
        $post->tags()->sync($tagsIds);
        $messageAboutCreate = 'Статья ' . $post->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);
        return redirect()->route('postsPanel.index');
    }

    /**
     * Редактирование поста из админки
     *
     * @param Post $post
     * @return Factory|View
     */
    public function edit(Post $post)
    {
        //приходит пустой $post
        dd($post);
//        Gate::authorize('update', $post);
//        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        //приходит пустой $post
        dd($post);

    }
}
