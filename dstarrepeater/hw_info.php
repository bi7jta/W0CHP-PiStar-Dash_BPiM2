<?php

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_id('pistardashsess');
    session_start();
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
    include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code
    checkSessionValidity();
}

function system_information() {
    @list($system, $host, $kernel) = preg_split('/[\s,]+/', php_uname('a'), 5);
    $meminfo = false;
    if (@is_readable('/proc/meminfo')) {
        $data = explode("\n", file_get_contents("/proc/meminfo"));
        $meminfo = array();
        foreach ($data as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $val) = explode(":", $line);
                $meminfo[$key] = 1024 * floatval( trim( str_replace( ' kB', '', $val ) ) );
            }
        }
    }
    return array('date' => date('Y-m-d H:i:s T'),
                 'mem_info' => $meminfo
    );
}

function formatSize( $bytes ) {
    $types = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $types[$i] );
}

$rootfs_used = @exec("df -h / | tail -1|awk {'print $3'} | sed 's/G//'")." GB". " used of " .@exec("df -h / | tail -1 | awk {'print $2'} | sed 's/G//'")." GB";

// Get the CPU temp and colour the box accordingly...
// Values/thresholds gathered from: 
// <https://www.rs-online.com/designspark/how-does-raspberry-pi-deal-with-overheating>
$cpuTempCRaw = exec('cat /sys/class/thermal/thermal_zone0/temp');
if ($cpuTempCRaw > 1000) { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw / 1000, 1)); } else { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw, 1)); }
$cpuTempF = sprintf('%.0f',round(+$cpuTempC * 9 / 5 + 32, 1));
if ($cpuTempC <= 59) { $cpuTempHTML = "<span style=\"background: inherit\">".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 60) { $cpuTempHTML = "<span style=\"background: #fa0\">".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 80) { $cpuTempHTML = "<span style=\"background: #f00\">".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }

// Gather CPU Loads
//$cpuLoad = sys_getloadavg();
$stat1 = file('/proc/stat'); 
sleep(1); 
$stat2 = file('/proc/stat'); 
$info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0])); 
$info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0])); 
$dif = array(); 
$dif['user'] = $info2[0] - $info1[0]; 
$dif['nice'] = $info2[1] - $info1[1]; 
$dif['sys'] = $info2[2] - $info1[2]; 
$dif['idle'] = $info2[3] - $info1[3]; 
$total = array_sum($dif); 
$cpuLoad = array(); 
foreach($dif as $x=>$y) $cpuLoad[$x] = sprintf('%.0f',round($y / $total * 100, 1));

// Retrieve server information
$system = system_information();

// get ram
$sysRamUsed = $system['mem_info']['MemTotal'] - $system['mem_info']['MemFree'] - $system['mem_info']['Buffers'] - $system['mem_info']['Cached'];
// format ram in percent
$sysRamPercent = exec("free -h | tail -2 | head -1 | awk {'print $3'} | sed 's/Mi/ MB/'") . " used of ".formatSize($system['mem_info']['MemTotal']);

?>
<div class="divTable">
  <div class="divTableBody">
    <div class="divTableRow">
      <div class="divTableHeadCell"><a class="tooltip" href="#"><?php echo $lang['hostname'];?><span><strong>System IP Address<br /></strong><?php echo str_replace(',', ',<br />', exec('hostname -I'));?></a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#"><?php echo $lang['platform'];?><span><strong>Uptime:<br /></strong><?php echo str_replace(',', ',<br />', exec('uptime -p'));?></a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#"><?php echo $lang['kernel'];?><span><strong>Release:<br /></strong>This is the version<br />number of the Linux Kernel running<br />on this Raspberry Pi.</a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#"><?php echo $lang['cpu_load'];?><span><strong>CPU Load</strong></a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#">Memory Usage<span><strong>Memory Usage</strong></a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#">Disk Usage<span><strong>Disk Usage</strong></a></span></div>
      <div class="divTableHeadCell"><a class="tooltip" href="#"><?php echo $lang['cpu_temp'];?><span><strong>CPU Temp</strong></a><span></div>
    </div>
    <div class="divTableRow">
      <div class="divTableCell"><?php echo php_uname('n');?></div>
      <div class="divTableCell"><?php echo exec('/usr/local/sbin/platformDetect.sh');?></div>
      <div class="divTableCell"><?php echo php_uname('r');?></div>
      <div class="divTableCell">User: <?php echo $cpuLoad['user'];?>% / Sys: <?php echo $cpuLoad['sys'];?>% / Nice: <?php echo $cpuLoad['nice'];?>%</div>
      <div class="divTableCell"><?php echo $sysRamPercent;?></div>
      <div class="divTableCell"><?php echo $rootfs_used;?></div>
      <div class="divTableCell"><?php echo $cpuTempHTML; ?></div>
    </div>
  </div>
</div>
