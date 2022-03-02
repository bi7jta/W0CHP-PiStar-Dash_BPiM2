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

// Sanity Check that this file has been opened correctly
if ($_SERVER["PHP_SELF"] == "/admin/power.php") {
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
	    <meta name="Description" content="Pi-Star Power" />
	    <meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,W0CHP" />
	    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	    <meta http-equiv="pragma" content="no-cache" />
	    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
	    <meta http-equiv="Expires" content="0" />
	    <title>Pi-Star - <?php echo $lang['digital_voice']." ".$lang['dashboard']." - ".$lang['power'];?></title>
	    <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="/css/pistar-css.php?version=<?php echo $versionCmd; ?>" />
        <script type="text/javascript" src="/js/jquery.min.js?version=<?php echo $versionCmd; ?>"></script>
        <script type="text/javascript" src="/js/functions.js?version=<?php echo $versionCmd; ?>"></script>
        <script type="text/javascript">
          $.ajaxSetup({ cache: false });
        </script>
	</head>
	<body>
	    <div class="container">
		<div class="header">
		    <div style="font-size: 10px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 10px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version'].'<br />';?> <?php echo $lang['dashboard'].": ".$version; echo(exec('/usr/local/sbin/pistar-check4updates')); ?></div>
		    <h1>Pi-Star <?php echo $lang['digital_voice']." - ".$lang['power'];?></h1>
		    <p>
			<div class="navbar">
              <script type= "text/javascript">
               $(document).ready(function() {
                 setInterval(function() {
                   $("#timer").load("/dstarrepeater/datetime.php");
                   }, 1000);

                 function update() {
                   $.ajax({
                     type: 'GET',
                     cache: false,
                     url: '/dstarrepeater/datetime.php',
                     timeout: 1000,
                     success: function(data) {
                       $("#timer").html(data); 
                       window.setTimeout(update, 1000);
                     }
                   });
                 }
                 update();
               });
              </script>
              <div style="font-size:<?php echo($TextFontSize);?>px; text-align: left; padding-left: 8px; padding-top: 5px; float: left;">
                <span id="timer"></span>
            </div>
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
		    <?php if (!empty($_POST)) { ?>
			<table width="100%">
			    <tr><th colspan="2"><?php echo $lang['power'];?></th></tr>
			    <?php
			    if ( escapeshellcmd($_POST["action"]) == "reboot" ) {
				echo '<tr><td colspan="2" style="background: #000000; color: #00ff00;"><br /><br />Your Pi-Star Hotspot is rebooting...,
				   <br />You will be re-directed back to the
				   <br />dashboard automatically in 90 seconds.<br /><br /><br />
				   <script language="JavaScript" type="text/javascript">
                                   setTimeout("location.href = \'/index.php\'", 90000);
				   </script>
				   </td></tr>'; 
                system('sudo sync && sudo sync && sudo sync && sudo mount -o remount,ro / > /dev/null &');
                exec('sudo reboot > /dev/null &');
			    }
			    else if ( escapeshellcmd($_POST["action"]) == "shutdown" ) {
				echo '<tr><td colspan="2" style="background: #000000; color: #00ff00;"><br /><br />Shutdown command has been sent to your Pi-Star Hotspot 
				   <br /> please wait at least 60 seconds for it to fully shutdown<br />before removing the power.<br /><br /><br /></td></tr>';
                system('sudo sync && sudo sync && sudo sync && sudo mount -o remount,ro / > /dev/null &');
                exec('sudo shutdown -h now > /dev/null &');
			    }

			    unset($_POST);
			    ?>
			</table>
		    <?php }
		    else { ?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			    <table width="100%">
				<tr>
				    <th colspan="2"><?php echo $lang['power'];?></th>
				</tr>
				<tr>
				    <td align="center">
					<h3>Reboot</h3><br />
					<button style="border: none; background: none; margin: 15px 0px;" name="action" value="reboot"><img src="/images/reboot.png" border="0" alt="Reboot" /></button>
				    </td>
				    <td align="center">
					<h3>Shutdown</h3><br />
					<button style="border: none; background: none; margin: 15px 0px;" id="shutdown" name="action" value="shutdown"><img src="/images/shutdown.png" border="0" alt="Shutdown" /></button>					
				    </td>
				</tr>
			    </table>
			</form>
		    <?php } ?>
		</div>
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
