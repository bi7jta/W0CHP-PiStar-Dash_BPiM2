<?php
if (file_exists('/etc/.CALLERDETAILS')) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code
    // geoLookup/flags
    if (!class_exists('xGeoLookup')) require_once($_SERVER['DOCUMENT_ROOT'].'/classes/class.GeoLookup.php');
    $Flags = new xGeoLookup();
    $Flags->SetFlagFile("/usr/local/etc/country.csv");
    $Flags->LoadFlags();
?>
<div style="vertical-align: bottom; font-weight: bold;text-align:left;margin-top:-8px;">Current / Last Caller Details</div>
  <table style="word-wrap: break-word; white-space:normal;">
    <tr>
      <th width="230px"><a class="tooltip" href="#"><?php echo $lang['callsign'];?>&nbsp;&nbsp;/&nbsp;&nbsp;Country<span><b>Callsign / Country</b></span></a></th>
      <th>Name</th>
      <th>Location</th>
      <th>Src</th>
      <th>Mode</th>
      <th>Target</th>
      <th>Duration</th>
    </tr>
<?php
// get the data from the MMDVMHost logs
$i = 0;
for ($i = 0;  ($i <= 0); $i++) { //Last 20  calls
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
            // YSF sometimes has malformed calls with a space and freeform text...address these
            if (preg_match('/ /', $listElem[2])) {
                $listElem[2] = preg_replace('/ .*$/', "", $listElem[2]);
            }
            // end cheesy YSF hack
            if (is_numeric($listElem[2]) || strpos($listElem[2], "openSPOT") !== FALSE) {
                $callsign = $listElem[2];
            } elseif (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
                $callsign = $listElem[2];
            } else {
                if (strpos($listElem[2],"-") > 0) {
                    $listElem[2] = substr($listElem[2], 0, strpos($listElem[2],"-"));
                }
		if ( $listElem[3] && $listElem[3] != '    ' ) {
		    $callsign = "<a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a>/$listElem[3]";
		} else {
		    $callsign = "<a href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\">$listElem[2]</a>";
		}
            }

	    if ( substr($listElem[4], 0, 6) === 'CQCQCQ' ) {
		$target = $listElem[4];
	    } else {
		$target = str_replace(" ","&nbsp;", $listElem[4]);
	    }
		
	    $target = preg_replace('/TG /', '', $listElem[4]);

	    $source = $listElem[5];
	
	    if ($listElem[6] == null) {
		// Live duration
		$utc_time = $listElem[0];
		$utc_tz =  new DateTimeZone('UTC');
		$now = new DateTime("now", $utc_tz);
		$dt = new DateTime($utc_time, $utc_tz);
		$duration = $now->getTimestamp() - $dt->getTimestamp();
		$duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
		$duration = "<td style=\"background:#d11141;color:#fff;\">TX " . $duration_string . " sec</td>";
	    } else if ($listElem[6] == "DMR Data") {
		$duration =  "<td style=\"background:#00718F;color:#fff;\">DMR Data</td>";
	    } else if ($listElem[6] == "POCSAG Data") {
		$duration =  "<td style=\"background:#00718F;color:#fff;\">POCSAG Data</td>";
	    } else {
		$duration = "<td>$listElem[6]s</td>";
	    }

	    if ($listElem[8] == null) {
		$ber = "&nbsp;";
	    } else {
		$mode = $listElem[8];
	    }

	    if ($listElem[1] == null) {
		$ber = "&nbsp;";
	    } else {
		$mode = $listElem[1];
	    }
			
	    if (!is_numeric($listElem[2])) {
        	$searchCall = $listElem[2];
        	$callMatch = array();
		if ($mode == "NXDN") {
		    $handle = @fopen("/usr/local/etc/NXDN.csv", "r");
		} else { # all other modes
		    $handle = @fopen("/usr/local/etc/stripped.csv", "r");
		}
        	if ($handle)
        	{ 
                    while (!feof($handle))
                    {
                	$buffer = fgets($handle);
                	if (strpos($buffer, $searchCall) !== FALSE)
                	{
			    $csvBuffer = explode(",", $buffer);
			    if(strpos($searchCall, $csvBuffer[1]) !== FALSE)
				$callMatch[] = $buffer;
			}
		    }
		    fclose($handle);
		}
		$callMatch = explode(",", $callMatch[0]);
		$name = ucwords(strtolower("$callMatch[2] $callMatch[3]"));
		$city = ucwords(strtolower($callMatch[4]));
		$state = ucwords(strtolower($callMatch[5]));
		$country = ucwords(strtolower($callMatch[6]));
		if(strpos($country, "United States") !== false) {
		   $country = str_replace("United States", "USA", $country);
		}
		if (strlen($country) > 150) {
		    $country = substr($country, 0, 120) . '...';
		}	
		if (empty($callMatch[0])) {
		    $name = getName($listElem[2]);
		    $country = "---";
		}
	    }

	    if (strlen($target) >= 2) {
		if (strpos($mode, 'DMR') !== false) {
		    $target_lookup = exec("grep -w \"$target\" /usr/local/etc/groups.txt | awk -F, '{print $1}' | head -1 | tr -d '\"'");
		    if (!empty($target_lookup)) {
			$target = $target_lookup;
			$stupid_bm = ['/ - 10 Minute Limit/', '/ NOT A CALL CHANNEL/', '/ NO NETS(.*?)/', '/ - .*/'];
			$target = preg_replace($stupid_bm, "", $target); // strip stupid fucking comments from BM admins in TG names. Idiots.
			$target = "TG $target";
		    } else {
			$target = "TG $target";
		    }
		} else if (strpos($mode, 'NXDN') !== false) {
		    $target_lookup = exec("grep -w \"$target\" /usr/local/etc/TGList_NXDN.txt | awk -F';' '{print $2}'");
		    if (!empty($target_lookup)) {
			$target = "TG $target: $target_lookup";
		    }
		} else if (strpos($mode, 'P25') !== false) {
		    $target_lookup = exec("grep -w \"$target\" /usr/local/etc/TGList_P25.txt | awk -F';' '{print $2}'");
			if (!empty($target_lookup)) {
			    $target = "TG $target: $target_lookup";
			}
		} else {
		    $target = $target;
		}
	    } else {
		$modeArray = array('DMR', 'NXDN', 'P25');
		if (strpos($mode, $modeArray[0]) !== false) {
		    $target = "TG $target";
		} else {
		    $target = $target;
		}
	    }

	    if($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET") {
		$name = "---";
		$city = "";
		$state = "";
		$country = "---";
		$duration = "<td>---</td>";
	    }
	    // init geo/flag class
	    list ($Flag, $Name) = $Flags->GetFlag($listElem[2]);
	    if (is_numeric($listElem[2]) || strpos($listElem[2], "openSPOT") !== FALSE || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
 		$flContent = "---";
	    } elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/images/flags/".$Flag.".png")) {
		$flContent = "<a class='tooltip' href=\"http://www.qrz.com/db/$listElem[2]\" target=\"_blank\"><img src='/images/flags/$Flag.png' alt='' style='height:20px;border: 1px solid black;' /><span><b>$Name</b></span></a>";
	    } else {
		$flContent = "---";
	    }

?>
  <tr>
    <td align="left" style="padding:3px 0 3px 0;"><strong style="font-size:1.2em;padding-left:15px;"><?php echo $callsign ?? ' '; ?></strong><span style='padding:1px 15px 0 0;float:right;'><?php echo $flContent; ?></span></td>
    <td><?php echo $name ?? ' '; ?></td>
    <td><?php
		if (!empty($city)) {
			echo $city .", ";
		}
		if (!empty($state)) {
			echo $state . ", ";
		} if (!empty($country)) { 
			echo $country; 
		} ?></td>
    <?php
	if ($listElem[5] == "RF") {
		echo "<td><span style='color:$backgroundModeCellInactiveColor;font-weight:bold;'>RF</span></td>";
	} else {
    		echo" <td>".$source ?? ' '."</td>";
	}
    ?>
    <td><?php echo $mode ?? ' '; ?></td>
    <td><?php echo $target ?? ' '; ?></td>
    <?php echo $duration; ?>
   </tr>
<?php
	    }
	}
    }
?>
</table>
<br />
<?php
}
?>
