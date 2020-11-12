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



// Retrieve server information
//$system = system_information();

function getStatusClass($status, $disabled = false) {
    if ($status) {
	echo '<td class="active-mode-cell" align="left">';
    }
    else {
	if ($disabled)
	    echo '<td class="disabled-mode-cell" align="left">';
	else
	    echo '<td class="inactive-mode-cell" align="left">';
    }
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
                 'mem_info' => $meminfo,
                 'partitions' => disk_list()
    );
}

function disk_list() {
    $partitions = array();
    // Fetch partition information from df command
    // I would have used disk_free_space() and disk_total_space() here but
    // there appears to be no way to get a list of partitions in PHP?
    $output = array();
    @exec('df --block-size=1', $output);
    foreach($output as $line) {
        $columns = array();
        foreach(explode(' ', $line) as $column) {
            $column = trim($column);
            if($column != '') $columns[] = $column;
        }
        
        // Only process 6 column rows
        // (This has the bonus of ignoring the first row which is 7)
        if(count($columns) == 6) {
            $partition = $columns[5];
            $partitions[$partition]['Temporary']['bool'] = in_array($columns[0], array('tmpfs', 'devtmpfs'));
            $partitions[$partition]['Partition']['text'] = $partition;
            $partitions[$partition]['FileSystem']['text'] = $columns[0];
            if(is_numeric($columns[1]) && is_numeric($columns[2]) && is_numeric($columns[3])) {
                $partitions[$partition]['Size']['value'] = $columns[1];
                $partitions[$partition]['Free']['value'] = $columns[3];
                $partitions[$partition]['Used']['value'] = $columns[2];
            }
            else {
                // Fallback if we don't get numerical values
                $partitions[$partition]['Size']['text'] = $columns[1];
                $partitions[$partition]['Used']['text'] = $columns[2];
                $partitions[$partition]['Free']['text'] = $columns[3];
            }
        }
    }
    return $partitions;
}

function formatSize( $bytes ) {
    $types = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $types[$i] );
}

$rootfs_used = (@exec("df --block-size=1m /|awk {'print $5'}|tail -1"));

// Get the CPU temp and colour the box accordingly...
$cpuTempCRaw = exec('cat /sys/class/thermal/thermal_zone0/temp');
if ($cpuTempCRaw > 1000) { $cpuTempC = round($cpuTempCRaw / 1000, 1); } else { $cpuTempC = round($cpuTempCRaw, 1); }
$cpuTempF = round(+$cpuTempC * 9 / 5 + 32, 1);
if ($cpuTempC < 55) { $cpuTempHTML = "<td style=\"background: #1d1\">".$cpuTempF."&deg;F/".$cpuTempC."&deg;C</td>\n"; }
if ($cpuTempC >= 55) { $cpuTempHTML = "<td style=\"background: #fa0\">".$cpuTempF."&degFC/".$cpuTempC."&deg;C</td>\n"; }
if ($cpuTempC >= 69) { $cpuTempHTML = "<td style=\"background: #f00\">".$cpuTempF."&deg;F/".$cpuTempC."&deg;C</td>\n"; }

require_once($_SERVER['DOCUMENT_ROOT'].'/config/language.php');        // Translation Code

$cpuLoad = sys_getloadavg();

// Retrieve server information
$system = system_information();

// get ram
$sysRamUsed = $system['mem_info']['MemTotal'] - $system['mem_info']['MemFree'] - $system['mem_info']['Buffers'] - $system['mem_info']['Cached'];
// format ram in percent
$sysRamPercent = sprintf('%.2f',($sysRamUsed / $system['mem_info']['MemTotal']) * 100);

?>
<h2><?php echo $lang['hardware_info'];?></h2>
<table>
    <tr>
	<th><a class="tooltip" href="#"><?php echo $lang['hostname'];?><br /><span><b>System IP Address:<br /><?php echo str_replace(',', ',<br />', exec('hostname -I'));?></b></span></a></th>
	<th><a class="tooltip" href="#"><?php echo $lang['kernel'];?><span><b>Release</b>This is the version<br />number of the Linux Kernel running<br />on this Raspberry Pi.</span></a></th>
	<th colspan="2"><a class="tooltip" href="#"><?php echo $lang['platform'];?><span><b>Uptime:<br /><?php echo str_replace(',', ',<br />', exec('uptime -p'));?></b></span></a></th>
	<th colspan="2"><a class="tooltip" href="#"><?php echo $lang['cpu_load'];?><span><b>CPU Load</b></span></a></th>
	<th colspan="2"><a class="tooltip" href="#">Memory<span><b>Memory</b></span></a></th>
	<th colspan="2"><a class="tooltip" href="#">Disk<span><b>Disk</b></span></a></th>
	<th><a class="tooltip" href="#"><?php echo $lang['cpu_temp'];?><span><b>CPU Temp</b></span></a></th>
    </tr>
    <tr>
	<td><?php echo php_uname('n');?></td>
	<td><?php echo php_uname('r');?></td>
	<td colspan="2"><?php echo exec('/usr/local/bin/platformDetect.sh');?></td>
	<td colspan="2">1m:<?php echo $cpuLoad[0];?> / 5m:<?php echo $cpuLoad[1];?> / 15m:<?php echo $cpuLoad[2];?></td>
	<td colspan="2"><?php echo $sysRamPercent;?>% Used</td>
	<td colspan="2"><?php echo $rootfs_used;?> Used</td>
	<?php echo $cpuTempHTML; ?>
    </tr>
</table>