<?php
//Root Path Discovery
do { $rd = (isset($rd)) ? dirname($rd) : realpath(dirname(__FILE__)); $tp="{$rd}/rootpath.php"; if (file_exists($tp)) { require_once($tp); break; }} while ($rd != '/');
require_once("{$includepath}/header.php");
startbody();
require_once("{$includepath}/footer.php");
?>
