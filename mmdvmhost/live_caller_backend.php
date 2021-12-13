
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
for ($i = 0;  ($i <= 0); $i++) { //Last 20  calls
//for ($i = 0;  ($i <= 19); $i++) { //Last 20 calls
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
			$source = "<span style=\"color:#8195ED;\">$listElem[5]</span>";
		}
		
        if ($listElem[6] == null) {
            // Live duration
            $utc_time = $listElem[0];
            $utc_tz =  new DateTimeZone('UTC');
            $now = new DateTime("now", $utc_tz);
            $dt = new DateTime($utc_time, $utc_tz);
            $duration = $now->getTimestamp() - $dt->getTimestamp();
            $duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
            $duration = "<span style=\"color:#f33;\">TX " . $duration_string . " sec</span>";
        } else if ($listElem[6] == "DMR Data") {
            $duration =  "<span style=\"color: #1d1;\">DMR Data</span>";
        } else {
            $duration = $listElem[6]."s";

		}

if ($listElem[7] == null) { $loss = "&nbsp;&nbsp;&nbsp;";
			}elseif (floatval($listElem[7]) < 1) { $loss = "<span>".$listElem[7]."</span>";
			}elseif (floatval($listElem[7]) == 1) { $loss = "<span style=\"color: #1d1;\">".$listElem[7]."</span>"; }
			elseif (floatval($listElem[7]) > 1 && floatval($listElem[7]) <= 3) { $loss = "<span style=\"color: #fa0;\">".$listElem[7]."</span>"; }
			else { $loss = "<span style=\"color: #f33;\">".$listElem[7]."</span>"; }
			
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
			
// Colour the BER Field
			if (floatval($listElem[8]) == 0) { $ber = $listElem[8]; }
			elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.1) { $ber = "<span style=\"color: #1d1;\">".$listElem[8]."</span>"; }
			elseif (floatval($listElem[8]) >= 1.2 && floatval($listElem[8]) <= 4.9) { $ber = "<span style=\"color: #FA0;\">".$listElem[8]."</span>"; }
			else { $ber = "<span style=\"color: #F33;\">".$listElem[8]."</span>"; }


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
<div class='live-page-wrapper'>
  <div class='row'>
    <div class='column'>
      <div class='orange-column' style="color: #000; font-size: 11em; font-weight: bold;">
        <?php echo $listElem[2]; ?>
      </div>
    </div>

    <div class='column'>
      <div class='orange-column' style="color: #000; font-size: 2.8em;">
        <strong style="font-size: 1.3em;"><?php  echo $name;  ?></strong><br />
        <?php  echo $city;  ?><br />
        <?php  echo $state;  ?><br />
        <?php  echo $country;  ?>
      </div>
    </div>
  </div>

  <div class='row'>
    <div class='column'>
      <div class='dark-column' style="color: #808080; font-size: 38px; font-weight: bold;">
        Source: <span style="color:#D8D8D8;"><?php echo $source; ?></span><br />
        Mode: <span style="color:#D8D8D8;"><?php echo $mode; ?></span><br />
        Target: <span style="color:#D8D8D8;"><?php echo $target; ?></span>
      </div>
    </div>

    <div class='column'>
      <div class='dark-column' style="color: #808080; font-size: 38px; font-weight: bold;">
        TX Duration: <span style="color:#D8D8D8;"><?php echo $duration ?></span><br />
        Packet Loss: <span style="color:#D8D8D8;"><?php echo $loss ?></span><br />
        Bit Error Rate: <span style="color:#D8D8D8;"><?php echo $ber ?></span>
      </div>
    </div>
  </div>
</div>
