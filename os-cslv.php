<?php
/**
* Plugin Name: Higlight New Comments
* Description: Highlights new comments made on a post since a person's last visit.
* Plugin URI: http://odminstudios.ru/plugins/
* Version: 0.1
* Author: Dimas
* Author URI: http://odminstudios.ru/
* License: GPL
*/

function os_sincelastvisit_comment_class($classes){

	if ( !isset($_COOKIE['lastvisit']) || (isset($_COOKIE['lastvisit']) && $_COOKIE['lastvisit'] != '') ) {

		$lastvisit = $_COOKIE['lastvisit'];

		// get the publish date of the post in UNIX GMT
		$publish_date = get_comment_time( 'U', true );
		
		// if published since last visit then add the "new" tag
		if ($publish_date > $lastvisit) $classes[]='nslv';
	}

	return $classes;
}
add_filter( 'comment_class', 'os_sincelastvisit_comment_class' );

function os_sincelastvisit_set_cookie() {
	if ( is_admin() ) return;

	$current = current_time( 'timestamp', 1);
	setcookie( 'lastvisit', $current, strtotime( '+60 days' ), $_SERVER['REQUEST_URI'] );
}
add_action( 'init', 'os_sincelastvisit_set_cookie' );
