<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=865, user-scalable=yes">

        <meta property="og:site_name" content="osu!Waffle">
        <meta property="og:type" content="website">

        <title>osu!Waffle - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="app.css"/>

        @yield('additional-head')

        <!-- Styles -->
        <style>
            html, body {
                font-family: Figtree, serif;
                background: #CF4D37 repeat-x;
                width: 100vw;
                min-height: 100vh;
            }

            @yield('additional-style')
        </style>

        <script>
            @yield('additional-script')
        </script>
    </head>
    <body class="main">
        <div class="nav">
            <ul class="nav-list">
                <li class="nav-element"><a href="/">Home</a></li>
                <li class="nav-element"><a href="/download">Download</a></li>

                <li class="nav-element nav-element-dropdown">
                    <a href="/beatmaps">Beatmaps</a>

                    <ul class="nav-dropdown">
                        <li style="margin-top: -3px"><a href="/beatmaps/ranked">Ranked</a></li>
                        <li><a href="/beatmaps/approved">Approved</a></li>
                        <li><a href="/beatmaps/waffle">Waffle-only</a></li>
                        <li><a href="/beatmaps/packs">Beatmap Packs</a></li>
                    </ul>
                </li>
                <li class="nav-element nav-element-dropdown">
                    <a href="/rankings/score">Rankings</a>

                    <ul class="nav-dropdown">
                        <li style="margin-top: -3px"><a href="/rankings/score">Ranked Score</a></li>
                    </ul>
                </li>
                <li class="nav-element nav-element-dropdown">
                    <a href="/community/forums">Community</a>

                    <ul class="nav-dropdown">
                        <li style="margin-top: -3px"><a href="/community/forums">Forums</a></li>
                        <li><a href="/community/discord">Discord</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="bancho-stats">
            <b>69,420</b> users, <b>100</b> online now. <br/>
            A total of <b>350.21m</b> ranked plays!
        </div>
        <div class="content" style="position: relative">
            <div class="top">
                <div class="search-container">
                    <form class="search-form">
                        <input class="nav-search" type="text" id="beatmap-search" name="beatmaps" placeholder="Beatmap" autocomplete="off">
                    </form>
                    <form class="search-form">
                        <input class="nav-search" type="text" id="user-search" name="users" placeholder="User" autocomplete="off">
                    </form>
                </div>
                <div class="login-container">
                    @if($user === null)
                        <form class="search-form" action="/login" method="post">
                            @csrf

                            <b class="nav-login" style="font-size: 9pt; line-height: 16px">user: </b>
                            <input style="height: 12px" class="nav-search" type="text" id="login-username" name="username" autocomplete="off">

                            <b class="nav-login" style="font-size: 9pt; line-height: 16px">pass: </b>
                            <input style="height: 12px" class="nav-search" type="password" id="login-password" name="password" autocomplete="off">

                            <a href="/login/forgot" style="color: #ad2a2a; text-decoration: none">? </a>
                            &nbsp;
                            <a href="/login/register" style="color: #ad2a2a; text-decoration: none">register</a>
                            &nbsp;

                            <input type="checkbox" id="save-checkbox">
                            &nbsp;
                            <label for="save-checkbox">save</label>

                            &nbsp;
                            <input style="border-radius: 0; font-size: 9pt" type="submit" name="login" value=" login " tabindex="5">
                        </form>
                    @else
                        <p>Hello,</p>
                        <a href="{{ "/users/" . $user->user_id }}" style="font-weight: bold">{{ $user->username }}</a>
                        &nbsp;

                        <a href="/profile/settings">
                            <img src="{{ env("AVATAR_PATH") . "/" . $user->user_id }}" height="24" alt="Avatar"/>
                        </a>

                        |
                        <a href="/forum/messages">1 unread message</a> |
                        <a href="/forum/search">Search</a> |
                        <a href="/profile/settings">Settings</a> |
                        <a href="/logout">Logout</a> |
                    @endif

                </div>
            </div>
            <div class="login-dropdown" style="display: none"></div>
            <div class="page">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
            <div class="copyright-text" style=" text-align: center; width: 100%; position: absolute; bottom: 0;">
                <a href="https://github.com/Eeveelution" style="text-decoration: none; color: black; font-size: 7pt">waffle by furball</a>
            </div>
        </div>
        <div id="footer">
            <p style="text-align: center; width: 100%; font-size: 7pt">
                credit to <a href="https://github.com/osuTitanic">Levi from osu!Titanic</a> for the CSS for the website <br/>
                you saved me a lot of pain and suffering xd
            </p>
        </div>

    </body>
</html>
