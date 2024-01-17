<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class IndexController extends Controller {
    public function show(): View {
        $chat_messages = ChatMessage::leftJoin('users', function($q) {
            $q->on('irc_log.sender', '=', 'users.user_id');
        })->take(10)->get();

        $what = User::where('user_id', 2)->first();

        return view('index', [
            'user' => json_encode($chat_messages),
            'messages' => $chat_messages,
        ]);
    }
}
