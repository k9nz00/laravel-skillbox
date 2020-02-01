<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Message;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        $this->titlePage = 'Административный раздел';
        $data = [
            'messages'  => $messages,
            'titlePage' => $this->titlePage,
        ];
        return view('admin.index', $data);
    }
}
