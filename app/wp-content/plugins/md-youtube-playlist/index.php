<?php
/*
Plugin Name: MixtaDrama Theme - YouTube Playlist plugin
Plugin URI: https://mixtadrama.com/
Description: Play YouTube playlist
Author: ..
Version: 1.0
*/

function mixtadrama_youtube_playlist() {
    $embed = "<iframe id='testi-vids' src='https://www.youtube.com/embed/videoseries?list=UUwMJH-A_xa-T8kAvUZHiMhg' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
    return $embed;
}
	
add_shortcode( 'youtube_playlist', 'mixtadrama_youtube_playlist' );
?>