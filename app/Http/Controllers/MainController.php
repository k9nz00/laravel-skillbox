<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MainController extends Controller
{
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
        $this->titlePage = 'Контакты';
        $data = [
            'titlePage' => $this->titlePage,
        ];
        return view('mainPages.contacts', $data);
    }

    /**
     * Страница "о нас"
     *
     * * @return Factory|View
     */
    public function about()
    {
        $this->titlePage = 'Страница о нас';
        $data = [
            'titlePage' => $this->titlePage,
        ];
        return view('mainPages.about', $data);
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
        if ($request->method() == 'POST') {

            $this->validate($request, [
                'email'   => 'required|email',
                'message' => 'required',
            ]);

            Message::create([
                'email'   => Str::slug($request->email),
                'message' => $request->message,
            ]);
        }
        return redirect(route('home'));
    }
}
