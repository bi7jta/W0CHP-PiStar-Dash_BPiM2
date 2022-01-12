<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions

if (constant("TIME_FORMAT") == "24") {
    $local_time = date('H:i:s M. jS');
} else {
    $local_time = date('h:i:s A M. jS');
}

// Get the CPU temp and colour the box accordingly...
// Values/thresholds gathered from: 
// <https://www.rs-online.com/designspark/how-does-raspberry-pi-deal-with-overheating>
$cpuTempCRaw = exec('cat /sys/class/thermal/thermal_zone0/temp');
if ($cpuTempCRaw > 1000) { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw / 1000, 1)); } else { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw, 1)); }
$cpuTempF = sprintf('%.0f',round(+$cpuTempC * 9 / 5 + 32, 1));
if ($cpuTempC <= 59) { $cpuTempHTML = "<span class='cpu_norm'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 60) { $cpuTempHTML = "<span class='cpu_warm'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 80) { $cpuTempHTML = "<apan class='cpu_hot'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }

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
        }
    }
}

if ( substr($listElem[4], 0, 6) === 'CQCQCQ' ) {
			$target = $listElem[4];
		} else {
			$target = str_replace(" ","&nbsp;", $listElem[4]);
		}
		
$target = preg_replace('/TG /', '', $listElem[4]);
		
if ($listElem[5] == "RF"){
			$source = "<span class='source_rf'>RF</span>";
		} else {
			$source = "<span class='source_other'>$listElem[5]</span>";
		}
		
        if ($listElem[6] == null) {
            // Live duration
            $utc_time = $listElem[0];
            $utc_tz =  new DateTimeZone('UTC');
            $now = new DateTime("now", $utc_tz);
            $dt = new DateTime($utc_time, $utc_tz);
            $duration = $now->getTimestamp() - $dt->getTimestamp();
            $duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
            $duration = "<span class='dur_tx'>TX " . $duration_string . " sec</span>";
            } else if ($listElem[6] == "DMR Data") {
                $duration =  "<span class='dur_data'>DMR Data</span>";
            } else {
                $duration = $listElem[6]."s";
		    }

if ($listElem[7] == null) { $loss = "&nbsp;&nbsp;&nbsp;";
			}elseif (floatval($listElem[7]) < 1) { $loss = "<span>".$listElem[7]."</span>";
			}elseif (floatval($listElem[7]) == 1) { $loss = "<span class='loss_ok'>".$listElem[7]."</span>"; }
			elseif (floatval($listElem[8]) > 1 && floatval($listElem[7]) <= 3) { $loss = "<span class='loss_med'>".$listElem[7]."</span>"; }
			else { $loss = "<span class='loss_bad'>".$listElem[7]."</span>"; }
			
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
			if (floatval($listElem[8]) == 0) { $ber = $listElem[8]; }
			elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.1) { $ber = "<span class='ber_ok>".$listElem[8]."</span>"; }
			elseif (floatval($listElem[8]) >= 1.2 && floatval($listElem[8]) <= 4.9) { $ber = "<span class='ber_med'>".$listElem[8]."</span>"; }
			else { $ber = "<span class='ber_bad'>".$listElem[8]."</span>"; }

$name = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $3, $4}' | head -1 | tr -d '\"' ");
$city = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $5}' | head -1 | tr -d '\"' ");
$state = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $6}' | head -1 | tr -d '\"' ");
$country = exec("grep -w \"$listElem[2]\" /usr/local/etc/stripped.csv | awk -F, '{print $7}' | head -1 | tr -d '\"' ");

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
      <div class='orange-column'>
        <span class='oc_call'><?php echo $listElem[2]; ?></span>
      </div>
    </div>

    <div class='column'>
      <div class='orange-column'>
        <span class='oc_caller'>
	  <span class='oc_name'>
	    <?php  echo $name;  ?>
	  </span>
	  <br />
	  <?php  echo $city;  ?>
	  <br />
 	  <?php  echo $state;  ?>
	  <br />
 	  <?php  echo $country;  ?>
	</span>
      </div>
    </div>
  </div>

  <div class='row'>
    <div class='column'>
      <div class='dark-column'>
	<span class='dc_info'>
	  Source: 
	  <span class='dc_info_def'>
	    <?php echo $source; ?>
	  </span>
	  <br />
	  Mode: 
	  <span class='dc_info_def'>
	    <?php echo $mode; ?>
	  </span>
	  <br />
	  Target: 
	  <span class='dc_info_def'>
	    <?php echo $target; ?>
	  </span>
	</span>
      </div>
    </div>

    <div class='column'>
      <div class='dark-column'>
	<span class='dc_info'>
	  TX Duration: 
	  <span class='dc_info_def'>
	    <?php echo $duration ?>
	  </span>
	  <br />
          Packet Loss: 
	  <span class='dc_info_def'>
	    <?php echo $loss ?>
	  </span>
	  <br />
          Bit Error Rate: 
	  <span class='dc_info_def'>
	    <?php echo $ber ?>
	  </span>
	</span>
      </div>
    </div>
  </div>

  <div class='row'>
    <div class='column'>
      <div class='dark-column'>
        <div class='hw_info'>
	  Hotspot Time: 
	    <span class='hw_info_def'>
	      <?php echo $local_time; ?>
	    </span>
	</div>
        <div class='hw_info'>
	 CPU Temp: 
	  <span class='hw_info_def'>
	    <?php echo $cpuTempHTML; ?>
	  </span>
	</div>
      </div>
    </div>
  </div>

  <div class='row'>
    <div class='column'>
      <div class='footer-column'>
        <span class='foot_left'><a href="/">Main Dashboard</a></span>
      </div>
    </div>

    <div class='column'>
      <div class='footer-column'>
        <span class="foot_right">Hostname: <?php echo exec('cat /etc/hostname'); ?></span>
      </div>
    </div>
  </div>

</div>
