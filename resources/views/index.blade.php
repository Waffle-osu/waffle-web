@extends('layout')

@section('title', 'Main Page')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="left-side">
        <div class="announcements">
            <p class="heading-text">Announcements</p>
            <br/>
            <div class="announcement">
                <div style="font-size: 14px">
                    01.03.2024
                    <b style="color: rgb(127,48,38); display: inline">Waffle is released!</b>

                    (Furball)</div>
                <hr>
                <div class="news-text">
                    Waffle is finally released! (absolute lie, impossible)
                </div>
            </div>
        </div>
        <div class="online-user-stats">
            <p class="heading-text" style="display: inline">Online users</p>
            <p class="heading-text" style="display: inline; font-size: 8pt">over the last 24 hours</p>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>
        <div class="irc-log">
            <p class="heading-text" style="display: inline">Game Chat</p>

            <div class="chat">
                <table style="width: 100%; border: 1px; border-radius: 3px">
                    <tbody>
                        @for ($i = 0; $i < count($messages); $i++)
                            @if($i % 2 == 0)
                                <tr class="light-row">
                                    <td class="chat-time">{{ date('H:i', strtotime($messages[$i]->date)) }}</td>
                                    <td class="chat-msg">{{ $messages[$i]->username  }}: {{ $messages[$i]->message }}</td>
                                </tr>
                            @else
                                <tr class="dark-row">
                                    <td class="chat-time">{{ date('h:i', strtotime($messages[$i]->date)) }}</td>
                                    <td class="chat-msg">{{ $messages[$i]->username  }}: {{ $messages[$i]->message }}</td>
                                </tr>
                            @endif
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="right-side">

    </div>

@endsection
