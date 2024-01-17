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
        })->orderBy('message_id', 'desc')->take(10)->get()->reverse()->values();

        return view('index', [
            'user' => json_encode($chat_messages),
            'messages' => $chat_messages,
        ]);
    }
}
