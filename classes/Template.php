<?php

class Template {
    private static $stylesheets = array();
    private static $scripts = array();

    public static function addStylesheet($href){
	self::$stylesheets[] = $href;
    }

    public static function addScript($src){
	self::$scripts[] = $src;
    }

    public static function getStylesheetHTML(){
	$html = "";
	foreach (self::$stylesheets as $href){
	    $html .= "<link rel='stylesheet' href='{$href}'>\n";
	}
	return $html;
    }
    
    public static function getScriptHTML(){
	$html = "";
	foreach (self::$scripts as $src){
	    $html .= "<script src='{$src}'></script>\n";
	}
	return $html;
    }

}

?>
