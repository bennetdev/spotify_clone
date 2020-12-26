<?php
require 'C:/Users/Bennet/vendor/autoload.php';
require "scripts/utils.php";


session_start();
$query = $_GET["query"];
$api = $_SESSION["api"];
$artists = $api->search($query, "artist", [
    "limit" => 5
]);
$songs = $api->search($query, "track", [
    "limit" => 5
]);
$albums = $api->search($query, "album", [
    "limit" => 5
]);
$playlists = $api->search($query, "playlist", [
    "limit" => 5
]);
echo '

<div class="gridview">
    <div class="artists">
        <h3>Artists</h3>
        <hr>';
        foreach ($artists->artists->items as $artist) {
            if (count($artist->images) > 0) { echo '
                <div class="artist">
                    <div class="artist-avatar hover-play" style="background-image: url('. end($artist->images)->url . ')">
                    </div>
                    <a href="artist.php?id=' . $artist->id. '"><h3 class="name">' . $artist->name . '</h3></a>
                </div>';
            }
        } echo '
    </div>
    <div class="albums">
        <h3>Albums</h3>
        <hr>';
        foreach ($albums->albums->items as $album) {
            if (count($album->images) > 0) { echo '
                <div class="album">
                    <div class="hover-play" style="background-image: url('. end($album->images)->url . ')">
                        <a href="playalbum?id=' .$album->id . '" class="play-album material-icons play-icon md-48 play-arrow">play_arrow</a>
                    </div>
                    <div class="names">
                        <a href="album.php?id=' . $album->id . '"><h3 class="title">' . $album->name . '</h3></a>
                        <p class="subtitle">' . join_artists($album->artists) . '</p>
                    </div>
                </div>';
            }
        } echo '
    </div>
    <div class="songs">
        <h3>Songs</h3>
        <hr>';
        foreach ($songs->tracks->items as $song) {
            if (count($song->album->images) > 0) { echo '
                <div class="song">
                    <div class="hover-play"
                         style="background-image: url(' . end($song->album->images)->url . ')">
                        <a href="playtrack?id=' .$song->id . '" class="play-track material-icons play-icon md-48 play-arrow">play_arrow</a>
                    </div>
                    <div class="names">
                        <h3 class="title">' . $song->name . '</h3>
                        <p class="subtitle">' . join_artists($song->artists) . '</p>
                    </div>
                </div>';
            }
        } echo '
    </div>
    <div class="playlists">
        <h3>Playlists</h3>
        <hr>';
        foreach ($playlists->playlists->items as $playlist) {
            if (count($playlist->images) > 0) { echo '
                <div class="playlist">
                    <div class="hover-play"
                         style="background-image: url(' . end($playlist->images)->url . ')">
                        <a href="playplaylist?id=' .$playlist->id . '" class="play-playlist material-icons play-icon md-48 play-arrow">play_arrow</a>
                    </div>
                    <a href="playlist.php?id=' . $playlist->id . '"><h3 class="title">' . $playlist->name . '</h3></a>
                </div>';
            }
        } echo '
    </div>
</div>';
