<?php
/*
  * rootpath.php
  * (c) 2016, Jared Ballou <squad@jballou.com>
  *
  * This is the file that gets included by all PHP scripts to define the paths
  * used by many of the tools in a standardized way. The code which is included to load it is:
  *
*/
// rootpath is the squad-tools root
$rootpath = realpath(dirname(__FILE__));

// includepath is the include directory
$includepath = "${rootpath}/include";

// publicpath is the publicly viewable path
$publicpath="${rootpath}/public";

// datapath is where the squad-data repo is checked out
$datapath="${rootpath}/data";

// Cache directory to stash temporary files. This should be inaccessible via your Web server!
$cachepath = "{$rootpath}/cache";

