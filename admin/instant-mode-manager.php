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

$mode_cmd = '/usr/local/sbin/pistar-mmdvmhost-module';

$mmdvmConfigFile = '/etc/mmdvmhost';
$configmmdvm = parse_ini_file($mmdvmConfigFile, true);
$aprsConfigFile = '/etc/aprsgateway';
$configaprsgw = parse_ini_file($aprsConfigFile, true);

// check status of supported modes
$DSTAR  = ($configmmdvm['D-Star']['Enable']);
$DMR    = ($configmmdvm['DMR']['Enable']);
$YSF    = ($configmmdvm['System Fusion']['Enable']);
$P25    = ($configmmdvm['P25']['Enable']);
$NXDN   = ($configmmdvm['NXDN']['Enable']);
$M17    = ($configmmdvm['M17']['Enable']);
$AX25   = ($configmmdvm['AX 25']['Enable']);
$POCSAG = ($configmmdvm['POCSAG']['Enable']);
$APRS   = ($configaprsgw['Enabled']['Enabled']);
// pause enabled file pointers
$DSTAR_paused  = '/etc/D-Star_paused';
$DMR_paused    = '/etc/DMR_paused';
$YSF_paused    = '/etc/YSF_paused';
$P25_paused    = '/etc/P25_paused';
$NXDN_paused   = '/etc/NXDN_paused';
$M17_paused    = '/etc/M17_paused';
$AX25_paused   = '/etc/AX25_paused';
$POCSAG_paused = '/etc/POCSAG_paused';
$APRS_paused   = '/etc/APRS_paused';

// take action based on form submission
if (!empty($_POST["submit_mode"]) && empty($_POST["mode_sel"])) { //handler for nothing selected
    $mode = escapeshellcmd($_POST['mode_sel']); // get selected mode from for post
    // Output to the browser
    echo "<b>Instant Mode Manager</b>\n";
    echo "<table>\n";
    echo "  <tr>\n";
    echo "    <th>ERROR</th>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td><p>No Mode Selected; Nothing To Do!<br />Page Reloading...</p></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    // Clean up...
    unset($_POST);
    echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
} elseif
    (!empty($_POST['submit_mode']) && escapeshellcmd($_POST['mode_action'] == "Pause")) {
    $mode = escapeshellcmd($_POST['mode_sel']); // get selected mode from for post
    if (file_exists("/etc/$mode"."_paused")) { //check if already paused
        // Output to the browser
        echo "<b>Instant Mode Manager</b>\n";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <th>ERROR</th>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td><p>$mode mode already paused! Did you mean to \"resume\" $mode mode?<br />Page Reloading...</p></td>\n";
        echo "  </tr>\n"; 
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    } else { // looks good!
        exec("sudo $mode_cmd $mode Disable"); // pause the seleced $mode
        // Output to the browser
        echo "<b>Instant Mode Manager</b>\n";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <th>Status</th>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td><p>Selected Mode ($mode) Paused!<br />Page Reloading...</p></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    }
} elseif
    (!empty($_POST['submit_mode']) && escapeshellcmd($_POST['mode_action'] == "Resume")) {
    $mode = escapeshellcmd($_POST['mode_sel']); // get selected mode from for post
    if (!file_exists("/etc/$mode"."_paused")) { //check if already running
        // Output to the browser
        echo "<b>Instant Mode Manager</b>\n";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <th>ERROR</th>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td><p>$mode mode already running! Did you mean to \"pause\" $mode mode?<br />Page Reloading...</p></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    } else { // looks good!
        exec("sudo $mode_cmd $mode Enable"); // resume the seleced $mode
        // Output to the browser
        echo "<b>Instant Mode Manager</b>\n";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <th>Status</th>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "    <td><p>Selected Mode ($mode) Resumed!<br />Page Reloading...</p></td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    }
} else {
    // no form post: output html...
    print '
    <div style="text-align:left;font-weight:bold;">Instant Mode Manager</div>'."\n".'
    <form id="action-form" action="'.htmlentities($_SERVER['PHP_SELF']).'?func=mode_man" method="post">
      <table style="white-space: normal;">
        <tr>
	  <th>Pause / Resume</th>
	  <th>Select Mode</th>
	  <th>Action</th>
	</tr>
        <tr>
          <td colspan="3" style="white-space:normal;padding: 3px;">This function allows you to instantly pause or resume selected radio modes. Handy for attending nets, quieting a busy mode, to temporarily eliminate "mode monopolization", etc.</td>
        </tr>
	<tr>
          <td style="white-space:nowrap;">
            <input name="mode_action" access="false" id="pause-res-0" value="Pause" type="radio" checked="checked">
            <label for="pause-res-0">Pause</label>
            <input name="mode_action" access="false" id="pause-res-1"  value="Resume" type="radio">
            <label for="pause-res-1">Resume</label>
          </td>
          <td style="white-space:nowrap;"><br />
            <input name="mode_sel" '.(($DMR=='0' && !file_exists($DMR_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-0"  value="DMR" type="radio">
            <label for="mode-sel-0">DMR'.(($DMR=='0' && file_exists($DMR_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
            &nbsp;| <input name="mode_sel" '.(($YSF=='0' && !file_exists($YSF_paused)?'disabled="disabled"':"")).'  access="false" id="mode-sel-1"  value="YSF" type="radio">
            <label for="mode-sel-1">YSF'.(($YSF=='0' && file_exists($YSF_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
            &nbsp;| <input name="mode_sel" '.(($DSTAR=='0' && !file_exists($DSTAR_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-2"  value="D-Star" type="radio">
            <label for="mode-sel-2">D-Star'.(($DSTAR=='0' && file_exists($DSTAR_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
            &nbsp;| <input name="mode_sel" '.(($P25=='0' && !file_exists($P25_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-3"  value="P25" type="radio">
            <label for="mode-sel-3">P25'.(($P25=='0' && file_exists($P25_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
			<br /><br />
            <input name="mode_sel" '.(($NXDN=='0' && !file_exists($NXDN_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-4"  value="NXDN" type="radio">
            <label for="mode-sel-4">NXDN'.(($NXDN=='0' && file_exists($NXDN_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
            &nbsp;| <input name="mode_sel" '.(($M17=='0' && !file_exists($M17_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-5"  value="M17" type="radio">
            <label for="mode-sel-5">M17'.(($M17=='0' && file_exists($M17_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
<!--
            &nbsp;| <input name="mode_sel" '.(($AX25=='0' && !file_exists($AX25_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-6"  value="AX25" type="radio">
            <label for="mode-sel-6">AX.25'.(($AX25=='0' && file_exists($AX25_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
-->
            &nbsp;| <input name="mode_sel" '.(($POCSAG=='0' && !file_exists($POCSAG_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-7"  value="POCSAG" type="radio">
            <label for="mode-sel-7">POCSAG'.(($POCSAG=='0' && file_exists($POCSAG_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label>
            &nbsp;| <input name="mode_sel" '.(($APRS=='0' && !file_exists($APRS_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-8"  value="APRS" type="radio">
            <label for="mode-sel-8">APRS'.(($APRS=='0' && file_exists($APRS_paused)?" <span class='paused-mode-span'>(Paused)</span>":"")).'</label><br /><br />
          </td>
          <td>
            <input type="hidden" name="func" value="mode_man">
            <input type="submit" class="btn-default btn" name="submit_mode" value="Submit" access="false" style="default" id="submit-mode" title="Submit">
          </td>
        </tr>
        <tr>
	  <td colspan="3" style="white-space:normal;padding: 3px;"><b>Note:</b> Modes you not have <a href="/admin/configure.php">configured/enabled globally</a>, are not selectable in the Instant Mode Manager.</td>
        </tr>
      </table>
    </form>
';
}

?>
