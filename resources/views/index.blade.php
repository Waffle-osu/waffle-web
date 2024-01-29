@php use App\Http\Controllers\IndexController; @endphp
@extends('layout')

@section('title', 'Main Page')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="left-side" style="width: 100%; position: relative">
        <div class="announcements">
            <p class="heading-text">Announcements</p>
            <br/>
            <div class="announcement">
                <div style="font-size: 14px">
                    01.03.2024
                    <b style="color: rgb(127,48,38); display: inline">Waffle is released!</b>

                    (Furball)
                </div>
                <hr>
                <div class="news-text" style="margin-bottom: -2px">
                    Waffle is finally released! (absolute lie, impossible) <br/>
                    Experts believe Waffle may release very late this decade...
                </div>

                <div class="link-container" style="text-align: right">
                    <a href="/news/3" class="news-link">Read More / Comment...</a>
                </div>
            </div>

            <br/>

            <div class="announcement">
                <div style="font-size: 14px">
                    17.01.2024
                    <b style="color: rgb(127,48,38); display: inline">Waffle Development Progress</b>

                    (Furball)
                </div>
                <hr>
                <div class="news-text" style="margin-bottom: -2px">
                    Beatmap Submission System fully working! <br/>
                    Website making very fast progress..
                </div>

                <div class="link-container" style="text-align: right">
                    <a href="/news/2" class="news-link">Read More / Comment...</a>
                </div>
            </div>

            <br/>

            <div class="previous-annoucements" style="font-size: 8pt">
                <p style="border-bottom: solid 1px #CF4D37; ">Previous Announcements</p>

                <p style="display: inline">31.12.2023</p>
                <a style="display: inline" href="/news/1">2023 comes to an end!</a>
                <p style="display: inline">(Furball)</p>

                <br/>

                <p style="display: inline">26.12.2023</p>
                <a style="display: inline" href="/news/1">ppv1 planned!</a>
                <p style="display: inline">(Furball)</p>

                <br/>

                <p style="display: inline">25.12.2023</p>
                <a style="display: inline" href="/news/1">Multiplayer commands are coming!</a>
                <p style="display: inline">(Furball)</p>

            </div>


            <br/>
        </div>
        <div class="put-bottom" style="bottom: 0; position: absolute;">
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
                            @php
                                $chatRowClass = "light-row";

                                if($i % 2 != 0) {
                                    $chatRowClass = "dark-row";
                                }
                            @endphp

                            <tr class="{{ $chatRowClass }}">
                                <td class="chat-time">{{ date('H:i', strtotime($messages[$i]->date)) }}</td>

                                @if(str_contains($messages[$i]->message, 'ACTION'))
                                    <td class="chat-msg">{{ $messages[$i]->username  }}: {{ IndexController::formatActionString($messages[$i]->message) }}</td>
                                @else
                                    <td class="chat-msg">{{ $messages[$i]->username  }}: {{ $messages[$i]->message }}</td>
                                @endif


                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="right-side">
        <div class="button-container" style="text-align: center">
            <a href="/download"><img height="60" style="margin-bottom: 2px" src="assets/button-download.png"
                                     alt="Download"/></a>
            <a href="/discord"><img height="60" style="text-align: center" src="assets/button-join.png"
                                    alt="Join the Discord"/></a>
            <a href="/contribute"><img height="60" style="text-align: center" src="assets/button-contribute.png"
                                       alt="Contribute"/></a>
        </div>

        <br/>

        <p class="heading-text" style="display: inline">Featured Video</p>
        <br/>
        <br/>
        <a href="https://www.youtube.com/watch?v=VsutC3vm0Ec">
            <img src="featured-vid.jpg" width="420" height="240"/>
        </a>

        <br/>
        <br/>

        <p class="heading-text" style="display: inline">Most played Beatmaps</p>


        <div class="most-played-table">
            <table style="width: 100%; border: 1px; border-radius: 3px; font-size: 8pt">
                <tbody>
                <tr>
                    <td>Plays</td>
                    <td>Artist / Title</td>
                    <td>Creator</td>
                </tr>
                @for($i = 0; $i != 5; $i++)
                    @php
                        $rowClass = "light-row";

                        if($i % 2 != 0) {
                            $rowClass = "dark-row";
                        }
                    @endphp

                    <tr class="{{$rowClass}}" style="font-size: 8pt">
                        <td>
                            {{ $most_played[$i]->plays }}
                        </td>
                        <td>
                            <img src="{{ env("WAFFLE_BANCHO_WEB_URL") . "/mt/" . $most_played[$i]->beatmapset_id  }}"
                                 alt="thumbnail"/>
                            <a href="/beatmapsets/{{ $most_played[$i]->beatmapset_id }}" style=" vertical-align: top;">
                                {{ $most_played[$i]->artist . " - " . $most_played[$i]->title }}
                            </a>
                        </td>
                        <td>
                            @if($most_played[$i]->creator_id < 0)
                                <a href="/users/{{-$most_played[$i]->creator_id}}">{{$most_played[$i]->creator}}</a>
                            @else
                                <a href="/redirect/bancho/users/{{$most_played[$i]->creator_id}}">{{$most_played[$i]->creator}}</a>
                            @endif
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

@endsection
