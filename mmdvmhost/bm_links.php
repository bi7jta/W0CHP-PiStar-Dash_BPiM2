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
include_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';        // Translation Code

// Check if DMR is Enabled
$testMMDVModeDMR = getConfigItem("DMR", "Enable", $_SESSION['MMDVMHostConfigs']);

if ( $testMMDVModeDMR == 1 ) {
    $bmEnabled = true;
    
    // Get the current DMR Master from the config
    $dmrMasterHost = getConfigItem("DMR Network", "Address", $_SESSION['MMDVMHostConfigs']);
    if ( $dmrMasterHost == '127.0.0.1' ) {
	$dmrMasterHost = $_SESSION['DMRGatewayConfigs']['DMR Network 1']['Address'];
	$bmEnabled = ($_SESSION['DMRGatewayConfigs']['DMR Network 1']['Enabled'] != "0" ? true : false);
	if (isset($_SESSION['DMRGatewayConfigs']['DMR Network 1']['Id'])) { $dmrID = $_SESSION['DMRGatewayConfigs']['DMR Network 1']['Id']; }
    }
    else if (getConfigItem("DMR", "Id", $_SESSION['MMDVMHostConfigs'])) {
	$dmrID = getConfigItem("DMR", "Id", $_SESSION['MMDVMHostConfigs']);
    }
    else {
	$dmrID = getConfigItem("General", "Id", $_SESSION['MMDVMHostConfigs']);
    }
    
    // Store the DMR Master IP, we will need this for the JSON lookup
    $dmrMasterHostIP = $dmrMasterHost;
    
    // Make sure the master is a BrandMeister Master
    if (($dmrMasterFile = fopen("/usr/local/etc/DMR_Hosts.txt", "r")) != FALSE) {
	while (!feof($dmrMasterFile)) {
            $dmrMasterLine = fgets($dmrMasterFile);
            $dmrMasterHostF = preg_split('/\s+/', $dmrMasterLine);
            if ((strpos($dmrMasterHostF[0], '#') === FALSE) && ($dmrMasterHostF[0] != '')) {
		if ($dmrMasterHost == $dmrMasterHostF[2]) { $dmrMasterHost = str_replace('_', ' ', $dmrMasterHostF[0]); }
            }
	}
	fclose($dmrMasterFile);
    }
    
    if ((substr($dmrMasterHost, 0, 2) == "BM") && ($bmEnabled == true)) {
	// Use BM API to get information about current TGs
	$jsonContext = stream_context_create(array('http'=>array('timeout' => 2, 'header' => 'User-Agent: Pi-Star '.$_SESSION['PiStarRelease']['Pi-Star']['Version'].'W0CHP-Dashboard for '.$dmrID) )); // Add Timout and User Agent to include DMRID
	$json = json_decode(@file_get_contents("https://api.brandmeister.network/v1.0/repeater/?action=PROFILE&q=$dmrID", true, $jsonContext));
	
	// Set some Variable
	$bmStaticTGList = "";
	$bmDynamicTGList = "";
        $bmDynanicTGname = "";
        $bmDynanicTGexpire = "";
	
	// Pull the information from JSON
	if (isset($json->staticSubscriptions)) { $bmStaticTGListJson = $json->staticSubscriptions;
            foreach($bmStaticTGListJson as $staticTG) {
                if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "1") {
                    $bmStaticTGname = exec("grep -w \"$staticTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
                    $bmStaticTGList .= "TG".$staticTG->talkgroup." ".$bmStaticTGname."<span style='float:right;'>(".$staticTG->slot.")</span><br />";
                }
                else if (getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "2") {
                    $bmStaticTGname = exec("grep -w \"$staticTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
                    $bmStaticTGList .= "TG".$staticTG->talkgroup." ".$bmStaticTGname."<span style='float:right;'>(".$staticTG->slot.")</span><br />";
                }
                else if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) == "0" && getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "0") {
                    $bmStaticTGname = exec("grep -w \"$staticTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
                    $bmStaticTGList .= "TG".$staticTG->talkgroup." ".$bmStaticTGname." ";
                }
            }
            $bmStaticTGList = wordwrap($bmStaticTGList, 135, "\n");
            if (preg_match('/TG/', $bmStaticTGList) == false) { $bmStaticTGList = "None"; }
        }
	else { $bmStaticTGList = "None"; }
	if (isset($json->dynamicSubscriptions)) { $bmDynamicTGListJson = $json->dynamicSubscriptions;
            foreach($bmDynamicTGListJson as $dynamicTG) {
                if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "1") {
                    $bmDynamicTGname = exec("grep -w \"$dynamicTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
	            $bmDynamicTGList .= "TG".$dynamicTG->talkgroup."<span style='float:right;'>".$bmDynamicTGname." (".$dynamicTG->slot.")</span><br /><small style='float:right;'>(Idle timeout: ".date("h:i:s", substr($dynamicTG->timeout, 0, 10))." ".date('T').")</span></small><br /><br />";
                }
                else if (getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "2") {
                    $bmDynamicTGname = exec("grep -w \"$dynamicTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
	            $bmDynamicTGList .= "TG".$dynamicTG->talkgroup."<span style='float:right;'>".$bmDynamicTGname." (".$dynamicTG->slot.")</span><br /><small style='float:right;'>(Idle timeout: ".date("h:i:s", substr($dynamicTG->timeout, 0, 10))." ".date('T').")</span></small><br /><br />";
                }
                else if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) == "0" && getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "0") {
                    $bmDynamicTGname = exec("grep -w \"$dynamicTG->talkgroup\" /usr/local/etc/BM_TGs.json | cut -d\":\" -f2- | tr -cd \"'[:alnum:]\/ -\"");
                    $bmDynamicTGList .= "TG".$dynamicTG->talkgroup."<span style='float:right;'>".$bmDynamicTGname."</span><br /><small style='float:right;'>(Idle timeout: ".date("h:i:s", substr($dynamicTG->timeout, 0, 10)).")</span></small><br /><br />";
                }
            }
            $bmDynamicTGList = wordwrap($bmDynamicTGList, 135, "\n");
            if (preg_match('/TG/', $bmDynamicTGList) == false) { $bmDynamicTGList = "None"; }
        } else { $bmDynamicTGList = "None"; }
	
	echo '<b>Active BrandMeister Connections</b>
  <table>
    <tr>
      <th align="left" style="padding-left: 8px;"><a class=tooltip href="#">Connected to Master:<span><b>Connected Master</b></span></a></th>
      <th align="left" style="padding-left: 8px;"><a class=tooltip href="#">Static Talkgroups (Slot #)<span><b>Statically linked talkgroups</b></span></a></th>
      <th align="left" style="padding-left: 8px;"><a class=tooltip href="#">Dynamic Talkgroups (Slot #)<span><b>Dynamically linked talkgroups</b></span></a></th>
    </tr>'."\n";
	
	echo '    <tr>'."\n";
	echo '     <td align="left" style="padding: 8px;white-space:normal; word-wrap:break; width:200px;">'.$dmrMasterHost.'<br /><small>(<a href="https://brandmeister.network/?page=hotspot&amp;id='.$dmrID.'" target="_new" title="Click to view your hotspot info on BrandMeister">Your HotSpot/Repeater ID: '.$dmrID.'</a>)</small></td>';
	echo '     <td align="left" style="padding: 8px;">'.$bmStaticTGList.'</td>';
	echo '     <td align="left" style="padding: 8px;">'.$bmDynamicTGList.'</td>';
	echo '    </tr>'."\n";
	echo '    <tr>'."\n";
	echo '      <td colspan="3"><b><a href="https://w0chp.net/brandmeister-talkgroups/" target="_blank">List of All BrandMeister Talkgroups (sortable/searchable/downloadable)...</a></b></td>'."\n";
	echo '    </tr>'."\n";
	echo '  </table>'."\n";
    }
}
?>
