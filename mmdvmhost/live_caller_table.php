<?php
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
	$duration = "<td style=\"background:#F012BE;color:#fff;\">TX " . $duration_string . " sec</td>";
} else if ($listElem[6] == "DMR Data") {
	$duration =  "<td style=\"background: #1d1;color:#fff;\">DMR Data</td>";
} else {
	$duration = "<td>$listElem[6] s</td>";
}

// color the loss field
if ($listElem[7] == null) {
	$loss = "<td>&nbsp;&nbsp;&nbsp;</td>";
} elseif (floatval($listElem[7]) < 1) {
	$loss = "<td>".$listElem[7]."</td>";
} elseif (floatval($listElem[7]) == 1) {
	$loss = "<td style=\"background: #1d1;\">".$listElem[7]."</td>";
} elseif (floatval($listElem[7]) > 1 && floatval($listElem[7]) <= 3) {
	$loss = "<td style=\"background: #fa0;\">".$listElem[7]."</td>";
} else {
	$loss = "<td style=\"background: #f33;\">".$listElem[7]."</td>";
}
			
if ($listElem[8] == null) {
	$ber = "&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
	$mode = $listElem[8];
}

if ($listElem[1] == null) {
	$ber = "&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
	$mode = $listElem[1];
}
			
// Color the BER Field
if (floatval($listElem[8]) == 0) {
	$ber = "<td>$listElem[8]</td>";
} elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.1) {
	$ber = "<td style=\"background: #1d1;\">".$listElem[8]."</rd>";
} elseif (floatval($listElem[8]) >= 1.2 && floatval($listElem[8]) <= 4.9) {
	$ber = "<td style=\"background: #FA0;\">".$listElem[8]."</td>";
} else {
	$ber = "<td style=\"background: #F33;\">".$listElem[8]."</td>";
}

$searchCall = $listElem[2];
$callMatch = array();
$handle = @fopen("/usr/local/etc/stripped.csv", "r");
if ($handle)
{
	while (!feof($handle))
	{
		$buffer = fgets($handle);
		if(strpos($buffer, $searchCall) !== FALSE)
			$callMatch[] = $buffer;
		}
		fclose($handle);
}
$callMatch= explode(",", $callMatch[0]);
$name = "$callMatch[2] $callMatch[3]";
$city = $callMatch[4];
$state = $callMatch[5];
$country = $callMatch[6]; 

if (strlen($target) >= 2) {
	$target_lookup = exec("grep -w \"$target\" /usr/local/etc/groups.txt | awk -F, '{print $1}' | head -1 | tr -d '\"'");
	if (!empty($target_lookup)) {
		$target = $target_lookup;
		$stupid_bm = ['/ - 10 Minute Limit/', '/ NOT A CALL CHANNEL/', '/ NO NETS(.*?)/', '/ - .*/'];
		$target = preg_replace($stupid_bm, "", $target); // strip stupid fucking comments from BM admins in TG names. Idiots.
		$target = str_replace(":", " - ", $target);
	}
}

if (strpos($mode, 'DMR') !== false) {
	$target = "TG $target";
}

if($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET") {
	$name = "";
	$city = "";
	$state = "";
	$country = "";
	$loss = "";
	$ber = "";
	$duration = "";
}

?>

<b>Current / Last Caller Details</b>
<br />
<br />
  <table>
    <tr>
      <th>Callsign</th>
      <th>Name</th>
      <th>Location</th>
      <th>Source</th>
      <th>Mode</th>
      <th>Target</th>
      <th>Duration</th>
      <th>Packet Loss</th>
	  <th>BER</th>
    </tr>
  <tr>
    <td><?php echo $listElem[2] ?? 'Empty'; ?></td>
    <td><?php echo $name ?? 'Empty'; ?></td>
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
		echo "<td style=\"background:#1d1;\">RF</td>";
	} else {
    		echo" <td>".$source ?? 'Empty'."</td>";
	}
    ?>
    <td><?php echo $mode ?? 'Empty'; ?></td>
    <td><?php echo $target ?? 'Empty';; ?></td>
    <?php echo $duration ?? 'Empty';; ?>
    <?php echo $loss; ?>
    <?php echo $ber; ?>
   </tr>
</table>

