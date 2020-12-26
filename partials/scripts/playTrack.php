<?php
require 'C:/Users/Bennet/vendor/autoload.php';
session_start();
$id = $_POST["id"];
$api = $_SESSION["api"];
$api->queue($id);