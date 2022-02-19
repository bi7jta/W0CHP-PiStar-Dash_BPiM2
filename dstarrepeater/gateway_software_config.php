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

?>
<b><?php echo $lang['dstar_config'];?></b>
<table>
    <tr>
	<th>ircDDB Network</th>
	<th>APRS Host</th>
	<th>CCS</th>
	<th>DCS</th>
	<th>DExtra</th>
	<th>DPlus</th>
	<th>D-Rats</th>
	<th>Info</th>
	<th>ircDDB</th>
	<th>Echo</th>
	<th>Log</th>
    </tr>
    <tr>
	<td><?php print $_SESSION['ircDDBConfigs']['ircddbHostname']; ?></td>
	<td><?php if($_SESSION['ircDDBConfigs']['aprsEnabled'] == 1) { print $_SESSION['APRSGatewayConfigs']['APRS-IS']['Server']; } else { print "OFF"; } ?></td>
	<?php
	if($_SESSION['ircDDBConfigs']['ccsEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['dcsEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['dextraEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['dplusEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['dratsEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['infoEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['ircddbEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['echoEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
	if($_SESSION['ircDDBConfigs']['logEnabled'] == 1) {
	    print "<td><span style='color:#005028;font-weight:bold'>ON</span></td>";
	}
	else {
	    print "<td><span style='color:#8A0B2B;font-weight:bold;'>OFF</span></td>";
	}
  ?>
</tr>
</table>
