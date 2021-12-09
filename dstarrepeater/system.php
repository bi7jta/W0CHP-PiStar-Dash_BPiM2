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

?>

<div><b><?php echo $lang['service_status'];?></b><br /></div>
<div class="status-grid">
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('MMDVMHost')); ?>">MMDVMHost</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMRGateway')); ?>">DMRGateway</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('ircddbgatewayd')); ?>">ircDDBGateway</div>  
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSFGateway')); ?>">YSFGateway</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2DMR')); ?>">YSF2DMR</div>
  <div class="grid-item <?php getServiceStatusClass(UPnPenabled()) ?>">UPnP</div>  
  <div class="grid-item <?php getServiceStatusClass(autoAPenabled()) ?>">Auto AP</div>

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
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-watchdog',true)); ?>">PiStar-Watchdog</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-remote',true)); ?>">PiStar-Remote</div> 

  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('cron')); ?>">Cron</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('/usr/local/sbin/pistar-keeper',true)); ?>">PiStar-Keeper</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DGIdGateway')); ?>">DG-ID Gateway</div> 
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMR2YSF')); ?>">DMR2YSF</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2P25')); ?>">YSF2P25</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('YSF2NXDN')); ?>">YSF2NXDN</div>
  <div class="grid-item <?php getServiceStatusClass(isProcessRunning('DMR2NXDN')); ?>">DMR2NXDN</div>
</div>

