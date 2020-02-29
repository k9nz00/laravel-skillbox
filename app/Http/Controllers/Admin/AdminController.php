<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Feedback;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Главная страница админки
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Страница с обратной связью от пользователей
     *
     * @return Factory|View
     */
    public function feedbacks(){
        $messages = Feedback::latest()->get();
        $data = [
            'messages'  => $messages,
        ];
        return view('admin.feedback.feedback', $data);
    }
}
