<?php
if (file_exists('/etc/.CALLERDETAILS')) {
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions

if (constant("TIME_FORMAT") == "24") {
    $local_time = date('H:i:s M. jS');
} else {
    $local_time = date('h:i:s A M. jS');
}

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
        }
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
	$diuration =  "<td style=\"background:#00718F;color:#fff;\">POCSAG Data</td>";
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
        $name = "$callMatch[2] $callMatch[3]";
        $city = $callMatch[4];
        $state = $callMatch[5];
        $country = $callMatch[6];
}

if (strlen($target) >= 2) {
    if (strpos($mode, 'DMR') !== false) {
        $target_lookup = exec("grep -w \"$target\" /usr/local/etc/groups.txt | awk -F, '{print $1}' | head -1 | tr -d '\"'");
        if (!empty($target_lookup)) {
                $target = $target_lookup;
                $stupid_bm = ['/ - 10 Minute Limit/', '/ NOT A CALL CHANNEL/', '/ NO NETS(.*?)/', '/ - .*/'];
                $target = preg_replace($stupid_bm, "", $target); // strip stupid fucking comments from BM admins in TG names. Idiots.
                $target = str_replace(":", " - ", $target);
                $target = "TG $target";
        } else {
                $target = "TG $target";
        }
    } else if (strpos($mode, 'NXDN') !== false) {
        $target_lookup = exec("grep -w \"$target\" /usr/local/etc/TGList_NXDN.txt | awk -F';' '{print $2}'");
        if (!empty($target_lookup)) {
                $target = "TG $target - $target_lookup";
        }
    } else if (strpos($mode, 'P25') !== false) {
        $target_lookup = exec("grep -w \"$target\" /usr/local/etc/TGList_P25.txt | awk -F';' '{print $2}'");
        if (!empty($target_lookup)) {
                $target = "TG $target - $target_lookup";
        }
    } else {
        $target = $target;
    }
} else {
    $modeArray = array('DMR', 'NXDN', 'P25');
    if (strpos($mode, $modearray, 1) !== false) {
        $target = "TG $target";
    } else {
        $target = $target;
    }
}

if($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET") {
	$name = "";
	$city = "";
	$state = "";
	$country = "";
	$duration = "<td></td>";
}

?>

<div style="vertical-align: bottom; font-weight: bold;text-align:left;">Current / Last Caller Details</div>
  <table style="word-wrap: break-word; white-space:normal;">
    <tr>
      <th>Callsign</th>
      <th>Name</th>
      <th>Location</th>
      <th>Source</th>
      <th>Mode</th>
      <th>Target</th>
      <th>Duration</th>
    </tr>
  <tr>
    <td><?php echo $listElem[2] ?? ' '; ?></td>
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
		echo "<td><span style='color:#005028;font-weight:bold;'>RF</span></td>";
	} else {
    		echo" <td>".$source ?? ' '."</td>";
	}
    ?>
    <td><?php echo $mode ?? ' '; ?></td>
    <td><?php echo $target ?? ' '; ?></td>
    <?php echo $duration ?? ' '; ?>
   </tr>
</table>
<br />
<?php } ?>
