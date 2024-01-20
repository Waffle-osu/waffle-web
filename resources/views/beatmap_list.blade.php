@extends('layout')

@section('title', 'Beatmap Listing')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="beatmap-content" style="width: 100%">
        <p class="heading-text" style="font-size: 16pt">Beatmap Listing</p>

        <br/>

        <p style="font-size: 8pt">Hover over an item to uncover quick links.</p>
        <p style="font-size: 8pt">Click a thumbnail to hear an audio preview.</p>

        <div class="beatmap-filters" style="width: 100%; text-align: right; font-size: 8pt">
            <form name="filter">
                <label for="search">Search:</label>
                <input id="search" type="text" name="search">

                <input type="submit" value="search" id="search-button" style="border-radius: 0">

                <label for="status">Display:</label>
                <select id="status" name="status" style="border: 1px solid" onchange="document.filter.submit()">
                    <option value="1" selected="">Ranked</option>
                    <option value="2">Approved</option>
                    <option value="0">Pending/Help</option>
                    <option value="-1">Graveyard</option>
                    <option value="3">Waffle-only</option>
                    <option value="-2">All</option>
                </select>

                <label for="genre">Genre:</label>
                <select id="genre" name="genre" style="border: 1px solid" onchange="document.filter.submit()">
                    <option value="0" selected="">Any</option>
                    <option value="1">Unspecified</option>
                    <option value="2">Video Game</option>
                    <option value="3">Anime</option>
                    <option value="4">Rock</option>
                    <option value="5">Pop</option>
                    <option value="6">Other</option>
                    <option value="7">Novelty</option>
                    <option value="9">Hip Hop</option>
                    <option value="10">Techno</option>
                </select>

                <label for="lang">Language:</label>
                <select id="lang" name="lang" style="border: 1px solid" onchange="document.filter.submit()">
                    <option value="0" selected="">Any</option>
                    <option value="2">English</option>
                    <option value="3">Japanese</option>
                    <option value="4">Chinese</option>
                    <option value="5">Instrumental</option>
                    <option value="6">Korean</option>
                    <option value="1">Other</option>
                    <option value="7">French</option>
                    <option value="8">German</option>
                    <option value="9">Swedish</option>
                    <option value="10">Spanish</option>
                    <option value="11">Italian</option>
                </select>
            </form>
        </div>

        <div class="results">
            {{ json_encode($beatmaps) }}
        </div>
    </div>
@endsection
