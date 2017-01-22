<?php

function Trip($str) {
 
    //stripslashes（バックスラッシュ（\）を取り除く）
    $str = stripslashes($str);
    
    $str = mb_convert_encoding($str, "SJIS", "UTF-8,EUC-JP,JIS,ASCII"); 
    
    //★を☆に置換
    $str = str_replace("★", "☆", $str);
    //◆を◇に置換
    $str = str_replace("◆", "◇", $str); 
    
    // したらばとか？
    //$str = str_replace(array('"', '<', '>'), array("&quot;", "&lt;", "&gt;"), $str);
 
    if (($trips = strpos($str, "#")) !== false) {
    
        $kotehan = mb_substr($str, 0, $trips);
        $tripkey = mb_substr($str, $trips + 1);
        $salt = mb_substr($tripkey.'H.', 1, 2);
        
        $patterns = array(':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`');
        $match = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'a', 'b',  'c', 'd', 'e', 'f');
        $salt = str_replace($patterns, $match, $salt);
        
        $pattern = '/[\x00-\x20\x7B-\xFF]/';
        $salt = preg_replace($pattern, ".", $salt);
        
        $trip = crypt($tripkey, $salt);
        
        $trip = substr($trip, -10);
        $kotehan = mb_convert_encoding($kotehan, "UTF-8", "SJIS"); 
        $trip = mb_convert_encoding($trip, "UTF-8", "SJIS"); 
        $trip = '◆'.$trip;
        
        return array($kotehan, $trip);
        
    }
    
    $str = mb_convert_encoding($str, "UTF-8", "SJIS");
    
    return array($str, "");
}

?>