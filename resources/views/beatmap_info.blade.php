@extends('layout')

@section('title', 'Title')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="beatmap-info-content" style="width: 100%">
        <a style="font-size: 16pt; display: inline; color: #264a7f">Beatmap Listing</a>
        <p class="heading-text" style="font-size: 16pt; display: inline">» {{ $beatmapset->artist }} - {{ $beatmapset->title }}</p>

        <br/>
        <br/>

        <div class="difficulty-tabs" style="width: 100%; border-bottom: solid #CF4D37 1px; height: 25px; margin-left: -9px">
            <ul style="list-style: none; margin: 0; padding: 0; display: block">
                @for($i = 0; $i != count($difficulties); $i++)
                    @php($current = $difficulties[$i])

                    <li class="difficulty-tab">
                        <a href="/beatmapsets/{{ $current->beatmapset_id }}/{{ $current->beatmap_id }}">
                            <x-difficulty-icon eyupStars="{{ $current->eyup_stars }}" mode="{{ $current->playmode }}" class="difficulty-icon"/>

                            <p style="display: inline-block; vertical-align: middle">
                                {{ $current->version  }}
                            </p>
                        </a>
                    </li>
                @endfor
            </ul>
        </div>

        <div>
            <table style="background-color: #fbd6d6">
                <tbody>
                    <tr style="height: 32px; font-size: 8pt;">
                        <td width="0">
                            Artist
                        </td>
                        <td width="23%">
                            {{$beatmapset->artist}}
                        </td>
                        <td width="0">
                            Circle Size
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
