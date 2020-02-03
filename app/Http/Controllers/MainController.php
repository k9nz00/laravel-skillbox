<?php

namespace App\Http\Controllers;

use App\Models\Admin\Feedback;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * Главная страница сайта - вывод всех постов
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts = Post::latest()->get(['title', 'slug', 'shortDescription', 'created_at']);
        return view('mainPages.index', compact('posts'));
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
    public function storeMessage(Request $request)
    {
        $validatedData = $this->validate($request, [
            'email'    => 'required|email',
            'feedback' => 'required',
        ]);

        Feedback::create([
            'email'    => $validatedData['email'],
            'feedback' => $validatedData['feedback'],
        ]);
        return redirect(route('home'));
    }
}
