<?php

class q2a_latest_chat {

    function allow_template($template) {
        $allow = false;

        switch ($template) {
            case 'account':
            case'activity':
            case'admin':
            case'ask' :
            case'categories' :
            case'custom' :
            case'favorites':
            case'feedback' :
            case'hot' :
            case'ip' :
            case'login':
            case'message':
            case'qa' :
            case'question':
            case'questions':
            case'register' :
            case'search' :
            case'tag' :
            case'tags' :
            case'unanswered':
            case'updates' :
            case'user' :
            case'users' :
                $allow = true;
                break;
        }

        return $allow;
    }

    function allow_region($region) {
        return true;
    }

    function output_widget($datetime, $full = false) {

            $ylastactivity = qa_db_read_one_assoc(
			qa_db_query_sub(
			'SELECT * FROM ^chat_posts LEFT JOIN qa_users ON ^chat_posts.userid=qa_users.userid 
			ORDER BY postid DESC LIMIT 1'));
            $ylastactivity2 = date_create(qa_db_read_one_value(
			qa_db_query_sub(
			'SELECT posted FROM ^chat_posts 
            ORDER BY posted DESC LIMIT 1'), true ));
			$ymonthnumbers =  qa_db_read_one_value(
			qa_db_query_sub(
			"SELECT COUNT(postid) FROM qa_chat_posts
			WHERE YEAR(`posted`) = YEAR(CURDATE()) AND MONTH(`posted`) = MONTH(CURDATE())
			ORDER BY postid DESC LIMIT 1"));
			$ynumberstotal =  qa_db_read_one_value(
			qa_db_query_sub(
			"SELECT COUNT(postid) FROM qa_chat_posts
			ORDER BY postid DESC LIMIT 1"));
			if ( qa_get_logged_in_level() <= QA_USER_LEVEL_SUPER ) {
			echo "<div style='text-align: center;'>";
			echo "<h3 style='text-align: center; padding: 12px 0px 0px 0px;'>Latest Chat</h3>";
			if (strlen($ylastactivity['message'])<=23 && substr($lastactivity['message'],-1) == '.') {
			echo "<h4 style='display: inline;'><a href='../chat/'>" . substr(htmlspecialchars($ylastactivity['message']),0,23) . "</a></h4><br>";
			} elseif (strlen($ylastactivity['message'])<=23) {
			echo "<h4 style='display: inline;'><a href='../chat/'>" . substr(htmlspecialchars($ylastactivity['message']),0,23) . "</a></h4><br>";	
			} elseif (strlen($ylastactivity['message'])>=24 && substr($lastactivity['message'],20,1) == ' ') {	
			echo "<h4 style='display: inline;'><a href='../chat/'>" . substr(htmlspecialchars($ylastactivity['message']),0,20) . " ...</a></h4><br>";
			} else {	
			echo "<h4 style='display: inline;'><a href='../chat/'>" . substr(htmlspecialchars($ylastactivity['message']),0,20) . " ...</a></h4><br>";
			}
			}
			if ( qa_get_logged_in_level() <= QA_USER_LEVEL_SUPER ) {
			echo "by " . $ylastactivity['handle'] . "<br>";
			} else {
			echo "Chat by " . $ylastactivity['handle'] . "<br>";
			}
	$now = new DateTime;
    $ago = $ylastactivity2;
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'min',
        //'s' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    echo $string ? implode(', ', $string) . ' ago' : 'a moment ago';
	if ( qa_get_logged_in_level() <= QA_USER_LEVEL_SUPER ) {
			echo "<br><h3 style='display: inline; color: #0179b5;'>"
			. number_format($ymonthnumbers) . "</h3>";
			if ($ymonthnumbers == 1) {
			echo " chat this month";
			} else {
			echo " chats this month";
			}
			echo "<br><h3 style='display: inline; color: #0179b5;'>"
			. number_format($ynumberstotal) . "</h3>";
			echo " total chats";
			echo "</div>";
			}
}
}
