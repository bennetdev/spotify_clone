<?php
require 'C:/Users/Bennet/vendor/autoload.php';

session_start();
$api = $_SESSION["api"];
$playlists = $api->getUserPlaylists($api->me()->id, [
    'limit' => 10
]);
$followed_artists = $api->getUserFollowedArtists([
    'limit' => 10
]);
$random_artist_index = array_rand($followed_artists->artists->items);
$artist_selected = explode(":", $followed_artists->artists->items[$random_artist_index]->uri);
$artist_id = end($artist_selected);
$artist_albums = $api->getArtistAlbums($artist_id);
$recently_played = $api->getMyRecentTracks();

echo '
<div class="preview" id="recently">';
    require "previewNav.php"; echo '
    <h2>Recently</h2>
    <hr>
    <div class="albums"> ';
        foreach ($recently_played->items as $recent) { echo '
            <div class="album">
                <div class="cover hover-play" style="background-image: url('. $recent->track->album->images[0]->url  . ')">
                    <span class="material-icons play-icon md-48 play-arrow">play_arrow</span>
                </div>
                <a href="album.php?id=' . $recent->track->album->id .'"><h4 class="name">'. $recent->track->album->name . '</h4></a>
                <p class="artist">' . $recent->track->album->artists[0]->name . '</p>
            </div>';
        }
        echo '
    </div>
</div>
<div class="preview" id="shortcuts">';
    require "previewNav.php"; echo '
    <h2>Playlists</h2>
    <hr>
    <div class="albums"> ';
        foreach ($playlists->items as $playlist) { echo '
            <div class="album">
                <div class="cover hover-play" style="background-image: url('. $playlist->images[0]->url  . ')">
                    <span class="material-icons play-icon md-48 play-arrow">play_arrow</span>
                </div>
                <a href="playlist.php?id=' . $playlist->id .'"><h4 class="name">' . $playlist->name . '</h4></a>
            </div>';
        }
        echo '
    </div>
</div>
<div class="preview" id="artist">';
    require "previewNav.php"; echo '
    <h2>Selected artist</h2>
    <hr>
    <div class="albums"> ';
        foreach ($artist_albums->items as $album) { echo '
            <div class="album">
                <div class="cover hover-play" style="background-image: url('. $album->images[1]->url  . ')">
                    <span class="material-icons play-icon md-48 play-arrow">play_arrow</span>
                </div>
                <a href="album.php?id=' . $album->id .'"><h4 class="name">' . $album->name . '</h4></a>
                <p class="artist">' . $album->artists[0]->name . '</p>
            </div>';
        }
        echo '
    </div>
</div>';
