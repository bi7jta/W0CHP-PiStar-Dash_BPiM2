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

?>

<div class="divTable">
  <div class="divTableBody">
    <div class="divTableRow center">
      <div class="divTableHeadCell" style="width:280px;">Radio Status</div>
      <div class="divTableHeadCell">TX Freq.</div>
      <div class="divTableHeadCell">RX Freq.</div>
      <div class="divTableHeadCell">Modem Firmware</div>
      <div class="divTableHeadCell">TXCO Freq.</div>
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
                        echo "<div style=\"background:#F012BE; color:#ffffff; font-weight:bold;padding:2px;\">TX: $txMode</div>";
                        break;
                    }
            }
            if ($isTXing == false) {
                    $listElem = $lastHeard[0];
                if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'idle') {
                    echo "<div style=\"background:#0b0; color:#000;font-weight:bold;padding:2px;\">Idle</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === NULL) {
                    if (isProcessRunning("MMDVMHost")) {
                        echo "<div style=\"background:#0b0; color:#000;font-weight:bold;padding:2px;\">Idle</div>";
                    }
                    else {
                        echo "<div style=\"background:#606060; color:#b0b0b0;font-weight:bold;padding:2px;\">OFFLINE</div>";
                    }
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'D-Star') {
                    echo "<div style=\"background:#4aa361;font-weight:bold;padding:2px;\">RX: D-Star</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'D-Star') {
                    echo "<div style=\"background:#ade;font-weight:bold;padding:2px;\">Standby: D-Star</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'DMR') {
                    echo "<div style=\"background:#4aa361; color:#ffffff; font-weight:bold;padding:2px;\">RX: DMR</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'DMR') {
                    echo "<div style=\"background:#f93;font-weight:bold;padding:2px;\">Standby: DMR</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'YSF') {
                    echo "<div style=\"background:#4aa361; color:#ffffff; font-weight:bold;padding:2px;\">RX: YSF</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'YSF') {
                    echo "<div style=\"background:#ff9;font-weight:bold;padding:2px;\">Standby: YSF</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'P25') {
                    echo "<div style=\"background:#4aa361;font-weight:bold;padding:2px;\">RX: P25</div>";
                }
                else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'M17') {
                    echo "<div style=\"background:#4aa361;padding:2px;font-weight:bold;\">RX M17</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'M17') {
                    echo "<div style=\"background:#c9f;padding:2px;font-weight:bold;\">Listening M17</div>";
                }
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'P25') {
                    echo "<div style=\"background:#f9f;font-weight:bold;padding:2px;\">Standby: P25</div>"; 
                }   
                        else if ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'NXDN') {
                    echo "<div style=\"background:#4aa361;font-weight:bold;padding:2px;\">RX: NXDN</div>";
                }   
                else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'NXDN') {
                    echo "<div style=\"background:#c9f;font-weight:bold;padding:2px;\">Standby: NXDN</div>"; 
                }   
                        else if (getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs']) === 'POCSAG') {
                    echo "<div style=\"color:#fff; background:#F012BE; font-weight:bold;padding:2px;\">POCSAG Activity</div>";
                }   
                else {
                    echo "<div>".getActualMode($lastHeard, $_SESSION['MMDVMHostConfigs'])."</div>";
                }   
            }   
        }   
        else {
            echo "<div style=\"background:#0b0; color:#000;font-weight:bold;padding:2px;\">Idle</div>";
        }
        ?>
      </div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getMHZ(getConfigItem("Info", "TXFrequency", $_SESSION['MMDVMHostConfigs'])); ?></div>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo getMHZ(getConfigItem("Info", "RXFrequency", $_SESSION['MMDVMHostConfigs'])); ?></div>
    <?php
        if (isset($_SESSION['DvModemFWVersion'])) {
    ?>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo $_SESSION['DvModemFWVersion']; ?></div>
    <?php } ?>
      <div class="divTableCell hwinfo" style="background: <?php echo $tableRowEvenBg; ?>;"><?php echo $_SESSION['DvModemTCXOFreq']; ?></div>
    </div>
  </div>
</div>

