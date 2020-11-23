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
	
    # TODO: Map GM TG's to actual names:
    # https://api.brandmeister.network/v1.0/groups/
    # keys: resulting TGs device has subcribed to
    # values: tg list from bm api

    //$results = array_map(function($values) use ($keys) {
    //    return array_combine($keys, $values);
    //    }, $values);
    //
    //var_dump($results);


	// Set some Variable
	$bmStaticTGList = "";
	$bmDynamicTGList = "";

	$mapCMD = 'grep -w "$staticTG->talkgroup" /usr/local/etc/BM_TGs.json|awk {\'print $2\'}|sed \'s/\"//g\'|tr -cd \'[:alnum:]._-\'\)';
	
	// Pull the information from JSON
	if (isset($json->reflector->reflector)) { $bmReflectorDef = "REF".$json->reflector->reflector; } else { $bmReflectorDef = "Not Set"; }
	if (isset($json->reflector->interval)) { $bmReflectorInterval = $json->reflector->interval."(s)"; } else {$bmReflectorInterval = "Not Set"; }
	if ((isset($json->reflector->active)) && ($json->reflector->active != "4000")) { $bmReflectorActive = "REF".$json->reflector->active; } else { $bmReflectorActive = "None"; }
	if (isset($json->staticSubscriptions)) { $bmStaticTGListJson = $json->staticSubscriptions;
            foreach($bmStaticTGListJson as $staticTG) {
                if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "1") {
                    $bgTGname = exec($mapCMD);
                    $bmStaticTGList .= "TG".$staticTG->talkgroup." ".$bgTGname."  ".(".$staticTG->slot.") ";
                }
                else if (getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "2") {
                    $bmStaticTGList .= "TG".$staticTG->talkgroup."(".$staticTG->slot.") ";
                }
                else if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) == "0" && getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $staticTG->slot == "0") {
                    $bmStaticTGList .= "TG".$staticTG->talkgroup." ";
                }
            }
            $bmStaticTGList = wordwrap($bmStaticTGList, 15, "<br />\n");
            if (preg_match('/TG/', $bmStaticTGList) == false) { $bmStaticTGList = "None"; }
        }
	else { $bmStaticTGList = "None"; }
	if (isset($json->dynamicSubscriptions)) { $bmDynamicTGListJson = $json->dynamicSubscriptions;
            foreach($bmDynamicTGListJson as $dynamicTG) {
                if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "1") {
                    $bmDynamicTGList .= "TG".$dynamicTG->talkgroup."(".$dynamicTG->slot.") ";
                }
                else if (getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "2") {
                    $bmDynamicTGList .= "TG".$dynamicTG->talkgroup."(".$dynamicTG->slot.") ";
                }
                else if (getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) == "0" && getConfigItem("DMR Network", "Slot2", $_SESSION['MMDVMHostConfigs']) && $dynamicTG->slot == "0") {
                    $bmDynamicTGList .= "TG".$dynamicTG->talkgroup." ";
                }
            }
            $bmDynamicTGList = wordwrap($bmDynamicTGList, 15, "<br />\n");
            if (preg_match('/TG/', $bmDynamicTGList) == false) { $bmDynamicTGList = "None"; }
        } else { $bmDynamicTGList = "None"; }
	
	echo '<b>Active BrandMeister Connections</b>
  <table>
    <tr>
      <th><a class=tooltip href="#">'.$lang['bm_master'].'<span><b>Connected Master</b></span></a></th>
      <th><a class=tooltip href="#">Default Ref<span><b>Default Reflector</b></span></a></th>
      <th><a class=tooltip href="#">Timeout(s)<span><b>Configured Timeout</b></span></a></th>
      <th><a class=tooltip href="#">Active Ref<span><b>Active Reflector</b></span></a></th>
      <th><a class=tooltip href="#">Static TGs<span><b>Statically linked talkgroups</b></span></a></th>
      <th><a class=tooltip href="#">Dynamic TGs<span><b>Dynamically linked talkgroups</b></span></a></th>
    </tr>'."\n";
	
	echo '    <tr>'."\n";
	echo '     <td>'.$dmrMasterHost.'</td>';
	echo '     <td>'.$bmReflectorDef.'</td>';
	echo '     <td>'.$bmReflectorInterval.'</td>';
	echo '     <td>'.$bmReflectorActive.'</td>';
	echo '     <td>'.$bmStaticTGList.'</td>';
	echo '     <td>'.$bmDynamicTGList.'</td>';
	echo '    </tr>'."\n";
	echo '  </table>'."\n";
	echo '  <br />'."\n";
    }
}
?>
