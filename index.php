<?php
session_set_cookie_params(0, "/");
session_name("PiStar Dashboard Session");
session_id('pistardashsess');
session_start();

//require_once('set_session.php');
require_once('config/config.php');
require_once('config/version.php');
require_once('mmdvmhost/functions.php');
require_once('config/ircddblocal.php');
require_once('config/language.php');

$progname = basename($_SERVER['SCRIPT_FILENAME'],".php");
$rev = $version;
$MYCALL = strtoupper($callsign);
$_SESSION['MYCALL'] = $MYCALL;

// Clear session data (page {re}load);
unset($_SESSION['BMAPIKey']);
unset($_SESSION['DAPNETAPIKeyConfigs']);
unset($_SESSION['PiStarRelease']);
unset($_SESSION['MMDVMHostConfigs']);
unset($_SESSION['ircDDBConfigs']);
unset($_SESSION['DStarRepeaterConfigs']);
unset($_SESSION['DMRGatewayConfigs']);
unset($_SESSION['YSFGatewayConfigs']);
unset($_SESSION['DAPNETGatewayConfigs']);
unset($_SESSION['YSF2DMRConfigs']);
unset($_SESSION['YSF2NXDNConfigs']);
unset($_SESSION['YSF2P25Configs']);
unset($_SESSION['DMR2YSFConfigs']);
unset($_SESSION['DMR2NXDNConfigs']);
unset($_SESSION['APRSGatewayConfigs']);
unset($_SESSION['NXDNGatewayConfigs']);
unset($_SESSION['P25GatewayConfigs']);
unset($_SESSION['DvModemFWVersion']);
unset($_SESSION['DvModemTCXOFreq']);

checkSessionValidity();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
    <head>
	<meta name="robots" content="index" />
	<meta name="robots" content="follow" />
	<meta name="language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo "<meta name=\"generator\" content=\"$progname $rev\" />\n"; ?>
	<meta name="Description" content="Pi-Star Dashboard" />
	<meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,W0CHP" />
	<meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<title><?php echo "$MYCALL"." - ".$lang['digital_voice']." ".$lang['dashboard'];?></title>
	<link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	<?php include_once "config/browserdetect.php"; ?>
	<script type="text/javascript" src="/jquery.min.js"></script>
	<script type="text/javascript" src="/jquery-floatThead.min.js"></script>
	<script type="text/javascript" src="/functions.js?version=1.706"></script>
	<script type="text/javascript">
	 $.ajaxSetup({ cache: false });
	</script>
	<link href="/featherlight.css" type="text/css" rel="stylesheet" />
	<script src="/featherlight.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
	<div class="container">
	    <div class="header">
		<div style="font-size: 8px; text-align: right; padding-right: 8px;">Pi-Star:<?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version']?> / <?php echo $lang['dashboard'].": ".$version; ?></div>
		<h1>Pi-Star <?php echo $lang['digital_voice']." ".$lang['dashboard_for']." ".$_SESSION['MYCALL']; ?></h1>
		
		<p>
 		    <div class="navbar">
			<a class="menuconfig" href="/admin/configure.php"><?php echo $lang['configuration'];?></a>
			<?php if ($_SERVER["PHP_SELF"] == "/admin/index.php") {
			    echo ' <a class="menuupdate" href="/admin/update.php">'.$lang['update'].'</a>'."\n";
			    echo ' <a class="menupower" href="/admin/power.php">'.$lang['power'].'</a>'."\n";
			    echo ' <a class="menusysinfo" href="/admin/sysinfo.php">Sysinfo</a>'."\n";
			    echo ' <a class="menulogs" href="/admin/live_modem_log.php">'.$lang['live_logs'].'</a>'."\n";
			} ?>
			<a class="menuadmin" href="/admin/"><?php echo $lang['admin'];?></a>
			<a class="menudashboard" href="/"><?php echo $lang['dashboard'];?></a>
		    </div> 
		</p>
	    </div>
	    
	    <?php
	    
	    // Output some default features
	    if ($_SERVER["PHP_SELF"] == "/index.php")
	    {
		echo '<div class="contentwide">'."\n";
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadHwInfo(){'."\n";
		echo '  $("#hwInfo").load("/dstarrepeater/hw_info.php",function(){ setTimeout(reloadHwInfo, 15000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadHwInfo, 15000);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		echo '<div id="hwInfo">'."\n";
		include 'dstarrepeater/hw_info.php';
		echo '</div>'."\n";
		echo '</div>'."\n";
		echo '<br />'."\n";
	    }
	    else if ($_SERVER["PHP_SELF"] == "/admin/index.php") {
		echo '<div class="contentwide">'."\n";
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadHwInfo(){'."\n";
		echo '  $("#hwInfo").load("/dstarrepeater/hw_info.php",function(){ setTimeout(reloadHwInfo, 15000) });'."\n";
		echo '}'."\n";
		echo 'function reloadSysInfo(){'."\n";
		echo '  $("#sysInfo").load("/dstarrepeater/system.php",function(){ setTimeout(reloadSysInfo,15000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadHwInfo,15000);'."\n";
		echo 'setTimeout(reloadSysInfo,15000);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		if (empty($_POST) && empty($_GET)) {				// only show services on main admin page
		    echo '<div id="hwInfo">'."\n";
		    include 'dstarrepeater/hw_info.php';			// Basic System Info
		    echo '</div>'."\n";
		    echo '<div id="sysInfo">'."\n";
		    include 'dstarrepeater/system.php';				// Basic System Info
		    echo '</div>'."\n";
                }
		echo '</div>'."\n";
	    }
	    
	    // First lets figure out if we are in MMDVMHost mode, or dstarrepeater mode;
	    if (file_exists('/etc/dstar-radio.mmdvmhost')) {
		//include 'config/config.php';					// MMDVMDash Config
		//	include_once 'mmdvmhost/tools.php';				// MMDVMDash Tools
		
		echo '<div class="nav">'."\n";					// Start the Side Menu
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadRepeaterInfo(){'."\n";
		echo '  $("#repeaterInfo").load("/mmdvmhost/repeaterinfo.php",function(){ setTimeout(reloadRepeaterInfo,1000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadRepeaterInfo,1000);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		echo '<div id="repeaterInfo">'."\n";
		include 'mmdvmhost/repeaterinfo.php';				// MMDVMDash Repeater Info
		echo '</div>'."\n";
		echo '</div>'."\n";
		
		echo '<div class="content">'."\n";

		// menu/selection set:
    		// BM check: Get the current DMR Master from the config
    		$dmrMasterHost = getConfigItem("DMR Network", "Address", $_SESSION['MMDVMHostConfigs']);
    		if ( $dmrMasterHost == '127.0.0.1' ) {
        		$dmrMasterHost = $_SESSION['DMRGatewayConfigs']['DMR Network 1']['Address'];
        		$bmEnabled = ($_SESSION['DMRGatewayConfigs']['DMR Network 1']['Enabled'] != "0" ? true : false);
    		}
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
    		} // end BM check
		// tgif check:
                if ( $dmrMasterHost == '127.0.0.1' ) {
                    // DMRGateway, need to check each config
                    if (($_SESSION['DMRGatewayConfigs']['DMR Network 1']['Address'] == "tgif.network") && ($_SESSION['DMRGatewayConfigs']['DMR Network 1']['Enabled'])) {
                        $tgif = true;
                    }
                    elseif (($_SESSION['DMRGatewayConfigs']['DMR Network 2']['Address'] == "tgif.network") && ($_SESSION['DMRGatewayConfigs']['DMR Network 2']['Enabled'])) {
                        $tgif = true;
                    }
                    elseif (($_SESSION['DMRGatewayConfigs']['DMR Network 3']['Address'] == "tgif.network") && ($_SESSION['DMRGatewayConfigs']['DMR Network 3']['Enabled'])) {
                        $tgif = true;
                    }
                        elseif (($_SESSION['DMRGatewayConfigs']['DMR Network 4']['Address'] == "tgif.network") && ($_SESSION['DMRGatewayConfigs']['DMR Network 4']['Enabled'])) {
                        $tgif = true;
                    }
                    elseif (($_SESSION['DMRGatewayConfigs']['DMR Network 5']['Address'] == "tgif.network") && ($_SESSION['DMRGatewayConfigs']['DMR Network 5']['Enabled'])) {
                        $tgif = true;
                    }
                    elseif ( $dmrMasterHost == 'tgif.network' ) { // no fmrgateway...TGIF is master
                        $tgif = true;
                    }
                } // end tgif check
		// begin admin selection form
		if ($_SERVER["PHP_SELF"] == "/admin/index.php") {
                    echo '<b>Admin Sections<b>';
		    echo '<form method="get" id="admin_sel" name="admin_sel" action="'.htmlentities($_SERVER['PHP_SELF']).'">';
                    echo '  <table>';
		    echo '    <tr>';
		    echo '      <th>Select a Mode/Network/Service to Manage</th>';
		    echo '    </tr>';
		    echo '    <tr>';
		    echo '      <td>';
		    echo '      <div class="mode_flex">';		
		    echo '        <button form="admin_sel" type="submit" value="mode_man" name="func"><span>Instant Mode Manager</span></button>';
                    $testMMDVModeDSTARnet = getConfigItem("D-Star Network", "Enable", $_SESSION['MMDVMHostConfigs']);
                    if ( $testMMDVModeDSTARnet == 1 ) {
                        echo '    <button form="admin_sel" type="submit" value="ds_man" name="func"><span>D-Star Manager</span></button>';
                    }
                    else {
                        echo '    <button form="admin_sel" disabled="disabled" type="submit" value="ds_man" name="func"><span>D-Star Manager</span></button>';
                    }       
                    $testMMDVModeDMR = getConfigItem("DMR", "Enable", $_SESSION['MMDVMHostConfigs']);
		    if ((substr($dmrMasterHost, 0, 2) == "BM") && ($bmEnabled == true) && ($testMMDVModeDMR ==1)) {
		        echo '    <button form="admin_sel" type="submit" value="bm_man" name="func"><span>BrandMeister Manager</span></button>';
		    }
		    else {
			echo '    <button form="admin_sel" disabled="disabled" type="submit" value="bm_man" name="func"><span>BrandMeister Manager</span></button>';
		    }
                    if ($tgif = true && $testMMDVModeDMR ==1) {
		        echo '    <button form="admin_sel" type="submit" value="tgif_man" name="func"><span>TGIF Manager</span></button>';
		    }
		    else {
			 echo '   <button form="admin_sel" disabled="disabled" type="submit" value="tgif_man" name="func"><span>TGIF Manager</span></button>';
		    }
		    //echo '      </div>';
		    //echo '      <div class="mode_flex">';		
                    $testMMDVModeYSF = getConfigItem("System Fusion", "Enable", $_SESSION['MMDVMHostConfigs']);
		    if ($testMMDVModeYSF == 1) {
		        echo '    <button form="admin_sel" type="submit" value="ysf_man" name="func"><span>YSF Manager</span></button>';
		    }
		    else {
		        echo '    <button form="admin_sel" disabled="disabled" type="submit" value="ysf_man" name="func"><span>YSF Manager</span></button>';
		    }
                    $testMMDVModeP25 = getConfigItem("P25", "Enable", $_SESSION['MMDVMHostConfigs']);
                    if ($testMMDVModeP25 == 1) {
		    	echo '    <button form="admin_sel" type="submit" value="p25_man" name="func"><span>P25 Manager</span></button>';
		    }
		    else {
		    	echo '    <button form="admin_sel" disabled="disabled" type="submit" value="p25_man" name="func"><span>P25 Manager</span></button>';
		    }
                    $testMMDVModeP25 = getConfigItem("NXDN", "Enable", $_SESSION['MMDVMHostConfigs']);
                    if ($testMMDVModeNXDN == 1) {
		    	echo '    <button form="admin_sel" type="submit" value="nxdn_man" name="func"><span>NXDN Manager</span></button>';
		    }
		    else {
		    	echo '    <button form="admin_sel" disabled="disabled" type="submit" value="nxdn_man" name="func"><span>NXDN Manager</span></button>';
		    }
                    $testMMDVModePOCSAG = getConfigItem("POCSAG", "Enable", $_SESSION['MMDVMHostConfigs']);
		    if ($testMMDVModePOCSAG == 1) {
		        echo '    <button form="admin_sel" type="submit" value="pocsag_man" name="func"><span>POCSAG Manager</span></button>';
		    }
		    else {
		        echo '    <button form="admin_sel" disabled="disabled" type="submit" value="pocsag_man" name="func"><span>POCSAG Manager</span></button>';
		    }
		    echo '      </div></td>';
		    echo '    </tr>';
		    echo '    <tr>';
		    echo '      <td style="white-space:normal;">Note: Modes/networks/services not globally enabled, or are paused by you, are not selectable here until they are enabled or resumed from pause.</td>';
		    echo '    </tr>';
		    echo '  </table>';
		    echo ' </form>';
		    echo '<hr />';
		}

		$testMMDVModeDSTARnet = getConfigItem("D-Star Network", "Enable", $_SESSION['MMDVMHostConfigs']);
		if ( $testMMDVModeDSTARnet == 1 ) {				// If D-Star network is enabled, add these extra features.
		    
		    if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "ds_man") {	// Admin Only Option (D-Star Mgr)
			echo '<script type="text/javascript">'."\n";
			echo 'function reloadrefLinks(){'."\n";
			echo '  $("#refLinks").load("/dstarrepeater/active_reflector_links.php",function(){ setTimeout(reloadrefLinks,2500) });'."\n";
			echo '}'."\n";
			echo 'setTimeout(reloadrefLinks,2500);'."\n";
			echo '$(window).trigger(\'resize\');'."\n";
			echo '</script>'."\n";
			echo '<div id="refLinks">'."\n";
			include 'dstarrepeater/active_reflector_links.php';	// dstarrepeater gateway config
			echo '</div>'."\n";
			include 'dstarrepeater/link_manager.php';		// D-Star Link Manager
		    }
		    
		    echo '<script type="text/javascript">'."\n";
		    echo 'function reloadccsConnections(){'."\n";
		    echo '  $("#ccsConnects").load("/dstarrepeater/ccs_connections.php",function(){ setTimeout(reloadccsConnections,15000) });'."\n";
		    echo '}'."\n";
		    echo 'setTimeout(reloadccsConnections,15000);'."\n";
		    echo '$(window).trigger(\'resize\');'."\n";
		    echo '</script>'."\n";
		    echo '<div id="ccsConnects">'."\n";
		    include 'dstarrepeater/ccs_connections.php';			// dstarrepeater gateway config
		    echo '</div>'."\n";
		}
	
		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "mode_man" || $_GET["func"] == "mode_man") {	// Admin Only Option (instant mode mgr)	
                    include "mmdvmhost/instant-mode-manager.php";
		}

		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "bm_man" || $_GET["func"] == "bm_man") { 		// Admin Only Option (BM links )
		    echo '<script type="text/javascript">'."\n";
        	    echo 'function reloadbmConnections(){'."\n";
        	    echo '  $("#bmConnects").load("/mmdvmhost/bm_links.php",function(){ setTimeout(reloadbmConnections,15000) });'."\n";
        	    echo '}'."\n";
        	    echo 'setTimeout(reloadbmConnections,15000);'."\n";
		    echo '$(window).trigger(\'resize\');'."\n";
        	    echo '</script>'."\n";
        	    echo '<div id="bmConnects">'."\n";
		    include 'mmdvmhost/bm_links.php';                       // BM Links
		    echo '</div>'."\n";
		}
		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "bm_man" || $_GET["func"] == "bm_man") {		// Admin Only Options (BM mgr)
                    include 'mmdvmhost/bm_manager.php';                     // BM DMR Link Manager
		}
		
		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "tgif_man" || $_GET["func"] == "tgif_man") {	// Admin Only Option (tgif links)
		    echo '<script type="text/javascript">'."\n";
        	    echo 'function reloadtgifConnections(){'."\n";
        	    echo '  $("#tgifConnects").load("/mmdvmhost/tgif_links.php",function(){ setTimeout(reloadtgifConnections,15000) });'."\n";
        	    echo '}'."\n";
        	    echo 'setTimeout(reloadtgifConnections,15000);'."\n";
		    echo '$(window).trigger(\'resize\');'."\n";
        	    echo '</script>'."\n";
        	    echo '<div id="tgifConnects">'."\n";
		    include 'mmdvmhost/tgif_links.php';			// TGIF Links
		    echo '</div>'."\n";
		}
		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "tgif_man" || $_GET["func"] == "tgif_man") {	// Admin Only Options (tgi mgr)
                    include 'mmdvmhost/tgif_manager.php';			// TGIF DMR Link Manager
		}
		
		// Check if YSF is Enabled
		if (isset($_SESSION['YSFGatewayConfigs']['YSF Network']['Enable']) == 1) {
		    if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "ysf_man" || $_GET["func"] == "ysf_man") { 	// Admin Only Options (ysf mgr)
			include 'mmdvmhost/ysf_manager.php';		// YSF Links
		    }
		}
		$testMMDVModeP25net = getConfigItem("P25 Network", "Enable", $_SESSION['MMDVMHostConfigs']);
		if ( $testMMDVModeP25net == 1 ) {				// If P25 network is enabled, add these extra features.
		    if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "p25_man" || $_GET["func"] == "p25_man") { 	// Admin Only Option *p25 mgr)
			include 'mmdvmhost/p25_manager.php';		// P25 Links
		    }
		}
		$testMMDVModeNXDNnet = getConfigItem("NXDN Network", "Enable", $_SESSION['MMDVMHostConfigs']);
		if ( $testMMDVModeNXDNnet == 1 ) {				// If NXDN network is enabled, add these extra features.
		    if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "nxdn_man" || $_GET["func"] == "nxdn_man") { 	// Admin Only Option (nxdn mgr)
			include 'mmdvmhost/nxdn_manager.php';		// NXDN Links
		    }
		}
		
		echo '<script type="text/javascript">'."\n";
		echo 'var lhto;'."\n";
		echo 'var ltxto'."\n";
			
		echo 'function reloadLocalTX(){'."\n";
		echo '  $("#localTxs").load("/mmdvmhost/localtx.php",function(){ ltxto = setTimeout(reloadLocalTX,1500) });'."\n";
		echo '}'."\n";
	
		echo 'function reloadLastHeard(){'."\n";
		echo '  $("#lastHeard").load("/mmdvmhost/lh.php",function(){ lhto = setTimeout(reloadLastHeard,1500) });'."\n";
		echo '}'."\n";
		
    		echo 'function setLHAutorefresh(obj) {'."\n";
    		echo '    if (obj.checked) {'."\n";
    		echo '        lhto = setTimeout(reloadLastHeard,1500);'."\n";
    		echo '    }'."\n";
    		echo '    else {'."\n";
    		echo '        clearTimeout(lhto);'."\n";
    		echo '    }'."\n";
    		echo '}'."\n";
		
		echo 'function setLocalTXAutorefresh(obj) {'."\n";
    		echo '    if (obj.checked) {'."\n";
    		echo '        ltxto = setTimeout(reloadLocalTX,1500);'."\n";
    		echo '    }'."\n";
    		echo '    else {'."\n";
    		echo '        clearTimeout(ltxto);'."\n";
    		echo '    }'."\n";
    		echo '}'."\n";
		
		echo 'lhto = setTimeout(reloadLastHeard,1500);'."\n";
		echo 'ltxto = setTimeout(reloadLocalTX,1500);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";

		if (empty($_POST) && empty($_GET)) {  // only show localtx and lastheard on main admin page (not sections)
		    echo '<div id="localTxs">'."\n";
		    include 'mmdvmhost/localtx.php';				// MMDVMDash Local Trasmissions
		    echo '</div>'."\n";
		    echo "<br />\n";

		    echo '<div id="lastHeard">'."\n";
		    include 'mmdvmhost/lh.php';					// MMDVMDash Last Heard
		    echo '</div>'."\n";
		}

		// If POCSAG is enabled, show the information panel
		$testMMDVModePOCSAG = getConfigItem("POCSAG Network", "Enable", $_SESSION['MMDVMHostConfigs']);
		if ( $testMMDVModePOCSAG == 1 ) {
		    if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "pocsag_man" || $_GET["func"] == "pocsag_man") {  // Admin Only Options (pocsag mgr)
			echo "<br />\n";
			echo '<div id="dapnetMsgr">'."\n";
			include 'mmdvmhost/dapnet_messenger.php';
			echo '</div>'."\n";
		    }

                    if ( $testMMDVModePOCSAG == 1 ) {
                        if (empty($_POST) && empty($_GET) || ($_POST["func"] == "pocsag_man" || $_GET["func"] == "pocsag_man")) { // display pages in pocsag mgr or main admin only with no other func requested
		            $myOrigin = ($_SERVER["PHP_SELF"] == "/admin/index.php" ? "admin" : "other");
		    
		            echo '<script type="text/javascript">'."\n";
		            echo 'var pagesto;'."\n";
		            echo 'function setPagesAutorefresh(obj) {'."\n";
	                    echo '    if (obj.checked) {'."\n";
	                    echo '        pagesto = setTimeout(reloadPages, 5000, "?origin='.$myOrigin.'");'."\n";
	                    echo '    }'."\n";
	                    echo '    else {'."\n";
	                    echo '        clearTimeout(pagesto);'."\n";
	                    echo '    }'."\n";
                            echo '}'."\n";
		            echo 'function reloadPages(OptStr){'."\n";
		            echo '    $("#Pages").load("/mmdvmhost/pages.php"+OptStr, function(){ pagesto = setTimeout(reloadPages, 5000, "?origin='.$myOrigin.'") });'."\n";
		            echo '}'."\n";
		            echo 'pagesto = setTimeout(reloadPages, 5000, "?origin='.$myOrigin.'");'."\n";
		            echo '$(window).trigger(\'resize\');'."\n";
		            echo '</script>'."\n";
		            echo "<br />\n";
		            echo '<div id="Pages">'."\n";
		            include 'mmdvmhost/pages.php';				// POCSAG Messages
		            echo '</div>'."\n";
		        }
		    }
	        }
	    }
	    else if (file_exists('/etc/dstar-radio.dstarrepeater')) {
		echo '<div class="contentwide">'."\n";
		include 'dstarrepeater/gateway_software_config.php';		// dstarrepeater gateway config
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadrefLinks(){'."\n";
		echo '  $("#refLinks").load("/dstarrepeater/active_reflector_links.php",function(){ setTimeout(reloadrefLinks,2500) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadrefLinks,2500);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		echo '<br />'."\n";
		echo '<div id="refLinks">'."\n";
		include 'dstarrepeater/active_reflector_links.php';		// dstarrepeater gateway config
		echo '</div>'."\n";
		echo '<br />'."\n";
		if ($_SERVER["PHP_SELF"] == "/admin/index.php" && $_POST["func"] == "ds_link_man") {	// Admin Only Options  (D-star link mgr)
		    include 'dstarrepeater/link_manager.php';		// D-Star Link Manager
		    echo "<br />\n";
		}
		
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadccsConnections(){'."\n";
		echo '  $("#ccsConnects").load("/dstarrepeater/ccs_connections.php",function(){ setTimeout(reloadccsConnections,15000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadccsConnections,15000);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		echo '<div id="ccsConnects">'."\n";
		include 'dstarrepeater/ccs_connections.php';			// dstarrepeater gateway config
		echo '</div>'."\n";
		
		echo '<script type="text/javascript">'."\n";
		echo 'function reloadLocalTx(){'."\n";
		echo '  $("#localTx").load("/dstarrepeater/local_tx.php",function(){ setTimeout(reloadLocalTx,3000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadLocalTx,3000);'."\n";
		echo 'function reloadLastHeard(){'."\n";
		echo '  $("#lhdstar").load("/dstarrepeater/last_heard.php",function(){ setTimeout(reloadLastHeard,3000) });'."\n";
		echo '}'."\n";
		echo 'setTimeout(reloadLastHeard,3000);'."\n";
		echo '$(window).trigger(\'resize\');'."\n";
		echo '</script>'."\n";
		echo '<div id="lhdstar">'."\n";
		include 'dstarrepeater/last_heard.php';				//dstarrepeater Last Herd
		echo '</div>'."\n";
		echo "<br />\n";
		echo '<div id="localTx">'."\n";
		include 'dstarrepeater/local_tx.php';				//dstarrepeater Local Transmissions
		echo '</div>'."\n";
		echo '<br />'."\n";
		
	    }
	    else {
		echo '<div class="contentwide">'."\n";
		//We dont know what mode we are in - fail...
		echo "<H1>No Mode Defined...</H1>\n";
		echo "<p>I don't know what mode I am in, you probaly just need to configure me.</p>\n";
		echo "<p>You will be re-directed to the configuration portal in 10 secs</p>\n";
		echo "<p>In the mean time, you might want to register on the support<br />\n";
		echo "page here: <a href=\"https://www.facebook.com/groups/pistarusergroup/\" target=\"_new\">https://www.facebook.com/groups/pistarusergroup/</a><br />\n";
		echo "or the Support forum here: <a href=\"https://forum.pistar.uk/\" target=\"_new\">https://forum.pistar.uk/</a></p>\n";
		echo '<script type="text/javascript">setTimeout(function() { window.location="/admin/configure.php";},10000);</script>'."\n";
	    }
	    ?>
	</div>
	
	<div class="footer">
	   <?php 
		echo 'Pi-Star / Pi-Star Dashboard, &copy; Andy Taylor (MW0MWZ) 2014-'.date("Y").'<br />'."\n";
		echo '<a href="https://repo.w0chp.net/Chipster/W0CHP-PiStar-Dash" style="color: #ffffff; text-decoration:underline;">W0CHP-PiStar_Dash</a> enhancements by W0CHP';
	   ?>
	</div>
	
	</div>
    </body>
</html>
