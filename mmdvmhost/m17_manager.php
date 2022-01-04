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

include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code

// Check if M17 is Enabled
#$testMMDVModeM17 = getConfigItem("M17 Network", "Enable", $_SESSION['MMDVMHostConfigs']);
#if ( $testMMDVModeM17 == 1 ) {
    // Check that the remote is enabled
    #if (!isset($_SESSION['M17GatewayConfigs']['Remote Commands']['Enable']) && (isset($_SESSION['M17GatewayConfigs']['Remote Commands']['Port'])) && ($_SESSION['M17GatewayConfigs']['Remote Commands']['Enable'] == 1)) {
	$remotePort = $_SESSION['M17GatewayConfigs']['Remote Commands']['Port'];
	if (!empty($_POST) && isset($_POST["m17MgrSubmit"])) {
	    // Handle Posted Data
	    if (!preg_match('/[^A-Za-z0-9]/',$_POST['m17LinkHost'])) {
		unset($_POST['m17LinkHost']);
	    }
	    if ($_POST["Link"] == "LINK") {
		if ($_POST['m17LinkHost'] == "None") {
		    $remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." UnLink";
		}
		else { # /usr/local/bin/RemoteCommand 6075 ReflectorM17-USA C
		    #$remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." Reflector".$_POST['m17LinkHost']." ".$m17Module;
		    $remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." Reflector".$_POST['m17LinkHost']." C";
		}
	    } else if ($_POST["Link"] == "UNLINK") {
		$remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." UnLink";
	    }
	    else {
		echo "<b>M17 Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo "Somthing wrong with your input, (Neither Link nor Unlink Sent) - please try again";
		echo "</td></tr>\n</table>\n<br />\n";
		unset($_POST);
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},2000);</script>';
	    }
	    if (empty($_POST['m17LinkHost'])) {
		echo "<b>M17 Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo "Somthing wrong with your input, (No target specified) -  please try again";
		echo "</td></tr>\n</table>\n<br />\n";
		unset($_POST);
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},2000);</script>';
	    }
	    if (isset($remoteCommand)) {
		echo "<b>M17 Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo exec($remoteCommand);
		echo "</td></tr>\n</table>\n<br />\n";
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},2000);</script>';
	    }
	}
	else {
	    // Output HTML
	    ?>
    	    <b>M17 Link Manager</b>
	    <form action="//<?php echo htmlentities($_SERVER['HTTP_HOST']).htmlentities($_SERVER['PHP_SELF']); ?>?func=m17_man" method="post">
		<table>
		    <tr>
			<th width="150"><a class="tooltip" href="#">Reflector<span><b>Reflector</b></span></a></th>
			<th width="150"><a class="tooltip" href="#">Link / Unlink<span><b>Link or unlink</b></span></a></th>
			<th width="150"><a class="tooltip" href="#">Action<span><b>Action</b></span></a></th>
		    </tr>
		    <tr>
			<td>
			    <select name="m17LinkHost">
				<?php
				if (isset($_SESSION['M17GatewayConfigs']['Network']['Startup'])) {
				    $testM17Host = $_SESSION['M17GatewayConfigs']['Network']['Startup'];
				}
				else {
				    $testM17Host = "None";
				}
				if ($testM17Host == "") {
				    echo "      <option value=\"none\" selected=\"selected\">None</option>\n";
				}
				else {
				    echo "      <option value=\"none\">None</option>\n";
				}
				$m17Hosts = fopen("/usr/local/etc/M17Hosts.txt", "r");
				while (!feof($m17Hosts)) {
              			    $m17HostsLine = fgets($m17Hosts);
				    $m17Host = preg_split('/\s+/', $m17HostsLine);
				    if ((strpos($m17Host[0], '#') === FALSE ) && ($m17Host[0] != '')) {
                			if ($testM17Host == $m17Host[0]) {
					    echo "      <option value=\"$m17Host[0]\" selected=\"selected\">$m17Host[0]</option>\n";
					}
					else {
					    echo "      <option value=\"$m17Host[0]\">$m17Host[0]</option>\n";
					}
				    }
				}
				fclose($m17Hosts);
				if (file_exists('/usr/local/etc/M17HostsLocal.txt')) {
              			    $m17Hosts2 = fopen("/usr/local/etc/M17HostsLocal.txt", "r");
				    while (!feof($m17Hosts2)) {
                			$m17HostsLine2 = fgets($m17Hosts2);
					$m17Host2 = preg_split('/\s+/', $m17HostsLine2);
					if ((strpos($m17Host2[0], '#') === FALSE ) && ($m17Host2[0] != '')) {
                        		    if ($testM17Host == $m17Host2[0]) {
						echo "      <option value=\"$m17Host2[0]\" selected=\"selected\">$m17Host2[0]</option>\n";
					    }
					    else {
						echo "      <option value=\"$m17Host2[0]\">$m17Host2[0]</option>\n";
					    }
					}
				    }
				    fclose($m17Hosts2);
				}
				?>
			</td>
			<td>
			    <input type="radio" name="Link" value="LINK" checked="checked" />Link
			    <input type="radio" name="Link" value="UNLINK" />UnLink
			</td>
			<td>
			    <input type="submit" name="m17MgrSubmit" value="Request Change" />
			</td>
		    </tr>
		</table>
	    </form>
	    <br />
	<?php
#	}
#    }
}
?>
