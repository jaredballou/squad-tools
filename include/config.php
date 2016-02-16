<?php
/*
	CONFIG
	This should ONLY be declaring default values or doing minimal work to set them.
	Code should go in functions.php when possible
	Remember: This file will be updated by Git, so any site-specific settings
	like passwords or anything private will be overwritten. Use config.private.php
	to set your own variables.
*/

// Page Names
$curpage = basename($_SERVER['SCRIPT_FILENAME']);
$pages = array(
//	'stats.php' => 'Stats (Theater Parser)',
//	'maps.php' => 'Maps (Overlay Viewer)',
	"https://github.com/jaredballou' target='_blank" => 'My Github',
);

// GitHub secret for post-commit hooks
$github_secret='';

//User to pull the GitHub readme files
$githubuser = 'jaredballou';

// Insurgency App ID
$appid = 393380;

// Steam API Key (PUT IN config.private.php !!!!)
$apikey = '';

// MySQL Server connection settings
$mysql_server   = 'localhost';
$mysql_username = 'username';
$mysql_password = 'password';
$mysql_database = 'database';

// Include the private config (never updated by Git) to override or set other variables
$cfg_private="{$includepath}/config.private.php";
if (file_exists($cfg_private)) {
	require_once($cfg_private);
} else {
	file_put_contents($cfg_private,"<?php\n//Custom Config for your site - this will not be modified by the tools!\n\n");
}
