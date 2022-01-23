<?php

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_id('pistardashsess');
    session_start();
}
// Load the language support
require_once('../config/language.php');
// Load the Pi-Star Release file
$pistarReleaseConfig = '/etc/pistar-release';
$configPistarRelease = array();
$configPistarRelease = parse_ini_file($pistarReleaseConfig, true);
// Load the Version Info
require_once('../config/version.php');

if (file_exists('/etc/default/shellinabox')) {
  $getPortCommand = "grep -m 1 'SHELLINABOX_PORT=' /etc/default/shellinabox | awk -F '=' '/SHELLINABOX_PORT=/ {print $2}'";
  $shellPort = exec($getPortCommand);
}

// Sanity Check that this file has been opened correctly
if ($_SERVER["PHP_SELF"] == "/admin/expert/ssh_access.php") {
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
  <head>
    <meta name="robots" content="index" />
    <meta name="robots" content="follow" />
    <meta name="language" content="English" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="Author" content="Andrew Taylor (MW0MWZ)" />
    <meta name="Description" content="Pi-Star Update" />
    <meta name="KeyWords" content="Pi-Star" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
    <meta http-equiv="Expires" content="0" />
    <title>Pi-Star - <?php echo $lang['digital_voice']." ".$lang['dashboard']." - SSH";?></title>
    <link rel="stylesheet" type="text/css" href="../css/pistar-css.php" />
    <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-timing.min.js"></script>
  </head>
  <body>
    <div class="container">
    <div class="header">
    <div style="font-size: 10px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div>
    <div style="font-size: 10px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version'].'<br />';?><div id="CheckUpdate"><?php echo $lang['dashboard'].": ".$version; system('/usr/local/sbin/pistar-check4updates'); ?></div></div>
    <h1>Pi-Star <?php echo $lang['digital_voice']." ".$lang['dashboard_for']." ".$_SESSION['MYCALL']; ?> - SSH Access</h1>
        <p>
        <div class="navbar">
          <a class="menuconfig" href="/admin/configure.php">Configuration
          </a>
          <a class="menubackup" href="/admin/config_backup.php">Backup/Restore
          </a>
          <a class="menuupgrade" href="/admin/expert/upgrade.php">Upgrade
          </a>
          <a class="menuupdate" href="/admin/update.php">Update
          </a>
          <a class="menuadmin" href="/admin/">Admin
          </a>
          <a class="menulive" href="/live/">Live Caller
          </a>
          <a class="menudashboard" href="/">Dashboard
          </a>
        </div>
	</p>

  <div class="contentwide">
  <table width="100%">
  <tr><td align="center"><div>
    <?php if (isset($shellPort)) {
      echo "<iframe src=\"http://".$_SERVER['HTTP_HOST'].":".$shellPort."\" style=\"border:1px solid #ffffff; background:#000; color:#00ff00; padding:5px;margin:5px;\" name=\"Pi-Star_SSH\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0px\" marginwidth=\"0px\" height=\"600px\" width=\"860px\"></iframe>";
    }
    else {
      echo "SSH Feature not yet installed";
    } ?>
  </div></td></tr>
  <tr>
  <td>
  <?php if (isset($shellPort)) { echo "<a href=\"//".$_SERVER['HTTP_HOST'].":".$shellPort."\">(<b>Click here for full-screen SSH client</a></b>)<br />\n"; } ?>
  </td>
  </tr>
  </table>
  </div>
  <div class="footer">
  Pi-Star web config, &copy; Andy Taylor (MW0MWZ) 2014-<?php echo date("Y"); ?>.<br />
  <a href="https://w0chp.net/w0chp-pistar-dash/" style="color: #ffffff; text-decoration:underline;">W0CHP-PiStar-Dash</a> enhancements by W0CHP
  <br />
  </div>
  </div>
  </body>
  </html>

<?php
}
?>
