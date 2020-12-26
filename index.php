<?php
    require 'C:/Users/Bennet/vendor/autoload.php';
    require "partials/scripts/utils.php";

    session_start();
    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $api->setAccessToken($_SESSION["accessToken"]);
    $_SESSION["api"] = $api;


?>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="static/style/style.css">
        <title>Spotify</title>
    </head>
    <body>
        <?php require 'partials/sidebar.php'; ?>
        <?php require 'partials/player.php'; ?>
        <div class="content">
            <div id="topbar">
                <a href="partials/scripts/login.php" class="material-icons md-48" id="account">account_circle</a>
                <form id="search" action="search.php" method="GET">
                    <input type="text" name="query" id="query" autocomplete="off" placeholder="Search">
                </form>
            </div>
            <div id="loaded-content">
                <?php include 'partials/home.php'; ?>
            </div>
        </div>
        <script>
            function millisToMinutesAndSeconds(millis) {
                var minutes = Math.floor(millis / 60000);
                var seconds = ((millis % 60000) / 1000).toFixed(0);
                return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
            }
            async function getTrack(id){
                const response = await fetch("partials/scripts/getTrack.php?id=" + id);
                return await response.json();
            }
            window.onSpotifyWebPlaybackSDKReady = () => {
                current_track = "";
                duration = 0;
                const token = "<?php echo $_SESSION["accessToken"] ?>";
                const player = new Spotify.Player({
                    name: 'Spotify Clone',
                    getOAuthToken: cb => {
                        cb(token);
                    }
                });
                window.player = player;

                function join_artists(artists) {
                    var artist_names = [];
                    for (i = 0; i < artists.length; i++) {
                        artist_names.push(artists[i].name);
                    }
                    return artist_names.join(", ");
                }

                // Error handling
                window.player.addListener('initialization_error', ({message}) => {
                    console.error(message);
                });
                window.player.addListener('authentication_error', ({message}) => {
                    console.error(message);
                });
                window.player.addListener('account_error', ({message}) => {
                    console.error(message);
                });
                window.player.addListener('playback_error', ({message}) => {
                    console.error(message);
                });

                // Playback status updates
                window.player.addListener('player_state_changed', state => {
                    if(state.shuffle && !document.getElementById("shuffle").classList.contains("active")){
                        document.getElementById("shuffle").classList.add("active");
                    } else if(!state.shuffle && document.getElementById("shuffle").classList.contains("active")){
                        document.getElementById("shuffle").classList.remove("active");
                    }
                    if(current_track !== state.track_window.current_track.id){
                        current_track = state.track_window.current_track.id;
                        getTrack(current_track).then(function (track) {
                            duration = Number(track.duration_ms);
                            track_len = millisToMinutesAndSeconds(track.duration_ms);
                            document.getElementById("end-time").innerHTML = track_len;
                        })
                    }
                    position_number = Number(state.position);
                    document.getElementById("time-passed").style.transition = "";
                    document.getElementById("time-passed").style.width = String(position_number / duration * 100) + "%";
                    document.getElementById("current-time").innerHTML = millisToMinutesAndSeconds(state.position);
                    document.getElementById("time-passed").offsetHeight;
                    if(state.paused === true){
                        document.getElementById("play-arrow").innerHTML = "play_arrow";
                    }
                    else{
                        document.getElementById("time-passed").style.transition = "width " + String((duration - position_number) / 1000) + "s linear";
                        document.getElementById("time-passed").style.width = "100%";
                        document.getElementById("play-arrow").innerHTML = "pause";
                    }
                    document.getElementById("player-cover").style.backgroundImage = "url('" + state.track_window.current_track.album.images[0].url + "')";
                    document.getElementById("current-title").innerHTML = state.track_window.current_track.name;
                    document.getElementById("current-artist").innerHTML = join_artists(state.track_window.current_track.artists);
                });

                // Ready
                window.player.addListener('ready', ({device_id}) => {
                    console.log('Ready with Device ID', device_id);
                });

                // Not Ready
                window.player.addListener('not_ready', ({device_id}) => {
                    console.log('Device ID has gone offline', device_id);
                });

                // Connect to the player!
                window.player.connect();

            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="static/js/script.js"></script>
    </body>
</html>
