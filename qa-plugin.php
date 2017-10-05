<?php

/*
	Plugin Name: Latest Chat
	Plugin URI: https://github.com/bluegenel/q2a-latest-chat
	Plugin Description: Latest Chat
	Plugin Version: 1.0
	Plugin Date: 2017-10-05
	Plugin Author: Richard Hulston
	Plugin Author URI: http://www.richardhulston.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.4

*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}


	qa_register_plugin_module('widget', 'q2a-latest-chat.php', 'q2a_latest_chat', 'Latest Chat');
	

/*
	Omit PHP closing tag to help avoid accidental output
*/