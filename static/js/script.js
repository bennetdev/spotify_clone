function find_next_albums(elem) {
    var sibling = elem.nextElementSibling;

    while (sibling) {
        if (sibling.matches(".albums")) {
            return sibling
        }
        sibling = sibling.nextElementSibling;
    }
}

function link_to_async_url(link){
    link_split = link.split("/")
    url = link_split[link_split.length - 1];
    console.log(url);
    return url
}
function playTrack(id){
    $.post("partials/scripts/playTrack.php",
        {
            "id" : id
        }, function (result) {
        console.log(result);
            window.player.nextTrack().then(function () {

            });
        });
}
function playAlbum(id){
    console.log(id);
    $.post("partials/scripts/playAlbum.php",
        {
            "id" : id
        }, function (result) {
            console.log(result);
            window.player.nextTrack().then(function () {

            });
        });
}
function playPlaylist(id){
    $.post("partials/scripts/playPlaylist.php",
        {
            "id" : id
        }, function (result) {
            console.log(result);
            window.player.nextTrack().then(function () {

            });
        });
}


function seek(time){
    window.player.seek(time).then(() =>{
       console.log("seeked");
    });
}

async function getDetail(url){
    const response = await fetch("partials/" + url);
    return await response.text();
}

function setDetail(url){
    albumDetail = getDetail(url).then(function (response) {
        document.getElementById("loaded-content").innerHTML = response;
        $(".content").scrollTop(0);
    });

}

$(document).on("click", "a", function (e) {
    e.preventDefault();
    url = link_to_async_url(this.href);
    if(this.classList.contains("play-track")){
        url_split = url.split("=")
        playTrack(url_split[url_split.length - 1]);
    }
    else if(this.classList.contains("play-album")){
        url_split = url.split("=")
        playAlbum(url_split[url_split.length - 1]);
    }
    else if(this.classList.contains("play-playlist")){
        url_split = url.split("=")
        playPlaylist(url_split[url_split.length - 1]);
    }
    else{
        setDetail(url);
    }
})
document.getElementById("play-arrow").onclick = function () {
    window.player.togglePlay().then(() => {
        console.log('Toggled playback!');
    });
}
document.getElementById("skip-next").onclick = function () {
    window.player.nextTrack().then(() => {
        console.log('next');
    });
}
document.getElementById("skip-previous").onclick = function () {
    window.player.previousTrack().then(() => {
        console.log('previous');
    });
}
$("#search").on("submit", function (e) {
    e.preventDefault();
    link = $(this).attr("action") + "?query=" + $("#query").val();
    url = link_to_async_url(link);
    setDetail(url);
})

document.getElementById("player-bar").onclick = function (e) {
    var player_width = $("#player-bar").width();
    var start_x = $("#player-bar").position().left;
    var seek_to_x = e.pageX - Number(start_x) - 12;
    var seek_to = seek_to_x / Number(player_width);
    var seek_to_time = seek_to * duration;
    seek(seek_to_time);
}

var nextButtons = document.querySelectorAll(".next");
nextButtons.forEach(next => {
    next.onclick = function () {
        var parentNode = next.parentNode;
        var nextAlbums = find_next_albums(parentNode);
        var beforeButton = next.previousElementSibling;
        var currentMargin = parseInt(nextAlbums.style.marginLeft.slice(0, -2));
        if (isNaN(currentMargin)) {
            currentMargin = 0
        }
        var toMove = nextAlbums.clientWidth - 30 + currentMargin;
        nextAlbums.style.marginLeft = (currentMargin - toMove).toString() + "px";
        beforeButton.style.opacity = 1;
    }
})

var beforeButtons = document.querySelectorAll(".before");
beforeButtons.forEach(before => {
    before.onclick = function () {
        var parentNode = before.parentNode;
        var nextAlbums = find_next_albums(parentNode);
        var currentMargin = parseInt(nextAlbums.style.marginLeft.slice(0, -2));
        if (isNaN(currentMargin)) {
            currentMargin = 0
        }
        if(currentMargin < 0){
            var toMove = nextAlbums.clientWidth - 30 + currentMargin;
            nextAlbums.style.marginLeft = (currentMargin + toMove).toString() + "px";
        }
    }
})