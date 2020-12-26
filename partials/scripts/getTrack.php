<?php
require 'C:/Users/Bennet/vendor/autoload.php';
session_start();
$id = $_GET["id"];
$api = $_SESSION["api"];
$track = $api->getTrack($id);
echo json_encode($track);