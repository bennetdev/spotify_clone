<?php
    require 'C:/Users/Bennet/vendor/autoload.php';

    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $api->setAccessToken($_SESSION["accessToken"]);
    $myPlaylists = $api->getUserPlaylists($api->me()->id);
    $last_played = $api->getMyRecentTracks([
            "limit" => 1
    ]);
?>

<div id="sidebar">
    <div class="navigation">
        <a href="home.php">Home</a>
        <div class="section">
            <h7>PLAYLISTS</h7>
            <?php foreach ($myPlaylists->items as $myPlaylist) { ?>
                <a href="playlist.php?id=<?php echo $myPlaylist->id ?>"><?php echo $myPlaylist->name ?></a>
            <?php } ?>
        </div>
    </div>
    <div id="player-cover" style="background-image: url('<?php echo $last_played->items[0]->track->album->images[0]->url ?>')"></div>
</div>