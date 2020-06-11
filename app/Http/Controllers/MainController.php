<?php

namespace App\Http\Controllers;

use App\Models\Admin\Feedback;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * Главная страница сайта
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('mainPages.home');
    }

    /**
     * Страница контактов
     *
     * @return Factory|View
     */
    public function contacts()
    {
        return view('mainPages.contacts');
    }

    /**
     * Страница "о нас"
     *
     * * @return Factory|View
     */
    public function about()
    {
        return view('mainPages.about');
    }

    /**
     * Сохраняет вопрос пользователя
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function storeMessageFromUser(Request $request)
    {
        $validatedData = $this->validate($request, [
            'email' => 'required|email',
            'feedback' => 'required',
        ]);

        Feedback::create([
            'email' => $validatedData['email'],
            'feedback' => $validatedData['feedback'],
        ]);
        return redirect(route('home'));
    }


    /**
     * Страница "любопытной" статистики
     *
     *
     * @return View
     */
    public function statistic()
    {
        $countPosts = Post::count(); //общее количество статей
        $countNews = News::count(); //общее количество новостей
        $userHaveMaxPosts = User::whereHas('posts')->withCount('posts')->orderByDesc('posts_count')->first()->name; //имя юзера с максимальным кол-вом статей
        $maxLengthPost = DB::table('posts') //самая длинная сатья
        ->selectRaw('LENGTH(body) as length, title, slug')
            ->orderByDesc('length')
            ->first();
        $minLengthPost = DB::table('posts') //самая короткая статья
        ->selectRaw('LENGTH(body) as length, title, slug')
            ->orderBy('length')
            ->first();
        $postHasMaximumChanges = Post::whereHas('history')->withCount('history')->orderByDesc('history_count')->first(['*']); //самая часто изменяемая статья
        $postHasMaximumComments = Post::whereHas('comments')->withCount('comments')->orderByDesc('comments_count')->first(['*']); //самая комментируемая статья

        /*
         * Подсчет работает, но:
         * 1 - ->get(['posts_count']) для подходящмх моделей выбираются все поля, а не указанные в get
         * 2-  Михаил, поясните, пожалуйста, какой способ эффективней - этот (при условии выборки только нужных полей) или тот, который ниже (105-106 строчка)
         *
        $activeUsers = User::has('posts', '>', 1)->withCount('posts')->get(['posts_count']);
        $averageCountPostsOfActiveUser = $activeUsers->avg('posts_count');
        */

        //Подсчет отрабатывает как надо, но читабельность кода хромает сильно (по крайней мере для меня)
        //поэтому меня он не устраивает
        $activeUsers = User::has('posts', '>', 1)->withCount('posts');
        $averageCountPostsOfActiveUser = DB::table(DB::raw("({$activeUsers->toSql()}) as activeUsers"))->average('posts_count');

        $usersCount = User::count();

        $tagsCount = Tag::count(); //количемтво тегов
        $mostPopularTagWithPosts = Tag::whereHas('posts') //самый популярный тег среди статей
        ->withCount('posts')
            ->orderByDesc('posts_count')
            ->first();

        $statistics = [
            'countPosts' => $countPosts,
            'countNews' => $countNews,
            'author' => $userHaveMaxPosts,
            'maxLengthPost' => [
                'title' => $maxLengthPost->title,
                'slug' => $maxLengthPost->slug,
                'length' => $maxLengthPost->length,
            ],
            'minLengthPost' => [
                'title' => $minLengthPost->title,
                'slug' => $minLengthPost->slug,
                'length' => $minLengthPost->length,
            ],
            'averageCountPosts' => round($averageCountPostsOfActiveUser, 2),
            'postHasMaximumChanges' => [
                'title'=> $postHasMaximumChanges->title,
                'slug'=> $postHasMaximumChanges->slug,
                'count'=> $postHasMaximumChanges->history_count,
            ],
            'postHasMaximumComments' => [
                'title'=> $postHasMaximumComments->title,
                'slug'=> $postHasMaximumComments->slug,
                'count'=> $postHasMaximumComments->comments_count,
            ],
            'tagsCount' => $tagsCount,
            'mostPopularTagWithPosts' => [
                'name' => $mostPopularTagWithPosts->name,
                'count'=> $mostPopularTagWithPosts->posts_count,
            ]
        ];

        return view('mainPages.statistic', compact('statistics'));
    }
}
