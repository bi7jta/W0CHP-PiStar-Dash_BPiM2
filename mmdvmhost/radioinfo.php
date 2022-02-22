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

include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';          // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php';        // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php';    // MMDVMDash Functions
include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';	      // Translation Code
require_once($_SERVER['DOCUMENT_ROOT'].'/config/ircddblocal.php');

if (isset($_SESSION['CSSConfigs']['Background']['TableRowBgEvenColor'])) {
    $tableRowEvenBg = $_SESSION['CSSConfigs']['Background']['TableRowBgEvenColor'];
} else {
    $tableRowEvenBg = "inherit";
}

$ModemFW = $_SESSION['PiStarRelease']['Pi-Star']['Firmware'];
$ModemTCXO = str_replace("MHz", " MHz",$_SESSION['PiStarRelease']['Pi-Star']['TCXO']);

?>

<div class="divTable">
  <div class="divTableBody">
    <div class="divTableRow center">
      <div class="divTableHeadCell" style="width:280px;">Radio Status</div>
      <div class="divTableHeadCell">TX Freq.</div>
      <div class="divTableHeadCell">RX Freq.</div>
      <div class="divTableHeadCell">Modem Firmware</div>
      <div class="divTableHeadCell">TXCO Freq.</div>
      <div class="divTableHeadCell">Modem Port</div>
      <div class="divTableHeadCell">Modem Speed</div>
    </div>
    <div class="divTableRow center">
      <div class="divTableCell hwinfo">
        <?php
        // TRX Status code
        if (isset($lastHeard[0])) {
            $isTXing = false;

            // Go through the whole LH array, backward, looking for transmission.
            for (end($lastHeard); (($currentKey = key($lastHeard)) !== null); prev($lastHeard)) {                                                                         
                    $listElem = current($lastHeard);
                    if ($listElem[2] && ($listElem[6] == null) && ($listElem[5] !== 'RF')) {                                                                              
                        $isTXing = true;
                        // Get rid of 'Slot x' for DMR, as it is meaningless, when 2 slots are txing at the same time.
                        $txMode = preg_split('#\s+#', $listElem[1])[0];
                        echo "<div style=\"background:#d11141; color:#ffffff; font-weight:bold;padding:2px;\">TX: $txMode</div>";
                        break;
                    }
            }
            if ($isTXing == false) {
                    $listElem = $lastHeard[0];
                if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'idle') {
		    if (isProcessRunning("MMDVMHost")) {
                    	echo "<div style=\"font-weight:bold;padding:2px;\"><span style='color:#005028;'>Idle</span></div>";
		    }
		    else { 
                        echo "<div class='error-state-cell' style=\"font-weight:bold;padding:2px;\">OFFLINE</div>";
		    }
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === NULL) {
                    if (isProcessRunning("MMDVMHost")) {
                        echo "<div style=\"font-weight:bold;padding:2px;\"><span style='color:#005028;'>Idle</span></div>";
                    }
                    else {
                        echo "<div class='error-state-cell' style=\"font-weight:bold;padding:2px;\">OFFLINE</div>";
                    }
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'D-Star') {
                    echo "<div style=\"background:#00aedb;font-weight:bold;padding:2px;\">RX: D-Star</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'D-Star') {
                    echo "<div style=\"background:#ffc425;font-weight:bold;padding:2px;\">Standby: D-Star</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'DMR') {
                    echo "<div style=\"background:#00aedb; color:#ffffff; font-weight:bold;padding:2px;\">RX: DMR</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'DMR') {
                    echo "<div style=\"background:#ffc425;font-weight:bold;padding:2px;\">Standby: DMR</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'YSF') {
                    echo "<div style=\"background:#00aedb; color:#ffffff; font-weight:bold;padding:2px;\">RX: YSF</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'YSF') {
                    echo "<div style=\"background:#ffc425;font-weight:bold;padding:2px;\">Standby: YSF</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'P25') {
                    echo "<div style=\"background:#00aedb;font-weight:bold;padding:2px;\">RX: P25</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'P25') {
                    echo "<div style=\"background:#ffc425;font-weight:bold;padding:2px;\">Standby: P25</div>"; 
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'M17') {
                    echo "<div style=\"background:#00aedb;padding:2px;font-weight:bold;\">RX M17</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'M17') {
                    echo "<div style=\"background:#ffc425;padding:2px;font-weight:bold;\">Standby: M17</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'NXDN') {
                    echo "<div style=\"background:#00aedb;font-weight:bold;padding:2px;\">RX: NXDN</div>";
                }   
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'NXDN') {
                    echo "<div style=\"background:#ffc425;font-weight:bold;padding:2px;\">Standby: NXDN</div>"; 
                }   
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'POCSAG') {
                    echo "<div style=\"color:#fff; background:#d11141; font-weight:bold;padding:2px;\">POCSAG Activity</div>";
                }   
                else {
                    echo "<div>".getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs'])."</div>";
                }   
            }   
        }   
        else {
            echo "<div style=\"font-weight:bold;padding:2px;\"><span style='color:#005028;'>Idle</span></div>";
        }
        ?>
      </div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getMHZ(getConfigItem("Info", "TXFrequency", $_SESSION['MMDVMHostConfigs'])); ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getMHZ(getConfigItem("Info", "RXFrequency", $_SESSION['MMDVMHostConfigs'])); ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo $ModemFW; ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo $ModemTCXO; ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getConfigItem("Modem", "UARTPort", $_SESSION['MMDVMHostConfigs']); ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getConfigItem("Modem", "UARTSpeed", $_SESSION['MMDVMHostConfigs']); ?> bps</div>
    </div>
  </div>
</div>

