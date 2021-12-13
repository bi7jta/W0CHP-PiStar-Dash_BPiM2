<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions


function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}

$i = 0;
for ($i = 0;  ($i <= 0); $i++) { //Last 20 calls
	if (isset($lastHeard[$i])) {
		$listElem = $lastHeard[$i];
		if ( $listElem[2] ) {
			$utc_time = $listElem[0];
                        $utc_tz =  new DateTimeZone('UTC');
                        $local_tz = new DateTimeZone(date_default_timezone_get ());
                        $dt = new DateTime($utc_time, $utc_tz);
                        $dt->setTimeZone($local_tz);
                        $local_time = $dt->format('H:i:s M jS');
						$local_time = $dt->format('H:i:s M-j');
}}}

if ( substr($listElem[4], 0, 6) === 'CQCQCQ' ) {
			$target = $listElem[4];
		} else {
			$target = str_replace(" ","&nbsp;", $listElem[4]);
		}
		
$target = preg_replace('/TG /', '', $listElem[4]);
		
if ($listElem[5] == "RF"){
			$source = "<span style=\"color:#f33;\">RF</span>";
		}else{
			$source = "$listElem[5]";
		}
		
        if ($listElem[6] == null) {
            // Live duration
            $utc_time = $listElem[0];
            $utc_tz =  new DateTimeZone('UTC');
            $now = new DateTime("now", $utc_tz);
            $dt = new DateTime($utc_time, $utc_tz);
            $duration = $now->getTimestamp() - $dt->getTimestamp();
            $duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
            $duration = "<td style=\"background:#f33;color:#fff;\">TX " . $duration_string . " sec</td>";
        } else if ($listElem[6] == "DMR Data") {
            $duration =  "<td style=\"background: #1d1;color:#fff;\">DMR Data</td>";
        } else {
            $duration = "<td>$listElem[6] s</td>";

		}

// color the loss field
if ($listElem[7] == null) { $loss = "<td>&nbsp;&nbsp;&nbsp;</td>";
			}elseif (floatval($listElem[7]) < 1) { $loss = "<td>".$listElem[7]."</td>";
			}elseif (floatval($listElem[7]) == 1) { $loss = "<td style=\"background: #1d1;\">".$listElem[7]."</td>"; }
			elseif (floatval($listElem[7]) > 1 && floatval($listElem[7]) <= 3) { $loss = "<td style=\"background: #fa0;\">".$listElem[7]."</td>"; }
			else { $loss = "<td style=\"background: #f33;\">".$listElem[7]."</td>"; }
			
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
			if (floatval($listElem[8]) == 0) { $ber = "<td>$listElem[8]</td>"; }
			elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.1) { $ber = "<td style=\"background: #1d1;\">".$listElem[8]."</rd>"; }
			elseif (floatval($listElem[8]) >= 1.2 && floatval($listElem[8]) <= 4.9) { $ber = "<td style=\"background: #FA0;\">".$listElem[8]."</td>"; }
			else { $ber = "<td style=\"background: #F33;\">".$listElem[8]."</td>"; }


$name = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $3, $4}' | head -1 | tr -d '\"' ");
$city = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $5}' | head -1 | tr -d '\"' ");
$state = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $6}' | head -1 | tr -d '\"' ");
$country = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $7}' | head -1 | tr -d '\"' ");

if (strlen($target) >= 2) {
	$target_lookup = exec("grep -w \"$target\" /usr/local/etc/groups.txt | awk -F, '{print $1}' | head -1 | tr -d '\"'| sed 's/ -.*//g' ");
	if (!empty($target_lookup)) {
		$target = $target_lookup;
		$target = str_replace(":", " - ", $target);
        // BM uses stupid comments in TG names. Delete them...
        $stupid_bm = ['/ - 10 Minute Limit/', '/ NOT A CALL CHANNEL/', '/ NO NETS\!\!\!/'];
        $target = preg_replace($stupid_bm, "", $target);
	}
}
if (strpos($mode, 'DMR') !== false) {
    $target = "TG $target";
}

if($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET"){
$name = "";
$city = "";
$state = "";
$country = "";
$loss = "";
$ber = "";
$duration = "";
}

?>

<input type="hidden" name="livecaller-autorefresh" value="OFF" />
  <div style="float: right; vertical-align: bottom; padding-top: 5px;">
    <div class="grid-container" style="display: inline-grid; grid-template-columns: auto 40px; padding: 1px; grid-column-gap: 5px;">
        <div class="grid-item" style="padding-top: 3px;" >Auto-Refresh
        </div>
        <div class="grid-item" >
        <div> <input id="toggle-livecaller-autorefresh" class="toggle toggle-round-flat" type="checkbox" name="localtx-autorefresh" value="ON" checked="checked" aria-checked="true" aria-label="Auto-Refresh" onchange="setLCautorefresh(this)" /><label for="toggle-livecaller-autorefresh" ></label>
        </div>
        </div>
    </div>
    </div>
<b>Live Caller Details</b>
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
    <td><?php echo $source ?? 'Empty'; ?></td>
    <td><?php echo $mode ?? 'Empty'; ?></td>
    <td><?php echo $target ?? 'Empty';; ?></td>
    <?php echo $duration ?? 'Empty';; ?>
    <?php echo $loss; ?>
    <?php echo $ber; ?>
   </tr>
</table>

