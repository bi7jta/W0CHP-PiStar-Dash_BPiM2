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

<div><b><?php echo $lang['service_status'];?></b><br /></div>
<div class="status-grid">
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('MMDVMHost')); ?>">MMDVMHost</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMRGateway')); ?>">DMRGateway</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('ircddbgatewayd')); ?>">ircDDBGateway</div>  
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSFGateway')); ?>">YSFGateway</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2DMR')); ?>">YSF2DMR</div>
  <div class="grid-item <?php if(UPnPenabled() == 1) { print 'active-mode-cell'; } else { print 'disabled-mode-cell'; } ?>">UPnP</div>  
  <div class="grid-item <?php if(autoAPenabled() == 1) { print 'active-mode-cell'; } else { print 'disabled-mode-cell'; } ?>">Auto AP</div>

  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('ntpd')); ?>">NTPd</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('NXDNGateway')); ?>">NXDNGateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('NXDNParrot')); ?>">NXDNParrot</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('NXDN2DMR')); ?>">NXDN2DMR</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('APRSGateway')); ?>">APRSGateway</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('dstarrepeaterd')); ?>">DStarRepeater</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSFParrot')); ?>">YSFParrot</div>

  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('P25Gateway')); ?>">P25Gateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('P25Parrot')); ?>">P25Parrot</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('gpsd')); ?>">GPSd</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DAPNETGateway')); ?>">DAPNETGateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('timeserverd')); ?>">TimeServer</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('APRSGateway')); ?>">APRSGateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-watchdog',true)); ?>">PiStar-Watchdog</div> 

  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-remote',true)); ?>">PiStar-Remote</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-keeper',true)); ?>">PiStar-Keeper</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DGIdGateway')); ?>">DG-ID Gateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMR2YSF')); ?>">DMR2YSF</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2P25')); ?>">YSF2P25</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2NXDN')); ?>">YSF2NXDN</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMR2NXDN')); ?>">DMR2NXDN</div>
</div>

