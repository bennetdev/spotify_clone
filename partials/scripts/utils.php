<?php
function join_artists($artists)
{
    $names = [];
    foreach ($artists as $artist) {
        array_push($names, $artist->name);
    }
    return implode(", ", $names);

}
function get_features($artists, $album)
{
    $album_artists = explode(",", join_artists($album->artists));
    $names = [];
    foreach ($artists as $artist) {
        if(!in_array($artist->name, $album_artists)){
            array_push($names, $artist->name);
        }
    }
    return empty($names) ? "" : "- " . implode(", ", $names);

}
function ms_to_display_minutes($millis){
    $minutes = round($millis / 60000, 2);
    $minutes_str = strval($minutes);
    $time_split = explode(".", $minutes_str);
    $seconds = doubleval("0" . end($time_split));
    $minutes_real = round(doubleval($time_split[0] . "." . strval(60 * $seconds)), 2);

    $minutes_real_str = strval($minutes_real);
    while(strlen(explode(".",$minutes_real_str)[1]) < 2){
        $minutes_real_str = $minutes_real_str . "0";
    }
    return $minutes_real_str;
}