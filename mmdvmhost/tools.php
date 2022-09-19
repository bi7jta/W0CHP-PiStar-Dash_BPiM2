<?php

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_id('pistardashsess');
    session_start();
}

function format_time($seconds) {
	$secs = intval($seconds % 60);
	$mins = intval($seconds / 60 % 60);
	$hours = intval($seconds / 3600 % 24);
	$days = intval($seconds / 86400);
	$uptimeString = "";

	if ($days > 0) {
		$uptimeString .= $days;
		$uptimeString .= (($days == 1) ? "&nbsp;day" : "&nbsp;days");
	}
	if ($hours > 0) {
		$uptimeString .= (($days > 0) ? ", " : "") . $hours;
		$uptimeString .= (($hours == 1) ? "&nbsp;hr" : "&nbsp;hrs");
	}
	if ($mins > 0) {
		$uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
		$uptimeString .= (($mins == 1) ? "&nbsp;min" : "&nbsp;mins");
	}
	if ($secs > 0) {
		$uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
		$uptimeString .= (($secs == 1) ? "&nbsp;s" : "&nbsp;s");
	}
	return $uptimeString;
}

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
	return true;
    }
    return (strcasecmp(substr($haystack, -$length), $needle) == 0);
}

function getMHZ($freq) {
	return substr($freq,0,3) . "." . substr($freq,3,6) . " MHz";
}

function isProcessRunning($processName, $full = false, $refresh = false) {
  if ($full) {
    static $processes_full = array();
    if ($refresh) $processes_full = array();
    if (empty($processes_full))
      exec('ps -eo args', $processes_full);
  } else {
    static $processes = array();
    if ($refresh) $processes = array();
    if (empty($processes))
      exec('ps -eo comm', $processes);
  }
  foreach (($full ? $processes_full : $processes) as $processString) {
    if (strpos($processString, $processName) !== false)
      return true;
  }
  return false;
}

function createConfigLines() { 
	$out ="";
	foreach($_GET as $key=>$val) { 
		if($key != "cmd") {
			$out .= "define(\"$key\", \"$val\");"."\n";
		}
	}
	return $out;
} 

function getSize($filesize, $precision = 2) {
	$units = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');
	foreach ($units as $idUnit => $unit) {
		if ($filesize > 1024)
			$filesize /= 1024;
		else
			break;
	}
	return round($filesize, $precision).' '.$units[$idUnit].'B';
}

function encode($hex) {
    $validchars = " abcdefghijklmnopqrstuvwxyzäöüßABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜ0123456789";
    $str        = '';
    $chrval     = hexdec($hex);
    $str        = chr($chrval);
    if (strpos($validchars, $str)>=0)
      return $str;
    else
      return "";
}

function checkSetup() {
	$el = error_reporting();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	if (defined(DISTRIBUTION)) {
?>
<div class="alert alert-danger" role="alert">You are using an old config.php. Please configure your Dashboard by calling <a href="setup.php">setup.php</a>!</div>
<?php
		
		} else {
		if (file_exists ("setup.php")) {
	?>
	<div class="alert alert-danger" role="alert">You forgot to remove setup.php in root-directory of your dashboard or you forgot to configure it! Please delete the file or configure your Dashboard by calling <a href="setup.php">setup.php</a>!</div>
	<?php
		}
	}
	error_reporting($el);
}

// for taffic stats
$VNStat['Interfaces'] = array();
$VNStat['Interfaces'][0]['Name'] = '';
$VNStat['Interfaces'][0]['Address'] = '';
$VNStat['Interfaces'][1]['Name'] = '';
$VNStat['Interfaces'][1]['Address'] = '';
$VNStat['Binary'] = '/usr/bin/vnstat';
function VNStatGetData($iface, $vnstat_bin) {
   $vnstat_data = array();

   $fd = @popen("$vnstat_bin --dumpdb -i $iface", "r");
   if (is_resource($fd)) {
      $buffer = '';
      while (!feof($fd)) {
         $buffer .= fgets($fd);
      }
        $vnstat_data = explode("\n", $buffer);
        pclose($fd);
   }
   $day = array();
   $hour = array();
   $month = array();
   $top = array();
   if (isset($vnstat_data[0]) && strpos($vnstat_data[0], 'Error') !== false) {
      return;
   }
   foreach($vnstat_data as $line) {
      $d = explode(';', trim($line));
      if ($d[0] == 'd') {
         $day[$d[1]]['time']  = $d[2];
         $day[$d[1]]['rx']    = $d[3] * 1024 + $d[5];
         $day[$d[1]]['tx']    = $d[4] * 1024 + $d[6];
         $day[$d[1]]['act']   = $d[7];
         $day[$d[1]]['rx2']   = $d[5];
         $day[$d[1]]['tx2']   = $d[6];
      }
      else if ($d[0] == 'm') {
         $month[$d[1]]['time'] = $d[2];
         $month[$d[1]]['rx']   = $d[3] * 1024 + $d[5];
         $month[$d[1]]['tx']   = $d[4] * 1024 + $d[6];
         $month[$d[1]]['act']  = $d[7];
         $month[$d[1]]['rx2']  = $d[5];
         $month[$d[1]]['tx2']  = $d[6];
      }
      else if ($d[0] == 'h') {
         $hour[$d[1]]['time'] = $d[2];
         $hour[$d[1]]['rx']   = $d[3];
         $hour[$d[1]]['tx']   = $d[4];
         $hour[$d[1]]['act']  = 1;
      }
      else if ($d[0] == 't') {
         $top[$d[1]]['time'] = $d[2];
         $top[$d[1]]['rx']   = $d[3] * 1024 + $d[5];
         $top[$d[1]]['tx']   = $d[4] * 1024 + $d[6];
         $top[$d[1]]['act']  = $d[7];
      }
      else {
         $summary[$d[0]] = isset($d[1]) ? $d[1] : '';
      }
   }
   rsort($day);
   rsort($month);
   rsort($hour);
   return array($day, $month, $hour, $day, $month, $top, $summary);
}
function kbytes_to_string($kb) {
   $byte_notation  = null;
   $units          = array('TB','GB','MB','KB');
   $scale          = 1024*1024*1024;
   $ui             = 0;
   $custom_size = isset($byte_notation) && in_array($byte_notation, $units);
   while ((($kb < $scale) && ($scale > 1)) || $custom_size) {
      $ui++;
      $scale = $scale / 1024;
      if ($custom_size && $units[$ui] == $byte_notation) {
         break;
      }
   }
   return sprintf("%0.2f %s", ($kb/$scale),$units[$ui]);
}

?>
