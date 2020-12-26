<?php
    require 'C:/Users/Bennet/vendor/autoload.php';

    $session = new SpotifyWebAPI\Session(
        '',
        '',
        'http://localhost/spotify/partials/scripts/callback.php'
    );

    $options = [
        'scope' => [
            'playlist-read-private',
            'playlist-read-collaborative',
            'user-read-private',
            "user-follow-read",
            "user-read-recently-played",
            "streaming",
            "user-read-email",
        ],
    ];

    header('Location: ' . $session->getAuthorizeUrl($options));
    die();