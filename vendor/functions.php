<?php
function convertHashtags($str) {
	$regex = "/#+([a-zA-Z0-9_]+)/";
	$str = preg_replace($regex, '<a href="/tag/$1">$0</a>', $str);
	return($str);
}
function convertMention($str) {
	$regex = "/@+([a-zA-Z0-9_]+)/";
	$str = preg_replace($regex, '<a href="https://bitclout.com/u/$1" target="_blank">$0</a>', $str);
	return($str);
}
function convertLinks($str) {
	$regex = '@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@';
	$str = preg_replace($regex, '<a href="$1" target="_blank">$0</a>', $str);
	return($str);
}
function convertAllTags($str) {
	// $regexLinks = '@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@';
	// $str1 = preg_replace($regexLinks, '<a href="$1" target="_blank">$0</a>', $str);
	$regexHash = "/#+([a-zA-Z0-9_]+)/";
	$str2 = preg_replace($regexHash, '<a href="/tag/$1">$0</a>', $str);
	$regexMention = "/@+([a-zA-Z0-9_]+)/";
	$str3 = preg_replace($regexMention, '<a href="https://bitclout.com/u/$1" target="_blank">$0</a>', $str2);
	return($str3);
}
function timeAgo($time_ago) {
    $milliseconds = $time_ago / 1000000;
	$seconds = $milliseconds / 1000;
					
	$seconds = date("Y-m-d H:i:s", $seconds);
    $time_ago = strtotime($seconds);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "1min";
        }
        else{
            return $minutes."mins";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "1h";
        }else{
            return $hours."h";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "1d";
        }else{
            return $days."d";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "1w";
        }else{
            return $weeks."w";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "1m";
        }else{
            return $months."m";
        }
    }
    //Years
    else{
        if($years==1){
            return "1y";
        }else{
            return $years."y";
        }
    }
}