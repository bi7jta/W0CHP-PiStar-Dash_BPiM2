<?php

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

$VNStat['Interfaces']                                = array();
$VNStat['Interfaces'][0]['Name']                     = $iface;
$VNStat['Interfaces'][0]['Address']                  = $iface;
$VNStat['Binary']                                    = '/usr/bin/vnstat';
$Data = VNStatGetData($iface, $VNStat['Binary']);

echo '
<table>
	<tr>
		<th align="left">Day</th>
		<th align="left">RX</th>
		<th align="left">TX</th>
		<th align="left">Avg. RX</th>
		<th align="left">Avg. TX</th>
  </tr>';

for ($i=0;$i<count($Data[0]);$i++) {  
	if ($Data[0][$i]['time'] > 0) {
		  echo '
		<tr>
			<td width="100" align="left">'.date("m/d/Y", $Data[0][$i]['time']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[0][$i]['rx']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[0][$i]['tx']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[0][$i]['rx2']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[0][$i]['tx2']).'</td>
	  </tr>';
	 }
}

echo '</table>';




echo '
<table>
	<tr>
		<th align="left">Month</th>
		<th align="left">RX</th>
		<th align="left">TX</th>
		<th align="left">Avg. RX</th>
		<th align="left">Avg. TX</th>
  </tr>';

for ($i=0;$i<count($Data[1]);$i++) {  
	if ($Data[1][$i]['time'] > 0) {
		  echo '
		<tr>
			<td width="100" align="left">'.date("m/Y", $Data[1][$i]['time']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[1][$i]['rx']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[1][$i]['tx']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[1][$i]['rx2']).'</td>
			<td width="100" align="left">'.kbytes_to_string($Data[1][$i]['tx2']).'</td>
	  </tr>';
	 }
}

echo '</table>';
?>
