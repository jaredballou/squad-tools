<nav class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Squad Tools</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
<?php
	foreach ($pages as $url => $page) {
		$act = ($url == $curpage) ? ' class="active"' : '';
		echo "            <li{$act}><a href='{$url}'>{$page}</a></li>\n";
	}
?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<?php
if ($_SERVER['HTTP_HOST'] == 'squad.jballou.com') {
	echo "<div style='text-align: center; font-weight: bold;'>Development Site - These tools are being actively worked on and tested, latest stable versions at <a href='http://jballou.com/squad{$_SERVER['SCRIPT_URL']}'>http://jballou.com/squad</a></div>\n";
}
?>
