<?php
require 'C:/Users/Bennet/vendor/autoload.php';
require "scripts/utils.php";
session_start();
$id = $_GET["id"];
$api = $_SESSION["api"];

$playlist = $api->getPlaylist($id);

echo '
<div class="detail">
    <div class="infos">
        <div class="cover hover-play" style="background-image: url('. $playlist->images[0]->url . ')">
            <span class="material-icons play-icon md-48 play-arrow">play_arrow</span>
        </div>
        <div class="facts">
            <h1 class="title">'. $playlist->name . '</h1>
            <p class="subtitle">'. $playlist->owner->display_name .'</p>
            <p class="subtitle">'. count($playlist->tracks->items) .' tracks, ' . $playlist->followers->total . " followers" . '</p>
        </div>
    </div>
    <table class="tracklist">
        <tr>
            <th id="playcol"></th>
            <th id="titlecol">TITLE</th>
            <th id="artistcol">ARTISTS</th>
            <th id="artistcol">ALBUM</th>
            <th id="timecol"><span class="material-icons">schedule</span></th>
        </tr>';
        foreach ($playlist->tracks->items as $song) {
            if(!is_null($song->track)) {
                echo '
            <tr class="track">
                <td><a class="play-track material-icons" href="playTrack?id='. $song->track->id .'">play_circle_outline</a></td>
                <td>
                    <div class="trackname">
                        <h5 class="name">' . $song->track->name . '</h5>
                    </div>
                </td>
                <td>
                    <div class="artistname">
                        <h5 class="name">' . join_artists($song->track->artists) . '</h5>
                    </div>
                </td>
                <td>
                    <div class="albumname">
                        <a href="album.php?id=' . $song->track->album->id . '"><h5 class="name">' . $song->track->album->name . '</h5></a>
                    </div>
                </td>
                <td>
                    <h5 class="tracktime">' . ms_to_display_minutes($song->track->duration_ms) . '</h5>
                </td>
            </tr>';
            }}
        echo '
    </table>
</div>';