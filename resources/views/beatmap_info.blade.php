@php use App\Http\Controllers\BeatmapListController; @endphp
@extends('layout')

@section('title', 'Title')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">
@endsection

@section('content')
    <div class="beatmap-info-content" style="width: 880px;">
        <a style="font-size: 16pt; display: inline; color: #264a7f">Beatmap Listing</a>
        <p class="heading-text" style="font-size: 16pt; display: inline">» {{ $beatmapset->artist }}
            - {{ $beatmapset->title }}</p>

        <br/>
        <br/>

        <div class="difficulty-tabs"
             style="width: 100%; border-bottom: solid #CF4D37 1px; height: 25px; margin-left: -9px">
            <ul style="list-style: none; margin: 0; padding: 0; display: block">
                @for($i = 0; $i != count($difficulties); $i++)
                    @php($current = $difficulties[$i])

                    <li class="difficulty-tab">
                        <a href="/beatmapsets/{{ $current->beatmapset_id }}/{{ $current->beatmap_id }}">
                            <x-difficulty-icon eyupStars="{{ $current->eyup_stars }}" mode="{{ $current->playmode }}" class="difficulty-icon"/>
                            <p style="display: inline-block; vertical-align: middle"> {{ $current->version  }} </p>
                        </a>
                    </li>
                @endfor
            </ul>
        </div>

        <div>
            <table style="background-color: #fbd6d6; width: 100%; margin-left: -9px">
                <tbody>
                    <tr style="font-size: 8pt; height: 30px">
                        <td width="0">
                            Artist:
                        </td>
                        <td width="23%">
                            {{$beatmapset->artist}}
                        </td>
                        <td width="80px">
                            Circle Size:
                        </td>
                        <td width="23%">
                            <div class="starfield" style="width: 140px">
                                @php($pixels = $currentDiff->diff_cs * 14)
                                <div class="active" style="width: {{ $pixels }}px"></div>
                            </div>
                        </td>
                        <td width="0">
                            Star Difficulty:
                        </td>
                        <td width="23%">
                            @php($stars = round($currentDiff->eyup_stars, 2))
                            @php($width = $stars * 14)

                            <div class="starfield" style="width: 70px">
                                <div class="active" style="width: {{ $width }}px"></div>
                            </div>

                            ({{$stars}})
                        </td>
                    </tr>

                    <tr style="font-size: 8pt;">
                        <td width="0">
                            Title:
                        </td>
                        <td width="23%">
                            {{$beatmapset->title}}
                        </td>
                        <td width="80px">
                            HP Drain:
                        </td>
                        <td width="23%">
                            <div class="starfield" style="width: 140px">
                                @php($pixels = $currentDiff->diff_hp * 14)
                                <div class="active" style="width: {{ $pixels }}px"></div>
                            </div>
                        </td>
                        <td width="0">
                            Total Time:
                        </td>
                        <td width="23%">
                            @php( $minutes = floor($currentDiff->total_length / 60) )
                            @php( $seconds = ($currentDiff->total_length - ($minutes * 60)) )

                            {{$minutes}}:{{$seconds}}
                        </td>
                    </tr>

                    <tr style="font-size: 8pt;">
                        <td width="0">
                            Creator:
                        </td>
                        <td width="23%">
                            {{$beatmapset->creator}}
                        </td>
                        <td width="80px">
                            Accuracy:
                        </td>
                        <td width="23%">
                            <div class="starfield" style="width: 140px">
                                @php($pixels = $currentDiff->diff_od * 14)
                                <div class="active" style="width: {{ $pixels }}px"></div>
                            </div>
                        </td>
                        <td width="0">
                            Draining Time:
                        </td>
                        <td width="23%">
                            @php( $minutes = floor($currentDiff->drain_time / 60) )
                            @php( $seconds = ($currentDiff->drain_time - ($minutes * 60)) )

                            {{$minutes}}:{{$seconds}}
                        </td>
                    </tr>

                    <tr style="font-size: 8pt;">
                        <td width="0">
                            Source:
                        </td>
                        <td width="23%">
                            {{$beatmapset->source}}
                        </td>
                        <td width="80px">
                            Genre:
                        </td>
                        <td width="23%">
                            <a>{{ BeatmapListController::formatGenreId($beatmapset->genre_id) }}</a>
                            <a>{{ BeatmapListController::formatLanguageId($beatmapset->language_id) }}</a>
                        </td>
                        <td width="0">
                            BPM:
                        </td>
                        <td width="23%">
                            {{ $beatmapset->bpm }}
                        </td>
                    </tr>

                    <tr style="font-size: 8pt; height: 30px">
                        <td width="0">
                            Tags:
                        </td>
                        <td width="23%">
                            @php($splitTags = explode(' ', $beatmapset->tags))

                            @for($i = 0; $i != count($splitTags); $i++)
                                <a>{{ $splitTags[$i] }}</a>
                            @endfor
                        </td>
                        <td width="80px">
                            User Rating:
                        </td>
                        <td width="23%">
                            <table style="width: 100%; height: 20px; color: white">
                                <tbody>
                                    <tr>
                                        <td style="background-color:#BC2036;text-align:right;border:solid 1px #82000B; width: 5.7%">11</td>
                                        <td style="width: 94.3%; background-color:#78AB23;text-align:left;border:solid 1px #718F0A">199</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td width="74px" rowspan="2">
                            Success Rate:
                            <br/>
                            Points of failure:
                            <br/>
                            <span style="font-size: 80%">
                                (graph is accumulative, based on % at fail/retry)
                            </span>
                        </td>
                        <td width="0" rowspan="2">
                            graph here
                        </td>
                    </tr>

                    <tr style="font-size: 8pt; height: 40px">
                        <td width="0">
                            Submitted:

                            <br/>

                            @if($currentDiff->ranking_status != 0)
                                Approved:
                            @endif
                        </td>
                        <td width="23%">
                            {{ date("M j, Y", strtotime($currentDiff->submit_date)) }}

                            <br/>

                            @if($currentDiff->ranking_status != 0)
                                {{ date("M j, Y", strtotime($currentDiff->approve_date)) }}
                            @endif
                        </td>
                        <td style="width: 80px">
                            Rating Spread:
                        </td>
                        <td width="74px">
                            &lt;insert graph here&gt;
                        </td>

                    </tr>

                    <tr style="font-size: 8pt">
                        <td colspan="4">
                            <b>Favourited {{ count($favourites) }} times</b> in total
                            <br/>
                            Users that love this map:
                            @for($i = 0; $i != count($favourites); $i++)
                                @php($current = $favourites[$i])

                                <a href="/users/{{ $current->user_id }}">{{ $current->username }}</a>
                            @endfor
                        </td>
                        <td>
                            Options:
                        </td>
                        <td>
                            <a >This Beatmap's Thread</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <br/>
            <br/>

            <p class="heading-text">Creators Words</p>

            <br/>

            <div class="padded-area" style="padding-left: 7px; padding-right: 8px;">
                <div class="download-button" style="margin-left: 8px; float: right">
                    @if($user != null)
                        <a href="/beatmaps/download/{{ $current->beatmapset_id }}">
                            <img src="/assets/beatmap-download.png"/>
                        </a>
                    @else
                        <a href="/login">
                            <img src="/assets/beatmap-download-login.png"/>
                        </a>
                    @endif
                </div>

                <div class="post-text" style="overflow: auto; font-size: 8pt">
                    <img src="{{ env("WAFFLE_BANCHO_WEB_URL") }}/mt/{{ $current->beatmapset_id }}l" style="float:left;padding:3px;width:160px;height:120px"/>

                    Currently unimplemented...
                </div>
            </div>

            <br/>
            <br/>

            <p class="heading-text">Song Ranking</p>

            <br/>
        </div>
    </div>
@endsection
