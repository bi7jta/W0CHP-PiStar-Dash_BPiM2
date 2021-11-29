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

include_once $_SERVER['DOCUMENT_ROOT'].'/config/ircddblocal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';	      // Translation Code
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';

function getServiceStatusClass($active) {
    echo (($active) ? 'active-mode-cell' : 'disabled-mode-cell');
}

// upnp test
function UPnPenabled() {
    $testupnp = exec('grep "pistar-upnp.service" /etc/crontab | cut -c 1');
    if (substr($testupnp, 0, 1) === '#') {
        return 0;
    } else {
        return 1;
    }
}

// Autp AP test
function autoAPenabled() {
if (file_exists('/etc/hostap.off')) {
        return 0;
    } else {
        return 1;
    }
}

?>
<table style="table-layout: fixed;">
    <tr>
	<th colspan="5"><?php echo $lang['service_status'];?></th>
    </tr>
    <tr>
	<td class="<?php getServiceStatusClass(isProcessRunning('MMDVMHost')); ?>">MMDVMHost</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('DMRGateway')); ?>">DMRGateway</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('ircddbgatewayd')); ?>">ircDDBGateway</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('YSFGateway')); ?>">YSFGateway</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('P25Gateway')); ?>">P25Gateway</td>
    </tr>
    <tr>
	<?php if(UPnPenabled() == 1) { print '    <td class="active-mode-cell">UPnP</td>'; } else { print '    <td class="disabled-mode-cell">UPnP</td>'; } ?>
	<?php if(autoAPenabled() == 1) { print '   <td class="active-mode-cell">Auto AP</td>'; } else { print '    <td class="disabled-mode-cell">Auto AP</td>'; } ?>
	<td class="<?php getServiceStatusClass(isProcessRunning('ntpd')); ?>">NTPd</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('NXDNParrot')); ?>">NXDNParrot</td>
    <!-- <td class="<?php getServiceStatusClass(isProcessRunning('DGIdGateway')); ?>">DG-ID Gateway</td> -->
	<td class="<?php getServiceStatusClass(isProcessRunning('')); ?>"></td>
	</tr>
    <tr>
	<td class="<?php getServiceStatusClass(isProcessRunning('dstarrepeaterd')); ?>">DStarRepeater</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('YSFParrot')); ?>">YSFParrot</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('P25Parrot')); ?>">P25Parrot</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('gpsd')); ?>">GPSd</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('APRSGateway')); ?>">APRSGateway</td>
    </tr>
    <tr>
	<td class="<?php getServiceStatusClass(isProcessRunning('timeserverd')); ?>">TimeServer</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-watchdog',true)); ?>">PiStar-Watchdog</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-remote',true)); ?>">PiStar-Remote</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-keeper',true)); ?>">PiStar-Keeper</td>
	<td class="<?php getServiceStatusClass(isProcessRunning('DAPNETGateway')); ?>">DAPNETGateway</td>
    </tr>
</table>
