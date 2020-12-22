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

// check status of supported modes
$DSTAR  = ($configmmdvm['D-Star']['Enable']);
$DMR    = ($configmmdvm['DMR']['Enable']);
$YSF    = ($configmmdvm['System Fusion']['Enable']);
$P25    = ($configmmdvm['P25']['Enable']);
$NXDN   = ($configmmdvm['NXDN']['Enable']);
// pause enabled file pointers
$DSTAR_paused  = '/var/run/D-Star.paused';
$DMR_paused    = '/var/run/DMR.paused';
$YSF_paused    = '/var/run/YSF.paused';
$P25_paused    = '/var/run/P25.paused';
$NXDN_paused   = '/var/run/NXDN.paused';

// take action based on form submission
if (!empty($_POST) && empty($_POST["mode_sel"])) { //handler for nothing selected
    $mode = ($_POST['mode_sel']); // get selected mode from for post
    // Output to the browser
    echo "<b>Instant Mode Manager</b>";
    echo "<table>\n";
    echo "  <tr>\n";
    echo "    <td>No Mode Selected; Nothing To Do!<br />Page Reloading...</td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    // Clean up...
    unset($_POST);
    echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
/*
} elseif (!empty($_POST) && ($_POST['mode_action'] == "Pause")) { // handler for already paused
    $mode = ($_POST['mode_sel']); // get selected mode from for post
    if (file_exists("/var/run/$mode.paused")) {
        // Output to the browser
        echo "<b>Instant Mode Manager</b>";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <td>$mode already paused! Did you mean to resume $mode?<br />Page Reloading...</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    }
*/
} elseif
    (!empty($_POST) && ($_POST['mode_action'] == "Pause") && isset($_POST["submit_mode"])) {
    $mode = ($_POST['mode_sel']); // get selected mode from for post
    if (file_exists("/var/run/$mode.paused")) { //check if already paused
        // Output to the browser
        echo "<b>Instant Mode Manager</b>";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <td>$mode mode already paused! Did you mean to \"resume\" $mode mode?<br />Page Reloading...</td>\n";
        echo "  </tr>\n"; 
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    } else { // looks good!
        exec('sudo mount -o remount,rw /');
        exec("sudo $mode_cmd $mode Disable"); // pause the seleced $mode
        exec("sudo touch /var/run/$mode.paused"); // create file pointer for paused $mode
        exec('sudo mount -o remount,ro /');
        // Output to the browser
        echo "<b>Instant Mode Manager</b>";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <td>Selected Mode ($mode) Paused!<br />Page Reloading...</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    }
} elseif
    (!empty($_POST) && ($_POST['mode_action'] == "Resume") && isset($_POST["submit_mode"])) {
    $mode = ($_POST['mode_sel']); // get selected mode from for post
    if (!file_exists("/var/run/$mode.paused")) { //check if already running
        // Output to the browser
        echo "<b>Instant Mode Manager</b>";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <td>$mode mode already running! Did you mean to \"pause\" $mode mode?<br />Page Reloading...</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    } else { // looks good!
        exec('sudo mount -o remount,rw /');
        exec("sudo $mode_cmd $mode Enable"); // resume the seleced $mode
        exec("sudo rm /var/run/$mode.paused"); // delete file pointer for paused $mode
        exec('sudo mount -o remount,ro /');
        // Output to the browser
        echo "<b>Instant Mode Manager</b>";
        echo "<table>\n";
        echo "  <tr>\n";
        echo "    <td>Selected Mode ($mode) Resumed!<br />Page Reloading...</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        // Clean up...
        unset($_POST);
        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
    }
} else {
    // no form post: output html...
    print '
    <b>Instant Mode Manager</b>
    <form id="action-form" method="post">
      <table>
          <tr>
	    <th>Pause / Resume</th>
	    <th>Select Mode</th>
	    <th>Action</th>
	  </tr>
          <tr>
            <td colspan="3">This function allows you to instantly pause/resume radio modes during nets, for quieting, etc.</th>
          </tr>
	  <tr>
            <td>
                      <input name="mode_action" access="false" id="pause-res-0" value="Pause" type="radio" checked="checked">
                      <label for="pause-res-0">Pause</label>
                      <input name="mode_action" access="false" id="pause-res-1"  value="Resume" type="radio">
                      <label for="pause-res-1">Resume</label>
              </td>
            <td>
                </label>
                    [ <input name="mode_sel" '.(($DMR=='0' && !file_exists($DMR_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-0"  value="DMR" type="radio">
                    <label for="mode_sel-0">DMR</label> '.(($DMR=='0' && file_exists($DMR_paused)?" <span style=background:#f93;'>(Paused)</span>":"")).'
                     | <input name="mode_sel" '.(($YSF=='0' && !file_exists($YSF_paused)?'disabled="disabled"':"")).'  access="false" id="mode-sel-1"  value="YSF" type="radio">
                    <label for="mode_sel-1">YSF</label>'.(($YSF=='0' && file_exists($YSF_paused)?" <span style=background:#f93;'>(Paused)</span>":"")).'
                     | <input name="mode_sel" '.(($DSTAR=='0' && !file_exists($DSTAR_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-2"  value="D-Star" type="radio">
                    <label for="mode_sel-2">D-Star</label> '.(($DSTAR=='0' && file_exists($DSTAR_paused)?" <span style=background:#f93;'>(Paused)</span>":"")).'
                     | <input name="mode_sel" '.(($P25=='0' && !file_exists($P25_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-3"  value="P25" type="radio">
                    <label for="mode_sel-3">P25</label> '.(($P25=='0' && file_exists($P25_paused)?" <span style=background:#f93;'>(Paused)</span>":"")).'
                     | <input name="mode_sel" '.(($NXDN=='0' && !file_exists($NXDN_paused)?'disabled="disabled"':"")).' access="false" id="mode-sel-4"  value="NXDN" type="radio">
                    <label for="mode_sel-4">NXDN</label> '.(($NXDN=='0' && file_exists($NXDN_paused)?" <span style=background:#f93;'>(Paused)</span>":"")).' ]
            </td>
          <td>
              <input type="submit" class="btn-default btn" name="submit_mode" value="Submit" access="false" style="default" id="submit-mode" title="Submit">
          </td>
        </tr>
        <tr>
	  <td colspan="3"><b>Note:</b> Modes you not have configured/enabled globally, are not selectable in the Instant Mode Manager.</td>
        </tr>
      </table>
</form>
';
}

?>
