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
