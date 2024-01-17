@extends('layout')

@section('title', 'Main Page')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="left-side" style="width: 100%">
        <div class="announcements">
            <p class="heading-text">Announcements</p>
            <br/>
            <div class="announcement">
                <div style="font-size: 14px">
                    01.03.2024
                    <b style="color: rgb(127,48,38); display: inline">Waffle is released!</b>

                    (Furball)</div>
                <hr>
                <div class="news-text" style="margin-bottom: -2px">
                    Waffle is finally released! (absolute lie, impossible) <br/>
                    Experts believe Waffle may release very late this decade...
                </div>

                <div class="link-container" style="text-align: right">
                    <a href="/news/1" class="news-link">Read More / Comment...</a>
                </div>
            </div>

            <br/>

            <div class="announcement">
                <div style="font-size: 14px">
                    17.01.2024
                    <b style="color: rgb(127,48,38); display: inline">Waffle Development Progress</b>

                    (Furball)</div>
                <hr>
                <div class="news-text" style="margin-bottom: -2px">
                    Beatmap Submission System fully working! <br/>
                    Website making very fast progress..
                </div>

                <div class="link-container" style="text-align: right">
                    <a href="/news/1" class="news-link">Read More / Comment...</a>
                </div>
            </div>

            <br/>
        </div>
        <div class="online-user-stats">
            <p class="heading-text" style="display: inline">Online users</p>
            <p class="heading-text" style="display: inline; font-size: 8pt">over the last 24 hours</p>
            <div class="activity-graph" style="margin: auto; width: 100%; text-align: right">
                <img src="/stats/activity-graph"/>
            </div>
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
                                    <td class="chat-time">{{ date('H:i', strtotime($messages[$i]->date)) }}</td>
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
        <div class="button-container" style="text-align: center">
            <a href="/download"><img height="60" style="margin-bottom: 2px" src="assets/button-download.png" alt="Download"/></a>
            <a href="/discord"><img height="60" style="text-align: center" src="assets/button-join.png" alt="Join the Discord"/></a>
            <a href="/contribute"><img height="60" style="text-align: center" src="assets/button-contribute.png" alt="Contribute"/></a>
        </div>

        <br/>

        <p class="heading-text" style="display: inline">Featured Video</p>
        <br/>
        <br/>
        <a href="https://www.youtube.com/watch?v=VsutC3vm0Ec">
            <img src="featured-vid.jpg" width="420" height="240"/>
        </a>
     </div>

@endsection
