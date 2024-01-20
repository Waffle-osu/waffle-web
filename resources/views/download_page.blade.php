@extends('layout')

@section('title', 'Download')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="site-content" style="width: 100%">
        <p class="heading-text">Let's get you started!</p>

        <br/>

        <div class="version-list" style="margin-bottom: 24px">
            <p>Currently, the only versions that are supported are:</p>
            <ul>
                <li>Every IRC-Bancho client. (b130 onwards to at least b222)</li>
                <li>b1815</li>
                <li>More soon~  </li>
            </ul>
        </div>

        <p class="heading-text" style="text-align: center">Click to Download!</p>

        <br/>

        <div class="version-buttons" style="display: flex; width: 100%; flex-direction: row; justify-content: space-evenly">
            <div class="version-button">
                <a href="/download/b170">
                    <img src="/assets/version-b170.png" alt="b170 version screenshot"/>
                </a>
            </div>

            <div class="version-button">
                <a href="/download/b1815">
                    <img src="/assets/version-b1815.png" alt="b1815 version screenshot"/>
                </a>
            </div>
        </div>

        <br/>

        <p>
            Each one of those will download a pUpdater specific for the version you chose.
            Run the executable inside the folder you want the osu! install to live in.
            From that updater you can also choose extras like old bundled updater skins and more!
        </p>
    </div>
@endsection
