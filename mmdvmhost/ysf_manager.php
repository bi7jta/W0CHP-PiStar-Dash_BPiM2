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

// Check if YSF is Enabled
if (isset($_SESSION['YSFGatewayConfigs']['YSF Network']['Enable']) == 1) {
// Check that the remote is enabled
if (isset($_SESSION['YSFGatewayConfigs']['Remote Commands']['Enable']) && (isset($_SESSION['YSFGatewayConfigs']['Remote Commands']['Port'])) && ($_SESSION['YSFGatewayConfigs']['Remote Commands']['Enable'] == 1)) {
	$remotePort = $_SESSION['YSFGatewayConfigs']['Remote Commands']['Port'];
	if (!empty($_POST) && isset($_POST["ysfMgrSubmit"])) {
	    // Handle Posted Data
	    if (preg_match('/[^A-Za-z0-9]/',$_POST['ysfLinkHost'])) {
		unset($_POST['ysfLinkHost']);
	    }
	    if ($_POST["Link"] == "LINK") {
		if ($_POST['ysfLinkHost'] == "none") {
		    $remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." UnLink";
		}
		else {
		    $ysfLinkHost = $_POST['ysfLinkHost'];
		    $ysfType = substr($ysfLinkHost, 0, 3);
		    $ysfID = substr($ysfLinkHost, 3);
		    $remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." Link".$ysfType." ".$ysfID."";
		}
	    }
	    else if ($_POST["Link"] == "UNLINK") {
		$remoteCommand = "cd /var/log/pi-star && sudo /usr/local/bin/RemoteCommand ".$remotePort." UnLink";
	    }
	    else {
		echo "<b>YSF Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo "<p>Something wrong with your input, (Neither Link nor Unlink Sent) - please try again</p>";
		echo "</td></tr>\n</table>\n<br />\n";
		unset($_POST);
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	    }
	    if (empty($_POST['ysfLinkHost'])) {
		echo "<b>YSF Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo "<p>Something wrong with your input, (No target specified) -  please try again</p>";
		echo "</td></tr>\n</table>\n<br />\n";
		unset($_POST);
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	    }
	    if (isset($remoteCommand)) {
		echo "<b>YSF Link Manager</b>\n";
		echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
		echo "<p>";
		echo exec($remoteCommand);
		echo "<br />Page reloading...</td></tr>\n</table>\n<br />\n";
		echo "</p>";
		echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	    }
	}
	else {
	    // Output HTML
	?>
    	<b>YSF Link Manager</b>
	    <form action="//<?php echo htmlentities($_SERVER['HTTP_HOST']).htmlentities($_SERVER['PHP_SELF']); ?>?func=ysf_man" method="post">
		<table>
		    <tr>
			<th width="150"><a class="tooltip" href="#">Reflector<span><b>Reflector</b></span></a></th>
			<th width="150"><a class="tooltip" href="#">Link / Un-link<span><b>Link or Un-link</b></span></a></th>
			<th width="150"><a class="tooltip" href="#">Action<span><b>Action</b></span></a></th>
		    </tr>
		    <tr>
			<td>
			    <select name="ysfLinkHost" class="ysfLinkHost">
				<?php
				if (isset($_SESSION['YSFGatewayConfigs']['Network']['Startup'])) {
				    $testYSFHost = $_SESSION['YSFGatewayConfigs']['Network']['Startup'];
				    echo "      <option value=\"none\">None</option>\n";
        			}
				else {
				    $testYSFHost = "none";
				    echo "      <option value=\"none\" selected=\"selected\">None</option>\n";
    				}
				if ($testYSFHost == "ZZ Parrot")  {
				    echo "      <option value=\"YSF00001\" selected=\"selected\">YSF00001 - Parrot</option>\n";
				}
				else {
				    echo "      <option value=\"YSF00001\">YSF00001 - Parrot</option>\n";
				}
				if ($testYSFHost == "YSF2DMR")  {
				    echo "      <option value=\"YSF00002\"  selected=\"selected\">YSF00002 - Link YSF2DMR</option>\n";
				}
				else {
				    echo "      <option value=\"YSF00002\">YSF00002 - Link YSF2DMR</option>\n";
				}
				if ($testYSFHost == "YSF2NXDN") {
				    echo "      <option value=\"YSF00003\" selected=\"selected\">YSF00003 - Link YSF2NXDN</option>\n";
				}
				else {
				    echo "      <option value=\"YSF00003\">YSF00003 - Link YSF2NXDN</option>\n";
				}
				if ($testYSFHost == "YSF2P25")  {
				    echo "      <option value=\"YSF00004\"  selected=\"selected\">YSF00004 - Link YSF2P25</option>\n";
				}
				else {
				    echo "      <option value=\"YSF00004\">YSF00004 - Link YSF2P25</option>\n";
				}
				$ysfHosts = fopen("/usr/local/etc/YSFHosts.txt", "r");
				while (!feof($ysfHosts)) {
				    $ysfHostsLine = fgets($ysfHosts);
				    $ysfHost = preg_split('/;/', $ysfHostsLine);
				    if ((strpos($ysfHost[0], '#') === FALSE ) && ($ysfHost[0] != '')) {
					if (strlen($ysfHost[1]) >= 30) {
					    $ysfHost[1] = substr($ysfHost[1], 0, 27)."...";
					}
                                        if ($testYSFHost == $ysfHost[1]) { echo "      <option value=\"YSF$ysfHost[0]\" selected=\"selected\">YSF$ysfHost[0] - ".htmlspecialchars($ysfHost[1])." - ".htmlspecialchars($ysfHost[2])."</option>\n"; }
					else {
					    echo "      <option value=\"YSF$ysfHost[0]\">YSF$ysfHost[0] - ".htmlspecialchars($ysfHost[1])." - ".htmlspecialchars($ysfHost[2])."</option>\n";
					}
				    }
				}
				fclose($ysfHosts);
				if (file_exists("/usr/local/etc/FCSHosts.txt")) {
				    $fcsHosts = fopen("/usr/local/etc/FCSHosts.txt", "r");
				    while (!feof($fcsHosts)) {
					$ysfHostsLine = fgets($fcsHosts);
					$ysfHost = preg_split('/;/', $ysfHostsLine);
					if (substr($ysfHost[0], 0, 3) == "FCS") {
					    if (strlen($ysfHost[1]) >= 30) {
						$ysfHost[1] = substr($ysfHost[1], 0, 27)."...";
					    }
                                            if ($testYSFHost == $ysfHost[0]) { echo "      <option value=\"$ysfHost[0]\" selected=\"selected\">$ysfHost[0] - ".htmlspecialchars($ysfHost[1])."</option>\n"; }
					    else {
						echo "      <option value=\"$ysfHost[0]\">$ysfHost[0] - ".htmlspecialchars($ysfHost[1])."</option>\n";
					    }
					}
				    }
				    fclose($fcsHosts);
				}
				?>
				</select>
			</td>
			<td>
			    <input type="radio" name="Link" value="LINK" />Link
			    <input type="radio" name="Link" value="UNLINK" checked="checked"  />Un-Link
			</td>
			<td>
			    <input type="hidden" name="func" value="ysf_man" />
			    <input type="submit" name="ysfMgrSubmit" value="Request Change" />
			</td>
		    </tr>
                    <tr>
                      <td colspan="3" style="white-space:normal;padding: 3px;">
                        [ <b><a href="https://w0chp.net/ysf-reflectors/" target="_blank">List of YSF Reflectors (searchable/downloadable)</a></b> |
                        <b><a href="https://w0chp.net/fcs-reflectors/" target="_blank">List of FCS Reflectors (searchable/downloadable)</a></b> ]
                      </td>
                    </tr>
                </table>
	    </form>
	    <?php
	}
    }
}
?>
