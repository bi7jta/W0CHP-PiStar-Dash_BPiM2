<?php

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_id('pistardashsess');
    session_start();
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code
    checkSessionValidity();
}

// Load the language support
require_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/version.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
    <head>
	<meta name="robots" content="index" />
	<meta name="robots" content="follow" />
	<meta name="language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Author" content="Andrew Taylor (MW0MWZ), Chip Cuccio (W0CHP)" />
	<meta name="Description" content="Pi-Star Expert" />
	<meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,W0CHP" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="pragma" content="no-cache" />
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Expires" content="0" />
	<title>Pi-Star - Digital Voice Dashboard - Expert</title>
	<link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/pistar-css.php?version=<?php echo $versionCmd; ?>" />
    </head>
    <body>
	<div class="container">
<?php
                // check that no modes are paused. If so, bail and direct user to unpause...
                $is_paused = glob('/etc/*_paused');
                $repl_str = array('/\/etc\//', '/_paused/');
                $paused_modes = preg_replace($repl_str, '', $is_paused);
                if (!empty($is_paused) && $_GET['force'] != true) {
                    //HTML output starts here
                    include './header-menu-disabled.inc';
                    echo '<div class="contentwide">'."\n";
                    echo '<h1>IMPORTANT:</h1>';
                    echo '<p><b>One or more modes have been detected to have been "paused" by you</b>:</p>';
                    foreach($paused_modes as $mode) {
                        echo "<h2>$mode</h2>";
                    }
                    echo '<p>You must "resume" all of the modes you have paused in order to make any configuration changes...</p>';
                    echo '<p>Go the <a href="/admin/?func=mode_man">Instant Mode Manager page to Resume the paused mode(s)</a>. Once that\'s completed, this configuration page will be enabled.</p>';
                    echo '<br />'."\n";
                    die();
} else {
	    include './header-menu.inc';
?>
            <div class="contentwide">

	      <div class="divTable">
		<div class="divTableBody">
		  <div class="divTableRow">
		    <div class="divTableCellSans">
		    <h2>Expert Editors &amp; Tools</h2>
		    <h3>**WARNING**</h3>
            		<p>
			Pi-Star Expert editors have been created to make editing some of the extra settings in the<br />
			config files more simple, allowing you to update some areas of the config files without the<br />
			need to login to your Pi over SSH.<br />
			<br />
			Please keep in mind when making your edits here, that these config files can be updated by<br />
			the dashboard, and that your edits can be over-written. It is assumed that you already know<br />
			what you are doing editing the files by hand, and that you understand what parts of the files<br />
			are maintained by the dashboard.<br />
			<br />
			With that warning in mind, you are free to make any changes you like by accessing the expert areas
            in the upper-left-hand menus. <br />
			</p>
		</div>
	      </div>
	    </div>
	  </div>

	</div>
	    <div class="footer">
		Pi-Star web config, &copy; Andy Taylor (MW0MWZ) 2014-<?php echo date("Y"); ?>.<br />
		<a href="https://w0chp.net/w0chp-pistar-dash/" style="color: #ffffff; text-decoration:underline;">W0CHP-PiStar-Dash</a> enhancements by W0CHP<br />
	    </div>
	    
	</div>
    </body>
</html>

<?php

} // end paused mode check

?>
