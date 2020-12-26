<?php
require 'C:/Users/Bennet/vendor/autoload.php';
session_start();
$id = $_POST["id"];
$api = $_SESSION["api"];
$tracks = $api->getPlaylistTracks($id);
foreach ($tracks->items as $song) {
    $api->queue($song->track->id);
}