<?php

namespace App\Http\Controllers;

use App\Events\SomethingHappens;
use App\Models\Admin\Feedback;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;
use Cache;
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
        $hourLiveTime = 3600;
        $dayLiveTime = 3600 * 24;

        //общее количество статей
        $countPosts = Cache::tags([Post::CACHE_TAGS])
            ->remember('countPosts', $hourLiveTime, function () {
                return Post::count();
            });

        //общее количество новостей
        $countNews = Cache::tags([News::CACHE_TAGS])
            ->remember('countPosts', $hourLiveTime, function () {
                return News::count();
            });

        //имя юзера с максимальным кол-вом статей
        $userHaveMaxPosts = Cache::tags([Post::CACHE_TAGS, 'user'])
            ->remember('userHaveMaxPosts', $hourLiveTime, function () {
                return User::whereHas('posts')
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->first()
                    ->name;
            });

        //самая длинная сатья
        $maxLengthPost = Cache::tags([Post::CACHE_TAGS])
            ->remember('maxLengthPost', $dayLiveTime, function () {
                return DB::table('posts')
                    ->selectRaw('LENGTH(body) as length, title, slug')
                    ->orderByDesc('length')
                    ->first();
            });

        //самая короткая статья
        $minLengthPost = Cache::tags([Post::CACHE_TAGS])
            ->remember('minLengthPost', $dayLiveTime, function () {
                return DB::table('posts')
                    ->selectRaw('LENGTH(body) as length, title, slug')
                    ->orderBy('length')
                    ->first();
            });

        //самая часто изменяемая статья
        $postHasMaximumChanges = Cache::tags([Post::CACHE_TAGS])
            ->remember('postHasMaximumChanges', $dayLiveTime, function () {
                return Post::whereHas('history')
                    ->withCount('history')
                    ->orderByDesc('history_count')
                    ->first(['*']);
            });

        //самая комментируемая статья
        $postHasMaximumComments = Cache::tags([Post::CACHE_TAGS])
            ->remember('postHasMaximumComments', $dayLiveTime, function () {
                return Post::whereHas('comments')->withCount('comments')->orderByDesc('comments_count')->first(['*']);
            });

        /*
         * Подсчет работает, но:
         * 1 - ->get(['posts_count']) для подходящмх моделей выбираются все поля, а не указанные в get
         * 2-  Способ, который закоментирован ниже тоже работает. Однако,
         * Подсчет отрабатывает как надо, но читабельность кода хромает сильно (по крайней мере для меня)
         * поэтому меня он не устраивает
         *
        $activeUsers = User::has('posts', '>', 1)->withCount('posts');
        $averageCountPostsOfActiveUser = DB::table(DB::raw("({$activeUsers->toSql()}) as activeUsers"))->average('posts_count');
        */

        //Средние количество статей у “активных” пользователей
        $averageCountPostsOfActiveUser = Cache::tags([Post::CACHE_TAGS, 'user'])
            ->remember('averageCountPostsOfActiveUser', $dayLiveTime, function () {

                $activeUsers = User::has('posts', '>', 1)->withCount('posts')->get(['posts_count']);
                return $activeUsers->avg('posts_count');
            });

        //Количество зарегистрированных пользователей на сайте
        $countUsers = Cache::tags(['users', 'user'])
            ->remember('usersCount', $hourLiveTime, function () {
                return User::count();
            });

        //количемтво тегов на сайте, у которых есть статьи и/или новости
        $countTags = Cache::tags([Tag::CACHE_TAGS, Tag::CONTENT])
            ->remember('countUsers', $hourLiveTime, function () {
                return Tag::has('posts')
                    ->orHas('news')
                    ->count();
            });

        //самый популярный тег среди статей
        $mostPopularTagWithPosts = Cache::tags([Post::CACHE_TAGS, Post::CONTENT])
            ->remember('mostPopularTagWithPosts', $dayLiveTime, function () {
                return Tag::whereHas('posts')
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->first();
            });

        $statistics = [
            'countPosts' => $countPosts,
            'countNews' => $countNews,
            'author' => $userHaveMaxPosts,
            'countUsers' => $countUsers,
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
                'title' => $postHasMaximumChanges->title,
                'slug' => $postHasMaximumChanges->slug,
                'count' => $postHasMaximumChanges->history_count,
            ],
            'postHasMaximumComments' => [
                'title' => $postHasMaximumComments->title,
                'slug' => $postHasMaximumComments->slug,
                'count' => $postHasMaximumComments->comments_count,
            ],
            'tagsCount' => $countTags,
            'mostPopularTagWithPosts' => [
                'name' => $mostPopularTagWithPosts->name,
                'count' => $mostPopularTagWithPosts->posts_count,
            ]
        ];

        return view('mainPages.statistic', compact('statistics'));
    }
}
