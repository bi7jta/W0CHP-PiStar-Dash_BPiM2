<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';	      // Translation Code

if (isset($_SESSION['CSSConfigs']['ExtraSettings']['LastHeardRows']) && $_SESSION['PiStarRelease']['Pi-Star']['ProcNum'] >= 4) {
    $lastHeardRows = $_SESSION['CSSConfigs']['ExtraSettings']['LastHeardRows'];
    if ($lastHeardRows > 100) {  
	$lastHeardRows = "100";  // need an internal limit
    }
} else {
    $lastHeardRows = "40";
}
if (isset($_SESSION['CSSConfigs']['Background'])) {
    $backgroundModeCellActiveColor = $_SESSION['CSSConfigs']['Background']['ModeCellActiveColor'];
    $backgroundModeCellPausedColor = $_SESSION['CSSConfigs']['Background']['ModeCellPausedColor'];
    $backgroundModeCellInactiveColor = $_SESSION['CSSConfigs']['Background']['ModeCellInactiveColor'];
}
// geoLookup/flags
if (!class_exists('xGeoLookup')) require_once($_SERVER['DOCUMENT_ROOT'].'/classes/class.GeoLookup.php');
$Flags = new xGeoLookup();
$Flags->SetFlagFile("/usr/local/etc/country.csv");
$Flags->LoadFlags();

// for name column
$testMMDVModeDMR = getConfigItem("DMR", "Enable", $_SESSION['MMDVMHostConfigs']);
?>
<input type="hidden" name="lh-autorefresh" value="OFF" />
  <div style="float: right; vertical-align: bottom; padding-top: 0px;" id="lhAR">
        <div class="grid-container" style="display: inline-grid; grid-template-columns: auto 40px; padding: 1px; grid-column-gap: 5px;">
            <div class="grid-item" style="padding-top: 10px;">Auto-Refresh
            </div>
            <div class="grid-item">
                <div style="padding-top:6px;">
		  <input id="toggle-lh-autorefresh" class="toggle toggle-round-flat" type="checkbox" name="lh-autorefresh" value="ON" checked="checked" aria-checked="true" aria-label="Auto-Refresh" onchange="setLHAutorefresh(this)" /><label for="toggle-lh-autorefresh" ></label>
                </div>
            </div>
        </div>
    </div>
<div style="vertical-align: bottom; font-weight: bold; padding-top:14px;text-align:left;"><?php echo $lang['last_heard_list'];?></div>
  <table>
    <tr>
      <th width="250px"><a class="tooltip" href="#"><?php echo $lang['time'];?> (<?php echo date('T')?>)<span><b>Time in <?php echo date('T')?> time zone</b></span></a></th>
      <th><a class="tooltip" href="#"><?php echo $lang['mode'];?><span><b>Transmitted Mode</b></span></a></th>
      <th width="85px"><a class="tooltip" href="#"><?php echo $lang['callsign'];?><span><b>Callsign</b></span></a></th>
<?php
    if (file_exists("/etc/.CALLERDETAILS")) {
?>
      <th width="50px"><a class="tooltip" href="#">Country<span><b>Country</b></span></a></th>
<?php
    }
    if (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 1 ) {
?>
      <th class="noMob"><a class="tooltip" href="#">Name<span><b>Name</b></span></a></th>
<?php
    }
?>
      <th><a class="tooltip" href="#"><?php echo $lang['target'];?><span><b>Target, D-Star Reflector, DMR Talk Group etc</b></span></a></th>
      <th><a class="tooltip" href="#"><?php echo $lang['src'];?><span><b>Received from source</b></span></a></th>
      <th><a class="tooltip" href="#"><?php echo $lang['dur'];?>(s)<span><b>Duration in Seconds</b></span></a></th>
      <th class="noMob"><a class="tooltip" href="#"><?php echo $lang['loss'];?><span><b>Packet Loss</b></span></a></th>
      <th class="noMob"><a class="tooltip" href="#"><?php echo $lang['ber'];?><span><b>Bit Error Rate</b></span></a></th>
    </tr>
<?php
$i = 0;
for ($i = 0;  ($i <= $lastHeardRows - 1); $i++) {
	if (isset($lastHeard[$i])) {
		$listElem = $lastHeard[$i];
		if ( $listElem[2] ) {
                $utc_time = $listElem[0];
                $utc_tz =  new DateTimeZone('UTC');
                $local_tz = new DateTimeZone(date_default_timezone_get ());
                $dt = new DateTime($utc_time, $utc_tz);
                $dt->setTimeZone($local_tz);
                if (constant("TIME_FORMAT") == "24") {
                    $local_time = $dt->format('H:i:s M. jS');
                } else {
                    $local_time = $dt->format('h:i:s A M. jS');
                }
                // malformed calls with a space and freeform text...address these
                if (preg_match('/ /', $listElem[2])) {
                    $listElem[2] = preg_replace('/ .*$/', "", $listElem[2]);
                }
                // end cheesy hack
		// init geo/flag class
		list ($Flag, $Name) = $Flags->GetFlag($listElem[2]);
		if (is_numeric($listElem[2]) || strpos($listElem[2], "openSPOT") !== FALSE || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
		    $flContent = " ";
		} elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/images/flags/".$Flag.".png")) {
		    $flContent = "<a class='tooltip' href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\"><img src='/images/flags/$Flag.png' alt='' style='height:15px;border: 1px solid black;' /><span><b>$Name</b></span></a>";
		} else {
		    $flContent = " ";
		}
		echo"<tr>";
		echo"<td align=\"left\">$local_time</td>";
		echo "<td align=\"left\">".str_replace('Slot ', 'TS', $listElem[1])."</td>";
		if (is_numeric($listElem[2]) || strpos($listElem[2], "openSPOT") !== FALSE) {
		    if (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 1 ) {
                        echo "<td align=\"left\">$listElem[2]</td><td>$flContent</td><td align='left' class='noMob'>$listElem[11]</td>";
		    } elseif (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 0 ) {
                        echo "<td align=\"left\">$listElem[2]</td>><td>$flContent</td>";
		    } else {
                        echo "<td align=\"left\">$listElem[2]</td>";
		    }
		} elseif (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
		    if (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 1 ) {
                        echo "<td align=\"left\">$listElem[2]</td><td>$flContent</td><td align='left' class='noMob'>$listElem[11]</td>";
		    } elseif (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 0 ) {
                        echo "<td align=\"left\">$listElem[2]</td>><td>$flContent</td>";
		    } else {
                        echo "<td align=\"left\">$listElem[2]</td>";
		    }
		} else {
			if (strpos($listElem[2],"-") > 0) { $listElem[2] = substr($listElem[2], 0, strpos($listElem[2],"-")); }
			if ( $listElem[3] && $listElem[3] != '    ' ) {
			    if (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 1 ) {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a>/$listElem[8]</td><td>$flContent</td><td align='left' class='noMob'>$listElem[11]</td>";
			    } elseif (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 0 ) {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a>/$listElem[8]</td><td>$flContent</td>";
			    } else {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a>/$listElem[8]</td>>";
			    }
			} else {
			    if (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 1 ) {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a></td><td>$flContent</td><td align='left' class='noMob'>$listElem[11]</td>";
			    } elseif (file_exists("/etc/.CALLERDETAILS") && $testMMDVModeDMR == 0 ) {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a></td><td>$flContent</td></td>";
			    } else {
				echo "<td align=\"left\"><a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a></td>";
			    }
			}
		}
		if (strlen($listElem[4]) == 1) { $listElem[4] = str_pad($listElem[4], 8, " ", STR_PAD_LEFT); }
		if ( substr($listElem[4], 0, 6) === 'CQCQCQ' ) {
			echo "<td align=\"left\">$listElem[4]</td>";
		} else {
			echo "<td align=\"left\">".str_replace(" ","&nbsp;", $listElem[4])."</td>";
		}


		if ($listElem[5] == "RF"){
			echo "<td><span style='color:$backgroundModeCellInactiveColor;font-weight:bold;'>RF</span></td>";
		} else {
			echo "<td>$listElem[5]</td>";
		}
		if ($listElem[6] == null && (file_exists("/etc/.CALLERDETAILS")))  {
			echo "<td colspan =\"3\" style=\"background:#d11141;color:#fff;\">TX</td>";
		} else if ($listElem[6] == null) {
			// Live duration
			$utc_time = $listElem[0];
			$utc_tz =  new DateTimeZone('UTC');
			$now = new DateTime("now", $utc_tz);
			$dt = new DateTime($utc_time, $utc_tz);
			$duration = $now->getTimestamp() - $dt->getTimestamp();
			$duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
			echo "<td colspan =\"3\" style=\"background:#d11141;color:#fff;\">TX " . $duration_string . " sec</td>";
		} else if ($listElem[6] == "DMR Data") {
			echo "<td colspan =\"3\" style=\"background:#00718F;color:#fff;\">DMR Data</td>";
		} else if ($listElem[6] == "POCSAG Data") {
			echo "<td colspan =\"3\" style=\"background:#00718F;color:#fff;\">POCSAG Data</td>";
		} else {
			echo "<td>$listElem[6]</td>";

			// Colour the Loss Field
			if (floatval($listElem[7]) < 1) { echo "<td class='noMob'>$listElem[7]</td>"; }
			elseif (floatval($listElem[7]) == 1) { echo "<td class='noMob'><span style='color:$backgroundModeCellActiveColor;font-weight:bold'>$listElem[7]</span></td>"; }
			elseif (floatval($listElem[7]) > 1 && floatval($listElem[7]) <= 3) { echo "<td class='noMob'><span style='color:$backgroundModeCellPausedColor;font-weight:bold'>$listElem[7]</span></td>"; }
			else { echo "<td class='noMob'><span style='color:$backgroundModeCellInactiveColor;font-weight:bold;'>$listElem[7]</span></td>"; }

			// Colour the BER Field
			if (floatval($listElem[8]) == 0) { echo "<td class='noMob'>$listElem[8]</td>"; }
			elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.9) { echo "<td class='noMob'><span style='color:$backgroundModeCellActiveColor;font-weight:bold'>$listElem[8]</span></td>"; }
			elseif (floatval($listElem[8]) >= 2.0 && floatval($listElem[8]) <= 4.9) { echo "<td class='noMob'><span style='color:$backgroundModeCellPausedColor;font-weight:bold'>$listElem[8]</span></td>"; }
			else { echo "<td class='noMob'><span style='color:$backgroundModeCellInactiveColor;font-weight:bold;'>$listElem[8]</span></td>"; }
		}
		echo"</tr>\n";
		if (!empty($listElem[10] && file_exists("/etc/.SHOWDMRTA"))) {
		    echo "<tr>";
		    echo "<td colspan='2' style='background:$backgroundContent;'></td>";
		    echo "<td colspan='6' style=\"text-align:left;background:#0000ff;color:#fff;\">&#8593; $listElem[10]</td>";
		    echo "</tr>";
		}
	    }
	}
    }
?>
  </table>

