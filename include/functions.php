<?php
// These variables must be set before anything else

// Pull in configuration settings
include "{$includepath}/config.php";

/*
	BEGIN COMMON EXECUTION CODE
	This section is run by every script, so it shouldn't do too much.
*/

// Create cache dir if needed
if (!file_exists($cachepath)) {
	mkdir($cachepath,0755,true);
}

// Get the command passed to the script
$command = @$_REQUEST['command'];

//$steam_ver=getSteamVersion();

/*
================================================================================
===                                                                          ===
===                                                                          ===
===                             BEGIN FUNCTIONS                              ===
===                                                                          ===
===                                                                          ===
================================================================================
*/

/**
 * Return a relative path to a file or directory using base directory. 
 * When you set $base to /website and $path to /website/store/library.php
 * this function will return /store/library.php
 * 
 * Remember: All paths have to start from "/" or "\" this is not Windows compatible.
 * 
 * @param   String   $base   A base path used to construct relative path. For example /website
 * @param   String   $path   A full path to file or directory used to construct relative path. For example /website/store/library.php
 * 
 * @return  String
 */
function getRelativePath($base, $path) {
	// Detect directory separator
	$separator = substr($base, 0, 1);
	$base = array_slice(explode($separator, rtrim($base,$separator)),1);
	$path = array_slice(explode($separator, rtrim($path,$separator)),1);

	return $separator.implode($separator, array_slice($path, count($base)));
}


// TODO: Break these out into separate classes and better define them.

// rglob - recursively locate all files in a directory according to a pattern
function rglob($pattern, $files=1,$dirs=0,$flags=0) {
	$dirname = dirname($pattern);
	$basename = basename($pattern);
	$glob = glob($pattern, $flags);
	$files = array();
	$dirlist = array();
	foreach ($glob as $path) {
		if (is_file($path) && (!$files)) {
			continue;
		}
		if (is_dir($path)) {
			$dirlist[] = $path;
			if (!$dirs) {
				continue;
			}
		}
		$files[] = $path;
	}
	foreach (glob("{$dirname}/*", GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
		$dirfiles = rglob($dir.'/'.$basename, $files,$dirs,$flags);
		$files = array_merge($files, $dirfiles);
	}
	return $files;
}

// delTree - recursively DELETE AN ENTIRE DIRECTORY STRUCTURE!!!!
function delTree($dir='') {
	if (strlen($dir) < 2)
		return false;
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

// is_numeric_array - test if all values in an array are numeric
function is_numeric_array($array) {
	foreach ($array as $key => $value) {
		if (!is_numeric($value)) return false;
	}
	return true;
}

// prettyPrint - Print JSON with proper indents and formatting
function prettyPrint( $json )
{
	$result = '';
	$level = 0;
	$in_quotes = false;
	$in_escape = false;
	$ends_line_level = NULL;
	$json_length = strlen( $json );

	for( $i = 0; $i < $json_length; $i++ ) {
		$char = $json[$i];
		$new_line_level = NULL;
		$post = "";
		if( $ends_line_level !== NULL ) {
			$new_line_level = $ends_line_level;
			$ends_line_level = NULL;
		}
		if ( $in_escape ) {
			$in_escape = false;
		} else if( $char === '"' ) {
			$in_quotes = !$in_quotes;
		} else if( ! $in_quotes ) {
			switch( $char ) {
				case '}':
				case ']':
					$level--;
					$ends_line_level = NULL;
					$new_line_level = $level;
					break;
				case '{':
				case '[':
					$level++;
					case ',':
					$ends_line_level = $level;
					break;

				case ':':
					$post = " ";
					break;

				case " ":
				case "\t":
				case "\n":
				case "\r":
					$char = "";
					$ends_line_level = $new_line_level;
					$new_line_level = NULL;
					break;
			}
		} else if ( $char === '\\' ) {
			$in_escape = true;
		}
		if( $new_line_level !== NULL ) {
			$result .= "\n".str_repeat( "\t", $new_line_level );
		}
		$result .= $char.$post;
	}
	return $result;
}

// formatBytes - Display human-friendly file sizes
function formatBytes($bytes, $precision = 2) { 
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	$bytes = max($bytes, 0); 
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	$pow = min($pow, count($units) - 1); 

	// Uncomment one of the following alternatives
	$bytes /= pow(1024, $pow);
	// $bytes /= (1 << (10 * $pow)); 

	return round($bytes, $precision) . ' ' . $units[$pow];
}


function getSteamVersion($appid=0) {
	if (!$appid) $appid = $GLOBALS['appid'];
	$url = "http://api.steampowered.com/ISteamApps/UpToDateCheck/v0001?appid={$appid}&version=0";
	$raw = json_decode(file_get_contents($url),true);
var_dump($raw);
	return implode('.',str_split($raw['response']['required_version']));
}

// Is this array associative?
function isAssoc($arr)
{
	return array_keys($arr) !== range(0, count($arr) - 1);
}

// Return the string representing data type
function vartype($data) {
	$words = explode(" ",$data);
	if (is_array($data)) {
		return "array";
	}
	if (count($words) == 3) {
		foreach ($words as $idx=>$word) {
			if (is_numeric($word)){
				unset($words[$idx]);;
			}
		}
		if (!count($words))
			return "vector";
	}
	if (is_numeric($data)) {
		if (strpos($data,'.') !== false)
			return "float";
		return "integer";
	}
	if (is_string($data)) {
		if (substr($data,0,1) == "#")
			return "translate";
		return "string";
	}
	return "UNKNOWN";
}
