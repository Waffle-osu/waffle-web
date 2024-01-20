@php use App\Http\Controllers\BeatmapListController; @endphp
@extends('layout')

@section('title', 'Beatmap Listing')

@section('additional-head')
    <meta property="og:image" content="/*link here*/">
    <meta property="og:title" content="osu!Waffle">
    <meta property="og:description" content="osu!Waffle is a server for old versions of osu!">

    <script>
        let previousExpanded;
        function expandRow(setId)
        {
            if(previousExpanded !== undefined) {
                previousExpanded.style.maxHeight = "0px";
                previousExpanded.style.transition = "0.5s";
            }

            const element = document.getElementById("info" + setId);

            setTimeout(() => {
                element.style.maxHeight = "15px";
                element.style.transition = "0.5s";
            }, 0)

            previousExpanded = element;
        }

        function shrinkRows()
        {

        }

        function favouriteMap(map) {
            fetch("/actions/favourite/" + map);
        }
    </script>



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
                    <option value="1"  {{ $status == "1"  ? "selected" : "" }} >Ranked</option>
                    <option value="2"  {{ $status == "2"  ? "selected" : "" }}>Approved</option>
                    <option value="0"  {{ $status == "0"  ? "selected" : "" }}>Pending/Help</option>
                    <option value="-1" {{ $status == "-1" ? "selected" : "" }}>Graveyard</option>
                    <option value="3"  {{ $status == "3"  ? "selected" : "" }}>Waffle-only</option>
                    <option value="-2" {{ $status == "-2" ? "selected" : "" }}>All</option>
                </select>

                <label for="genre">Genre:</label>
                <select id="genre" name="genre" style="border: 1px solid" onchange="document.filter.submit()">
                    <option value="0"  {{ $genre == "0" ? "selected" : "" }}>Any</option>
                    <option value="1"  {{ $genre == "1" ? "selected" : "" }}>Unspecified</option>
                    <option value="2"  {{ $genre == "2" ? "selected" : "" }}>Video Game</option>
                    <option value="3"  {{ $genre == "3" ? "selected" : "" }}>Anime</option>
                    <option value="4"  {{ $genre == "4" ? "selected" : "" }}>Rock</option>
                    <option value="5"  {{ $genre == "5" ? "selected" : "" }}>Pop</option>
                    <option value="6"  {{ $genre == "6" ? "selected" : "" }}>Other</option>
                    <option value="7"  {{ $genre == "7" ? "selected" : "" }}>Novelty</option>
                    <option value="9"  {{ $genre == "9" ? "selected" : "" }}>Hip Hop</option>
                    <option value="10" {{ $genre == "10" ? "selected" : "" }}>Techno</option>
                </select>

                <label for="lang">Language:</label>
                <select id="lang" name="lang" style="border: 1px solid" onchange="document.filter.submit()">
                    <option value="0" {{ $language == "0" ? "selected" : "" }}>Any</option>
                    <option value="2" {{ $language == "2" ? "selected" : "" }}>English</option>
                    <option value="3" {{ $language == "3" ? "selected" : "" }}>Japanese</option>
                    <option value="4" {{ $language == "4" ? "selected" : "" }}>Chinese</option>
                    <option value="5" {{ $language == "5" ? "selected" : "" }}>Instrumental</option>
                    <option value="6" {{ $language == "6" ? "selected" : "" }}>Korean</option>
                    <option value="1" {{ $language == "1" ? "selected" : "" }}>Other</option>
                    <option value="7" {{ $language == "7" ? "selected" : "" }}>French</option>
                    <option value="8" {{ $language == "8" ? "selected" : "" }}>German</option>
                    <option value="9" {{ $language == "9" ? "selected" : "" }}>Swedish</option>
                    <option value="10" {{ $language == "10" ? "selected" : "" }}>Spanish</option>
                    <option value="11" {{ $language == "11" ? "selected" : "" }}>Italian</option>
                </select>
            </form>
        </div>

        <br/>
        <br/>

        <div class="pagination">
            <p class="regular-text" style="text-align: center">
                Displaying {{ ($page * 20) + 1 }} to {{ min(($page * 20) + $resultsPerPage, $mapCount) }} of {{ $mapCount }} results
            </p>
        </div>

        <div class="results">
            <table style="border-spacing: 0; width: 100%">
                <thead>
                <tr style="background: #fbd2d2">
                    <td class="result-td regular-text"></td>
                    <td class="result-td regular-text">Title</td>
                    <td class="result-td regular-text">Artist</td>
                    <td class="result-td regular-text">Creator</td>
                    <td class="result-td regular-text">Difficulty</td>
                    <td class="result-td regular-text">Approved</td>
                    <td class="result-td regular-text">User Rating</td>
                    <td class="result-td regular-text">Plays</td>
                    <td class="result-td regular-text">Pack</td>
                    <td class="result-td regular-text">Genre</td>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i != count($beatmaps); $i++)
                    @php($colorClass = $i % 2 != 0 ? "dark-row" : "light-row")
                    @php($current = $beatmaps[$i])

                    <tr onmouseenter="expandRow({{ $current->beatmapset_id  }})" onmouseleave="shrinkRows()" class="{{ $colorClass }}">
                        <td class="result-td">
                            <img src="{{ env("WAFFLE_BANCHO_WEB_URL") . "/mt/" . $current->beatmapset_id }}" width="80"/>
                        </td>

                        <td class="result-td">
                            @if($current->has_video)
                                <img src="assets/video-icon.png" class="video-icon"
                                     style="vertical-align: middle; display: inline-block; width: 20px; height: 23px; padding-right: 4px; float: left"/>
                            @endif

                            @if($current->has_storyboard)
                                <img src="assets/storyboard-icon.png" class="video-icon"
                                     style="vertical-align: middle; display: inline-block; width: 20px; height: 23px; padding-right: 4px; float: left"/>
                            @endif

                            <a class="regular-text" href="/beatmapsets/{{$current->beatmapset_id}}"
                               style=" vertical-align: middle;">{{ $current->title }}</a>
                        </td>

                        <td class="result-td">
                            <p class="regular-text">{{ $current->artist  }}</p>

                            @if($current->source !== "")
                                <p class="source-text">{{ $current->source }}</p>
                            @endif
                        </td>

                        <td class="result-td">
                            @if($current->creator_id > 0)
                                <a class="regular-text"
                                   href="/redirect/bancho/users/{{ $current->creator_id }}">{{$current->creator}}</a>
                            @else
                                <a class="regular-text"
                                   href="/redirect/bancho/users/{{ -$current->creator_id }}">{{$current->creator}}</a>
                            @endif
                        </td>

                        <td class="result-td" style="width: 96px">
                            <img src="assets/diff/insane.png"/>
                        </td>

                        <td class="result-td" style="min-width: 70px">
                            <p class="regular-text">{{ date("M j, Y", strtotime($current->approve_date))  }}</p>

                            @if($current->beatmapset_id >= 0)
                                <p style="font-size: 7pt">Ranked by Furball</p>
                            @endif
                        </td>

                        <td class="result-td">
                            @if($current->votes === 0)
                                <p style="font-size: 7pt; text-align: center">-</p>
                                <p style="font-size: 7pt; text-align: center">needs a vote!</p>
                            @else
                                <p style="font-size: 8pt; text-align: center; font-weight: bold">{{ round($current->rating_sum / $current->votes, 2) }}</p>
                                @if($current->votes === 1)
                                    <p style="font-size: 7pt; text-align: center">1 vote</p>
                                @else
                                    <p style="font-size: 7pt; text-align: center">{{ $current->votes  }} votes</p>
                                @endif

                            @endif
                        </td>

                        <td class="result-td" style="width: 55px">
                            <p class="regular-text" style="text-align: center">{{ number_format($current->plays) }}</p>
                        </td>

                        <td class="result-td">
                            @if($current->beatmap_pack !== "")
                                <img src="assets/tick.png"/>
                                <br/>
                                <p style="font-size: 8pt">{{ explode(',', $current->beatmap_pack)[0] }}</p>
                            @endif
                        </td>

                        <td class="result-td">
                            <a class="regular-text" href="/beatmaps?genre={{$current->genre_id}}">
                                {{ BeatmapListController::formatGenreId($current->genre_id) }}
                            </a>

                            <br/>

                            <a class="regular-text" href="/beatmaps?lang={{$current->language_id}}" style="margin-top: -4px">
                                {{ BeatmapListController::formatLanguageId($current->language_id) }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <div id="info{{ $current->beatmapset_id  }}" class="expandableInfo">
                                <b class="regular-text" style="">Quick Links: </b>

                                <a class="regular-text" style="" href="/beatmapsets/{{ $current->beatmapset_id }}">Scores & Details</a>

                                @if($user !== null)
                                    <p class="regular-text" style="display: inline; margin-left: -2px;">|</p>

                                    <a class="regular-text" style="" href="{{ env("WAFFLE_BANCHO_WEB_URL") . "/d/" .$current->beatmapset_id . ".osz" }}">Download</a>

                                    <p class="regular-text" style="display: inline; margin-left: -2px;">|</p>

                                    @if($current->beatmapset_id >= 10000000)
                                        <a class="regular-text" style="" href="/forum/beatmap/{{$current->beatmapset_id}}">Forum Topic</a>
                                    @else
                                        <a class="regular-text" style="" href="/redirect/bancho/beatmapset/{{$current->beatmapset_id}}">Link to Bancho</a>
                                    @endif

                                    <p class="regular-text" style="display: inline; margin-left: -2px;">|</p>

                                    <a class="regular-text" onclick="favouriteMap({{ $current->beatmapset_id }})">Add to Favourites</a>
                                @endif
                            </div>
                        </td>
                    </tr>

                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
