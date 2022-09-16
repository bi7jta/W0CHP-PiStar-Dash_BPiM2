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
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';

// Sanity Check that this file has been opened correctly
if ($_SERVER["PHP_SELF"] == "/admin/expert/mmdvm_config_manager.php") {
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
	    <title>Pi-Star - <?php echo $lang['digital_voice']." ".$lang['dashboard']."";?> - MMDVM Config Manager</title>
	    <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="/css/pistar-css.php?version=<?php echo $versionCmd; ?>" />
        <script type="text/javascript" src="/js/jquery.min.js?version=<?php echo $versionCmd; ?>"></script>
        <script type="text/javascript" src="/js/functions.js?version=<?php echo $versionCmd; ?>"></script>
	</head>
	<body>
	    <div class="container">
		<div class="header">
		    <div style="font-size: 10px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 10px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version'].'<br />';?>
		    <?php if (constant("AUTO_UPDATE_CHECK") == "true") { ?> 
		    <div id="CheckUpdate"><?php echo $version; system('/usr/local/sbin/pistar-check4updates'); ?></div></div>
		    <?php } else { ?>
		    <div id="CheckUpdate"><?php echo $version; ?></div></div>
		    <?php } ?>    
		    <h1>Pi-Star <?php echo $lang['digital_voice'];?>  - MMDVM Config Manager</h1>
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
			    <tr><th colspan="2">MMDVMHost Configuration Manager</th></tr>
			    <?php
			    if ( escapeshellcmd($_POST["save_current_config"]) ) {
				if (!ctype_alnum($_POST['config_desc'])) {
				   echo '<tr><td colspan="2"><br />No Spaces nor Non-Alpha-Numeric Characters are Permitted...
				   <br />Page reloading...<br /><br />
				   <script language="JavaScript" type="text/javascript">
                                   setTimeout("location.href = \''.$_SERVER["PHP_SELF"].'\'", 3000);
				   </script>
				   </td></tr>';
				} else {
				   $desc = $_POST['config_desc'];
				   echo '<tr><td colspan="2"><br />Saving Current Config to "mmdvmhost-'.$desc.'"...
				   <br />Page reloading...<br /><br />
				   <script language="JavaScript" type="text/javascript">
                                   setTimeout("location.href = \''.$_SERVER["PHP_SELF"].'\'", 3000);
				   </script>
				   </td></tr>';
				   exec('sudo mount -o remount,rw /');
				   exec("sudo cp -a /etc/mmdvmhost /etc/mmdvmhost_configs/mmdvmhost-$desc > /dev/null");
				   exec('sudo mount -o remount,ro /');
				}
			    }
			    else if ( escapeshellcmd($_POST["restore_config"]) ) {
				   echo '<tr><td colspan="2"><br />Restoring and Applying Config, "' .$_POST['configs'].'"...
				   <br />Page reloading...<br /><br />
				   <script language="JavaScript" type="text/javascript">
                                   setTimeout("location.href = \''.$_SERVER["PHP_SELF"].'\'", 3000);
				   </script>
				   </td></tr>';
				   exec('sudo mount -o remount,rw /');
				   exec("sudo cp -a /etc/mmdvmhost_configs/".$_POST['configs']." /etc/mmdvmhost > /dev/null");
				   exec('sudo mount -o remount,ro /');
				   exec("sudo systemctl restart mmdvmhost.service & > /dev/null");
			    }
			    else if ( escapeshellcmd($_POST["remove_config"]) ) {
				   echo '<tr><td colspan="2"><br />Deleting Config, "' .$_POST['delete_configs'].'"...
				   <br />Page reloading...<br /><br />
				   <script language="JavaScript" type="text/javascript">
                                   setTimeout("location.href = \''.$_SERVER["PHP_SELF"].'\'", 3000);
				   </script>
				   </td></tr>';
				   exec('sudo mount -o remount,rw /');
				   exec("sudo rm -f /etc/mmdvmhost_configs/".$_POST['delete_configs']." > /dev/null");
				   exec('sudo mount -o remount,ro /');
			    }
			    unset($_POST);
			    ?>
			</table>
		    <?php }
		    else { ?>
                        <?php
                        // check that no modes are paused. If so, bail and direct user to unpause...
                        $is_paused = glob('/etc/*_paused');
                        $repl_str = array('/\/etc\//', '/_paused/');
                        $paused_modes = preg_replace($repl_str, '', $is_paused);
                        if (!empty($is_paused)) {
                                echo '<h1>IMPORTANT:</h1>';
                                echo '<p><b>One or more modes have been detected to have been "paused" by you</b>:</p>';
                                foreach($paused_modes as $mode) {
                                        echo "<h3>$mode</h3>";
                                }
                                echo '<p>You must "resume" all of the modes you have paused in order to make any configuration changes...</p>';
                                echo '<p>Go the <a style="text-decoration:underline;color:inherit;" href="/admin/?func=mode_man">Instant Mode Manager page to Resume the paused mode(s)</a>. Once that\'s completed, this configuration page will be enabled.</p>';
                                echo '<br />'."\n";
                                echo '<br />';
                        } else {
                        ?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			    <table width="100%">
				<tr>
				    <th colspan="2">MMDVMHost Configuration Manager</th>
				</tr>
				<tr>
				    <th width="50%">Save Current Config</th>
                                    <th>Restore Config</th>
				</tr>
				<tr>
					<td>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="save_config">
							<label for="config">Save the Current Config:</label>
							<input type="text" placeholder="Enter Short Description" name="config_desc" size="27" maxlength="27">
							<input type="submit" name="save_current_config" value="Save Config">
						</form>
					</td>

					<td>
						<?php
						$config_dir = "/etc/mmdvmhost_configs";
						if (count(glob("$config_dir/mmdvmhost-*")) == 0) {
						?>
							No saved configs yet!
						<?php } else { ?>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="list_configs">
							<label for="configs">Choose a saved config:</label>
							<select name="configs" id="configs" form="list_configs">
							<?php
							foreach ( glob("$config_dir/mmdvmhost-*") as $file ) {
								$config_file = str_replace("$config_dir/", "", $file);
								echo "<option name='selected_config' value='$config_file'>$config_file</option>";
							}
							?>
							</select>
							<input type="submit" name="restore_config" value="Restore and Apply Config">
						</form>
						<?php } ?>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="white-space:normal;padding: 3px;">This function allows you save multiple versions and configurations of your MMDVMHost setup;  and then restore/re-apply them as-needed for different uses, etc.<br />Restoring and re-applying a configuration is instant.</td>
				</tr>
			</table>
		</form>
	<br />
	<br />

	<table>
		<tr>
			<th colspan="2"">Delete a Saved Config</th>
		</tr>
		<tr>
			<td colspan="2">
				<?php
				$config_dir = "/etc/mmdvmhost_configs";
				if (count(glob("$config_dir/mmdvmhost-*")) == 0) {
				?>
				No saved configs yet!
				<?php } else { ?>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="del_configs">
					<label for="delete_configs">Choose config to delete:</label>
					<select name="delete_configs" id="configs" form="del_configs">
				<?php
				foreach ( glob("$config_dir/mmdvmhost-*") as $file ) {
					$config_file = str_replace("$config_dir/", "", $file);
					echo "<option name='selected_config' value='$config_file'>$config_file</option>";
				}
				?>
					</select>
					<input style="background:crimson;color:white;" type="submit" name="remove_config" value="Delete Config">
				</form>
				<?php } ?>
			</td>
		</tr>
	</table>
	<?php } ?>
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
