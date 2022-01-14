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
} else if ($listElem[6] == "DMR Data")
    {
	$duration =  "<span class='dur_data'>DMR Data</span>";
} else {
	$duration = $listElem[6]."s";
}

if ($listElem[7] == null) {
	$loss = "&nbsp;&nbsp;&nbsp;";
	}
	elseif (floatval($listElem[7]) < 1) { $loss = "<span>".$listElem[7]."</span>";
	}
	elseif (floatval($listElem[7]) == 1) { $loss = "<span class='loss_ok'>".$listElem[7]."</span>";
	}
	elseif (floatval($listElem[8]) > 1 && floatval($listElem[7]) <= 3) { $loss = "<span class='loss_med'>".$listElem[7]."</span>";
} else {
	$loss = "<span class='loss_bad'>".$listElem[7]."</span>";
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
	$ber = $listElem[8];
}
elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.1)
{
	$ber = "<span class='ber_ok>".$listElem[8]."</span>";
}
	elseif (floatval($listElem[8]) >= 1.2 && floatval($listElem[8]) <= 4.9)
{
	$ber = "<span class='ber_med'>".$listElem[8]."</span>";
} else {
	$ber = "<span class='ber_bad'>".$listElem[8]."</span>";
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

if ($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET") {
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
	    <?php
	    if (!empty($city)) {
		echo "<br /> $city";
	    }  
	    if (!empty($state)) {
		echo "<br />$state";
	    } 
	    echo "<br />$country";
	    ?>
	  </span>
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
      <div class='footer-column'>
        <span class='foot_left'>
	  <a href="/">Main Dashboard</a>
	</span>
        <span class='foot_right'>
          Hotspot Time:
          <span class='hw_info_def'>
            <?php echo $local_time; ?>
          </span>
	</span>
      </div>
    </div>
  </div>

</div>
