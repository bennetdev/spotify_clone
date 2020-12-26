<div id="player">
    <div id="controls">
        <span class="material-icons play-icon md-20" id="shuffle">shuffle</span>
        <span class="material-icons play-icon md-36" id="skip-previous">skip_previous</span>
        <span class="material-icons play-icon md-36" id="play-arrow">play_arrow</span>
        <span class="material-icons play-icon md-36" id="skip-next">skip_next</span>
        <span class="material-icons play-icon md-20" id="repeat">replay</span>
    </div>
    <div id="player-time">
        <p id="current-time">0:00</p>
        <div id="player-bar">
            <div id="time-passed">

            </div>
        </div>
        <p id="end-time">5:36</p>
    </div>
    <div id="infos">
        <h5 class="title" id="current-title"><?php echo $last_played->items[0]->track->name ?></h5>
        <p class="artist" id="current-artist"><?php echo $last_played->items[0]->track->artists[0]->name ?></p>
    </div>
</div>