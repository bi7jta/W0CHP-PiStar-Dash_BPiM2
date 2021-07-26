<?php
if (isset($_COOKIE['PHPSESSID']))
{
    session_id($_COOKIE['PHPSESSID']); 
}
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION) || !is_array($_SESSION) || (count($_SESSION, COUNT_RECURSIVE) < 10)) {
    session_id('pistardashsess');
    session_start();
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code
    checkSessionValidity();
}

// Load the language support
require_once('config/language.php');
require_once('config/version.php');

// Sanity Check that this file has been opened correctly
if ($_SERVER["PHP_SELF"] == "/admin/config_backup.php") {
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
	    <meta name="Author" content="Andrew Taylor (MW0MWZ)" />
	    <meta name="Description" content="Pi-Star Configuration Backup" />
	    <meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,F1RMB,W0CHP" />
	    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	    <meta http-equiv="pragma" content="no-cache" />
	    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	    <meta http-equiv="Expires" content="0" />
	    <title>Pi-Star - <?php echo $lang['digital_voice']." ".$lang['dashboard']." - ".$lang['backup_restore'];?></title>
	    <link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	    <link rel="stylesheet" type="text/css" href="/css/pistar-css.php" />
	</head>
	<body>
	    <div class="container">
		<div class="header">
		    <div style="font-size: 8px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 8px; text-align: right; padding-right: 8px;">Pi-Star:<?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version']?> / <?php echo $lang['dashboard'].": ".$version; ?></div>
		    <h1>Pi-Star <?php echo $lang['digital_voice']." - ".$lang['backup_restore'];?></h1>
		    <p>
			<div class="navbar">
			    <a class="menuconfig" href="/admin/configure.php"><?php echo $lang['configuration'];?></a>
			    <a class="menuupdate" href="/admin/update.php"><?php echo $lang['update'];?></a>
			    <a class="menupower" href="/admin/power.php"><?php echo $lang['power'];?></a>
			    <a class="menuadmin" href="/admin/"><?php echo $lang['admin'];?></a>
			    <a class="menudashboard" href="/"><?php echo $lang['dashboard'];?></a>
			</div>
		    </p>
		</div>
		<div class="contentwide">
		    <?php if (!empty($_POST)) {
			echo '<table width="100%">'."\n";
			
			if ( escapeshellcmd($_POST["action"]) == "download" ) {
			    echo "<tr><th colspan=\"2\">".$lang['backup_restore']."</th></tr>\n";
			    
			    $output = "Finding config files to be backed up\n";
			    $backupDir = "/tmp/config_backup";
			    $backupZip = "/tmp/config_backup.zip";
			    $hostNameInfo = exec('cat /etc/hostname');
			    
			    $output .= shell_exec("sudo rm -rf $backupZip 2>&1")."\n";
			    $output .= shell_exec("sudo rm -rf $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo mkdir $backupDir 2>&1")."\n";
			    if (shell_exec('cat /etc/dhcpcd.conf | grep "static ip_address" | grep -v "#"')) {
				    $output .= shell_exec("sudo cp /etc/dhcpcd.conf $backupDir 2>&1")."\n";
			    }
			    $output .= shell_exec("sudo cp /etc/wpa_supplicant/wpa_supplicant.conf $backupDir 2>&1")."\n";
                $output .= shell_exec("sudo cp /etc/hostapd/hostapd.conf $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/pistar-css.ini $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/aprsgateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/ircddbgateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/mmdvmhost $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dstarrepeater $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dapnetgateway $backupDir 2>&1")."\n";
                $output .= shell_exec("sudo cp /etc/pistar-css.ini $backupDir 2>&1");
			    $output .= shell_exec("sudo cp /etc/p25gateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/ysfgateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/nxdngateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dmr2nxdn $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dmr2ysf $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/nxdn2dmr $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/ysf2dmr $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/ysf2nxdn $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/ysf2p25 $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dmrgateway $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/starnetserver $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/timeserver $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dstar-radio.* $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/pistar-remote $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/hosts $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/hostname $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/bmapi.key $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/dapnetapi.key $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/default/gpsd $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /etc/*_paused $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /usr/local/etc/RSSI.dat $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /var/www/dashboard/config/ircddblocal.php $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /var/www/dashboard/config/config.php $backupDir 2>&1")."\n";
			    $output .= shell_exec("sudo cp /var/www/dashboard/config/language.php $backupDir 2>&1")."\n";
			    $output .= shell_exec('sudo find /root/ -maxdepth 1 -name "*Hosts.txt" -exec cp {} /tmp/config_backup \; 2>&1')."\n";
			    $output .= "Compressing backup files\n";
			    $output .= shell_exec("sudo zip -j $backupZip $backupDir/* 2>&1")."\n";
			    $output .= "Starting download\n";

			    echo "<tr><td align=\"left\"><pre>$output</pre></td></tr>\n";
			    
			    if (file_exists($backupZip)) {
				$utc_time = gmdate('Y-m-d H:i:s');
				$utc_tz =  new DateTimeZone('UTC');
				$local_tz = new DateTimeZone(date_default_timezone_get ());
				$dt = new DateTime($utc_time, $utc_tz);
				$dt->setTimeZone($local_tz);
                $local_time = $dt->format('Y-M-d');
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				if ($hostNameInfo != "pi-star") {
				    header('Content-Disposition: attachment; filename="'.basename("Pi-Star_Config_".$hostNameInfo."_".$local_time.".zip").'"');
				}
				else {
				    header('Content-Disposition: attachment; filename="'.basename("Pi-Star_Config_$local_time.zip").'"');
				}
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($backupZip));
				ob_clean();
				flush();
				readfile($backupZip);
				exit();
			    }
			    
			};
			if ( escapeshellcmd($_POST["action"]) == "restore" ) {
			    echo "<tr><th colspan=\"2\">Config Restore</th></tr>\n";
			    $output = "Uploading your Config data\n";
			    
			    $target_dir = "/tmp/config_restore/";
			    shell_exec("sudo rm -rf $target_dir 2>&1");
			    shell_exec("mkdir $target_dir 2>&1");
			    if($_FILES["fileToUpload"]["name"]) {
				$filename = $_FILES["fileToUpload"]["name"];
	  			$source = $_FILES["fileToUpload"]["tmp_name"];
				$type = $_FILES["fileToUpload"]["type"];
				
				$name = explode(".", $filename);
				$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
				foreach($accepted_types as $mime_type) {
				    if($mime_type == $type) {
					$okay = true;
					break;
				    }
				}
			    }
			    $continue = false;
			    
			    if (isset($name))
			    {
				$continue = strtolower($name[1]) == 'zip' ? true : false;
			    }
			    
			    if(!$continue) {
				$output .= "The file you are trying to upload is not a .zip file. Please try again.\n";
			    }
			    
			    if (isset($filename))
			    {
				$target_path = $target_dir.$filename;
			    }
			    
			    if(isset($target_path) && move_uploaded_file($source, $target_path)) {
				$zip = new ZipArchive();
				$x = $zip->open($target_path);
				if ($x === true) {
			            $zip->extractTo($target_dir); // change this to the correct site path
			            $zip->close();
			            unlink($target_path);
				}
				$output .= "Your .zip file was uploaded and unpacked.\n";
				$output .= "Stopping Services.\n";
				
				// Stop the DV Services
			    shell_exec('sudo pistar-services fullstop 2>&1');
	
				// Make the disk Writable
				shell_exec('sudo mount -o remount,rw / 2>&1');
				
				// Overwrite the configs
				$output .= "Writing new Config\n";
				$output .= shell_exec("sudo rm -f /etc/dstar-radio.* /etc/bmapi.key /etc/dapnetapi.key 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/RSSI.dat /usr/local/etc/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/gpsd /etc/default/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/ircddblocal.php /var/www/dashboard/config/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/config.php /var/www/dashboard/config/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/language.php /var/www/dashboard/config/ 2>&1")."\n";
				$output .= shell_exec('sudo find /tmp/config_restore/ -maxdepth 1 -name "*Hosts.txt" -exec mv -fv {} /root \; 2>&1')."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/wpa_supplicant.conf /etc/wpa_supplicant/ 2>&1")."\n";
                $output .= shell_exec("sudo mv -fv /tmp/config_restore/hostapd.conf /etc/hostapd/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/*_paused /etc/ 2>&1")."\n";
				$output .= shell_exec("sudo mv -fv /tmp/config_restore/* /etc/ 2>&1")."\n";
				
				//Restore the Timezone Config
				$timeZone = shell_exec('grep date /var/www/dashboard/config/config.php | grep -o "\'.*\'" | sed "s/\'//g"');
				$timeZone = preg_replace( "/\r|\n/", "", $timeZone);                    //Remove the linebreaks
				shell_exec('sudo timedatectl set-timezone '.$timeZone.' 2>&1');
				
				//Restore ircDDGBateway Link Manager Password
				$ircRemotePassword = shell_exec('grep remotePassword /etc/ircddbgateway | awk -F\'=\' \'{print $2}\'');
				shell_exec('sudo sed -i "/password=/c\\password='.$ircRemotePassword.'" /root/.Remote\ Control');
				
				// Update the hosts files
				$output .= "Updating Hostfiles.\n";
				shell_exec('sudo /usr/local/sbin/HostFilesUpdate.sh 2>&1');
				
				// Make the disk Read-Only
				shell_exec('sudo mount -o remount,ro / 2>&1');
				
				// Start the services
				$output .= "Starting Services.\n";
			    shell_exec('sudo pistar-services start 2>&1');
	
				// Complete
				$output .= "Configuration Restore Complete.\n";
			    }
			    else {
				$output .= "There was a problem with the upload. Please try again.<br />";
				$output .= "\n".'<button onclick="goBack()">Go Back</button><br />'."\n";
				$output .= '<script>'."\n";
				$output .= 'function goBack() {'."\n";
				$output .= '    window.history.back();'."\n";
				$output .= '}'."\n";
				$output .= '</script>'."\n";
			    }
			    echo "<tr><td align=\"left\"><pre>$output</pre></td></tr>\n";
			};
			
			echo "</table>\n";
		    } else { ?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
			    <table width="100%">
				<tr>
				    <th colspan="2"><?php echo $lang['backup_restore'];?></th>
				</tr>
				<tr>
				    <td align="center" valign="top" width="50%"><h3>Download Configuration</h3><br />
					<button style="border: none; background: none; margin: 15px 0px;" name="action" value="download"><img src="/images/download.png" border="0" alt="Download Config" /></button>
				    </td>
				    <td align="center" valign="top"><h3>Restore Configuration</h3><br />
					<button style="border: none; background: none; margin: 10px 0px;" name="action" value="restore"><img src="/images/restore.png" border="0" alt="Restore Config" /></button><br />
    					<input type="file" style="margin: 5px 0px;" name="fileToUpload" id="fileToUpload" />
				    </td>
				</tr>
				<tr>
				    <td colspan="2" align="justify">
					<br />
					<b>WARNING:</b><br />
					Editing the files outside of Pi-Star *could* have un-desireable side effects.<br />
					<br />
					This backup and restore tool, will backup your config files to a Zip file, and allow you to restore them later<br />
					either to this Pi-Star or another one.<br />
					<ul>
					    <li>System Passwords / Dashboard passwords are NOT backed up / restored.</li>
					    <li>Wireless Configuration IS backed up and restored</li>
					</ul>
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
