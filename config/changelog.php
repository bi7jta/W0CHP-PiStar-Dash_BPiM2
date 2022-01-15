<?php
if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_id('pistardashsess');
    session_start();

    include_once $_SERVER['DOCUMENT_ROOT'].'config.php';          	  // MMDVMDash Config
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
    include_once $_SERVER['DOCUMENT_ROOT'].'language.php';        	  // Translation Code
    checkSessionValidity();
}

require_once('config/version.php');
require_once('config/language.php');

// Sanity Check that this file has been opened correctly
if ($_SERVER["PHP_SELF"] == "/changelog.php") {
    // Sanity Check Passed.
    header('Cache-Control: no-cache');
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
	    <meta name="Description" content="ChangeLog" />
	    <meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,W0CHP" />
	    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	    <meta http-equiv="pragma" content="no-cache" />
	    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	    <meta http-equiv="Expires" content="0" />
	    <title>W0CHP-PiStar Dash ChangeLog</title>
	    <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="/css/pistar-css.php" />
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/functions.js?version=1.720"></script>
        <script type="text/javascript">
          $.ajaxSetup({ cache: false });
        </script>
<style type="text/css">
.cl_wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  min-height: 100vh;
}

.ChangeLogData {
  font-size: 1em;
  padding: 1em;
  font-family: 'Inconsolata', monospace;
  background-color: black;
  color: lightgray;
  text-align: left;
  width: 75%
}

.foreground-1 { color: #ff002f; }
.foreground-2 { color: #30fe00; }
.foreground-3 { color: #e3ff00; }
.foreground-4 { color: #4d4dff; font-weight:bold; }
.foreground-5 { color: #ff32ff; }
.foreground-6 { color: #00ffff; }
.foreground-7 { color: white; }

.bold.foreground-1 { color: #ff002f; font-weight:bold; }
.bold.foreground-2 { color: #30fe00; font-weight:bold; }
.bold.foreground-3 { color: #e3ff00; font-weight:bold; }
.bold.foreground-4 { color: #4d4dff; font-weight:bold; }
.bold.foreground-5 { color: #ff32ff; font-weight:bold; }
.bold.foreground-6 { color: #00ffff; font-weight:bold; }
.bold.foreground-7 { color: white; font-weight:bold; }

</style>
	</head>
	<body>
	    <div class="container">
		<div class="header">
		    <div style="font-size: 10px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 10px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version'].'<br />';?> <?php echo $lang['dashboard'].": ".$version; echo(exec('/usr/local/sbin/pistar-check4updates')); ?></div>
		    <h1><code>W0CHP-PiStar-Dash</code><br />ChangeLog</h1>
		    <p>
			<div class="navbar">
			    <a class="menuconfig" href="/admin/configure.php"><?php echo $lang['configuration'];?></a>
			    <a class="menubackup" href="/admin/config_backup.php"><?php echo $lang['backup_restore'];?></a>
			    <a class="menuupdate" href="/admin/update.php"><?php echo $lang['update'];?></a>
			    <a class="menuadmin" href="/admin/"><?php echo $lang['admin'];?></a>
				<a class="menulive" href="/live/">Live Caller</a>
			    <a class="menudashboard" href="/"><?php echo $lang['dashboard'];?></a>
			</div>
		    </p>
		</div>
		<div class="contentwide">
                    <p><b>The Last 20 Changes/Commits of the Dashboard Code:</b></p>
                    <div class="cl_wrapper">
					<div class="ChangeLogData"> 
					<?php
					$uaStr="WPSD-ChangeLog";
					@exec("curl --fail -s -o /dev/null https://repo.w0chp.net/Chipster/W0CHP-PiStar-Dash --user-agent $uaStr");
					$out = shell_exec('/usr/local/sbin/WPSD-CL-to-html');
					$out = str_replace("\n", "<br />", $out);
					echo $out;
					?>
				    </div>
				    </div>
		</div>
		<p style="text-align:center;font-weight:bold;">
		    <a href="https://repo.w0chp.net/Chipster/W0CHP-PiStar-Dash/commits/branch/master" target="new">View the entire change/commit history...</a>
		</p>
		<div class="footer">
		    Pi-Star web config, &copy; Andy Taylor (MW0MWZ) 2014-<?php echo date("Y"); ?>.<br />
			<a href="https://w0chp.net/w0chp-pistar-dash/" style="color: #ffffff; text-decoration:underline;">W0CHP-PiStar-Dash</a> enhancements by W0CHP<br />
		</div>
	    </div>
	</body>
    </html>
<?php
}
?>
