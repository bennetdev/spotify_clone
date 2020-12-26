<?php
require 'C:/Users/Bennet/vendor/autoload.php';
require "scripts/utils.php";
session_start();
$api = $_SESSION["api"];
$id = $_GET["id"];
$album = $api->getAlbum($id);
echo '
<div class="detail">
    <div class="infos">
        <div class="cover hover-play" style="background-image: url('. $album->images[0]->url . ')">
            <span class="material-icons play-icon md-48 play-arrow">play_arrow</span>
        </div>
        <div class="facts">
            <h1 class="title">'. $album->name . '</h1>
            <p class="subtitle">'. join_artists($album->artists) . '</p>
            <p class="subtitle">Released '. $album->release_date . ", " . count($album->tracks->items) . ' tracks</p>
        </div>
    </div>
    <table class="tracklist">
        <tr>
            <th id="numcol">#</th>
            <th id="playcol"></th>
            <th id="titlecol">TITLE</th>
            <th id="timecol"><span class="material-icons">schedule</span></th>
        </tr>';
        foreach ($album->tracks->items as $song) { echo '
            <tr class="track">
                <td><h5 class="number">'. $song->track_number. '</h5></td>
                <td><a class="play-track material-icons" href="playTrack?id='. $song->id .'">play_circle_outline</a></td>
                <td>
                    <div class="trackname">
                        <h5 class="name">'. $song->name . '</h5>
                        <p class="subtitle">' . get_features($song->artists, $album) . '</p>
                    </div>
                </td>
                <td>
                    <h5 class="tracktime">' . ms_to_display_minutes($song->duration_ms). '</h5>
                </td>
            </tr>';
        }
        echo '
    </table>
</div>';
