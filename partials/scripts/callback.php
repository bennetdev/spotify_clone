<?php
    session_start();
    require 'C:/Users/Bennet/vendor/autoload.php';
    $session = new SpotifyWebAPI\Session(
        '',
        '',
        'http://localhost/spotify/partials/scripts/callback.php'
    );

    // Request a access token using the code from Spotify
    $session->requestAccessToken($_GET['code']);

    $accessToken = $session->getAccessToken();
    $refreshToken = $session->getRefreshToken();

    // Store the access and refresh tokens somewhere. In a database for example.
    $_SESSION["accessToken"] = $accessToken;
    $_SESSION["refreshToken"] = $refreshToken;
    // Send the user along and fetch some data!
    header('Location: ../../index.php');
    die();