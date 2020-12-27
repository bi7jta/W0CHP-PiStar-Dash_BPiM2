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
	// OK this is Brandmeister, get some config and output the HTML
	
	// If there is a BM API Key
	if ( !empty($_POST) && ( isset($_POST["tgStaticDropAll"]) || isset($_POST["tgStaticReAdd"]) || isset($_POST["tgStaticBatch"]))) {  // Data has been posted for this page
            // Static TG handling...
            $sanitizedKey = str_replace('$', '\$', $_SESSION['BMAPIKey']);
	    // Drop all static:
	    $bmStaticDropAllCmd = ("sudo /usr/local/sbin/pistar-bm_static_tgs_dropall $sanitizedKey $dmrID");
	    if (isset($_POST["tgStaticDropAll"])) {
	        exec($bmStaticDropAllCmd);
                // Output to the browser
                echo '<b>BrandMeister Manager</b>'."\n";
                echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                print "All Static Talkgroups Dropped!<br /> Page reloading...";
                echo "</td></tr>\n</table>\n";
                echo "<br />\n";
                // Clean up...
                unset($_POST);
                echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	    }
	    // re-add all static
            $bmStaticAddAllCmd = ("sudo /usr/local/sbin/pistar-bm_static_tgs_addall $sanitizedKey $dmrID");
            if (isset($_POST["tgStaticReAdd"])) {
	        // make certain that a previous saves/dropped file actually exits
	        if (file_exists("/var/www/dashboard/.bm_tgs.json.saved")) {
            	    exec($bmStaticAddAllCmd);
            	    // Output to the browser
            	    echo '<b>BrandMeister Manager</b>'."\n";
            	    echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
            	    print "All Previous Static Talkgroups Re-Added!<br /> Page reloading...";
            	    echo "</td></tr>\n</table>\n";
            	    echo "<br />\n";
            	    // Clean up...
            	    unset($_POST);
            	    echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	        }
	        else {
            	    // Output to the browser
            	    echo '<b>BrandMeister Manager</b>'."\n";
            	    echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
            	    print "No Previous Static Talkgroups Dropped. Nothing To Do!!<br /> Page reloading...";
            	    echo "</td></tr>\n</table>\n";
            	    echo "<br />\n";
            	    // Clean up...
            	    unset($_POST);
            	    echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	        }
            }
	    // batch-add/delete static
	    if (!isset($_POST["massTGslotSelected"])) {
                $massTGslot = "0";
            }
            else {
                $massTGslot = $_POST["massTGslotSelected"];
            }
            $sanitizedKey = str_replace('$', '\$', $_SESSION['BMAPIKey']);
            $bmStaticMassAddCmd = ("sudo /usr/local/sbin/pistar-bm_static_tgs_batchadd $sanitizedKey $dmrID $massTGslot");
            $bmStaticMassDelCmd = ("sudo /usr/local/sbin/pistar-bm_static_tgs_batchdel $sanitizedKey $dmrID $massTGslot");
	    if (isset($_POST["tgStaticBatch"])) {
                $massTGs = ($_POST['massTGlist']);
                if (strlen($massTGs)==0) {
                    // Output to the browser
                    echo '<b>BrandMeister Manager</b>'."\n";
                    echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                    print "No talkgroups defined! <br /> Page reloading...";
                    echo "</td></tr>\n</table>\n";
                    echo "<br />\n";
                    // Clean up...
                    unset($_POST);
                    echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
                }
                else  {
		    if ($_POST["massTGaction"] == "ADD") {
		        // keep newlines, but remove non-numeric chars
	                $massTGs = preg_replace("/[^0-9\r\n]/", "", $massTGs);
		        // sep. the data posted
                        $massTGs = explode("\n", str_replace("\r", "", $massTGs));
		        // put data posted into clean array with newline as delimeter
		        $massTGs = implode("\n", $massTGs);
		        // limit the number of talkgroups per form entry (5, for now).
                        $massTGcount = substr_count($massTGs, "\n") + 1;
		        if ($massTGcount > "5") {
                            // Output to the browser
                            echo '<b>BrandMeister Manager</b>'."\n";
                            echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                            print "No more than 5 talkgroups can be defined at a time! <br /> Page reloading...";
                            echo "</td></tr>\n</table>\n";
                            echo "<br />\n";
                            // Clean up...
                            unset($_POST);
                            echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
                       } else // 5 or less tgs submitted. keep going...
		           {
                            exec('sudo mount -o remount,rw /');
                            $handleBatch = fopen("/var/www/dashboard/.bm_tgs.batch", 'w+');
                            fwrite($handleBatch, $massTGs);
                            fclose($handleBatch);
			    // need to add a last newline to the file so that the shell script can parse the last (or first and only) TG
		            file_put_contents('/var/www/dashboard/.bm_tgs.batch', "\n".PHP_EOL , FILE_APPEND | LOCK_EX);
                            exec($bmStaticMassAddCmd);
                            exec('sudo mount -o remount,ro /');
                            // Output to the browser
                            echo '<b>BrandMeister Manager</b>'."\n";
                            echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                            print "All Submitted Static Talkgroups Added to slot ".$_POST['massTGslotSelected']."!<br /> Page reloading...<br />";
                            echo "</td></tr>\n</table>\n";
                            echo "<br />\n";
                            // Clean up...
                            unset($_POST);
                            echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
		        }
		    } elseif
		        ($_POST["massTGaction"] == "DEL") {
	                $massTGs = preg_replace("/[^0-9\r\n]/", "", $massTGs);
                        $massTGs = explode("\n", str_replace("\r", "", $massTGs));
		        $massTGs = implode("\n", $massTGs);
                        $massTGcount = substr_count($massTGs, "\n") + 1;
		        if ($massTGcount > "5") {
                            // Output to the browser
                            echo '<b>BrandMeister Manager</b>'."\n";
                            echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                            print "No more than 5 talkgroups can be defined at a time! <br /> Page reloading...";
                            echo "</td></tr>\n</table>\n";
                            echo "<br />\n";
                            // Clean up...
                            unset($_POST);
                            echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
                       } else
		           {
                            exec('sudo mount -o remount,rw /');
                            $handleBatch = fopen("/var/www/dashboard/.bm_tgs.batch", 'w+');
                            fwrite($handleBatch, $massTGs);
                            fclose($handleBatch);
		            file_put_contents('/var/www/dashboard/.bm_tgs.batch', "\n".PHP_EOL , FILE_APPEND | LOCK_EX);
                            exec($bmStaticMassDelCmd);
                            exec('sudo mount -o remount,ro /');
                            // Output to the browser
                            echo '<b>BrandMeister Manager</b>'."\n";
                            echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
                            print "All Submitted Static Talkgroups Deleted from slot ".$_POST['massTGslotSelected']."!<br /> Page reloading...<br />";
                            echo "</td></tr>\n</table>\n";
                            echo "<br />\n";
                            // Clean up...
                            unset($_POST);
                            echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
		       }
                   }
                }
            }
 	} else { 
	    // begin single TG management / native api funcs
	    $bmAPIurl = 'https://api.brandmeister.network/v1.0/repeater/';
	    if ( !empty($_POST) && ( isset($_POST["dropDyn"]) || isset($_POST["dropQso"]) || isset($_POST["tgSubmit"]))) {  // Data has been posted for this page
	        // Are we a repeater
	        if ( getConfigItem("DMR Network", "Slot1", $_SESSION['MMDVMHostConfigs']) == "0" ) {
		    unset($_POST["TS"]);
		    $targetSlot = "0";
	        }
	        else {
		    $targetSlot = $_POST["TS"];
	        }
	        // Figure out what has been posted
	        if (isset($_POST["dropDyn"])) { $bmAPIurl = $bmAPIurl."setRepeaterTarantool.php?action=dropDynamicGroups&slot=".$targetSlot."&q=".$dmrID; }
	        if (isset($_POST["dropQso"])) { $bmAPIurl = $bmAPIurl."setRepeaterDbus.php?action=dropCallRoute&slot=".$targetSlot."&q=".$dmrID; }
	        if ( ($_POST["TGmgr"] == "ADD") && (isset($_POST["tgSubmit"])) ) { $bmAPIurl = $bmAPIurl."talkgroup/?action=ADD&id=".$dmrID; }
	        if ( ($_POST["TGmgr"] == "DEL") && (isset($_POST["tgSubmit"])) ) { $bmAPIurl = $bmAPIurl."talkgroup/?action=DEL&id=".$dmrID; }
	        if ( (isset($_POST["tgNr"])) && (isset($_POST["tgSubmit"])) ) { $targetTG = preg_replace("/[^0-9]/", "", $_POST["tgNr"]); }
	        // Build the Data
	        if ( (!isset($_POST["dropDyn"])) && (!isset($_POST["dropQso"])) ) {
		    if (isset($_POST["tgSubmit"])) {
		        $postDataTG = array(
			    'talkgroup' => $targetTG,
			    'timeslot' => $targetSlot,
		        );
		    }	
	        }
	        // Build the Query
	        $postData = '';
	        if (isset($_POST["tgSubmit"])) { $postData = http_build_query($postDataTG); }
	        $postHeaders = array(
		    'Content-Type: application/x-www-form-urlencoded',
		    'Content-Length: '.strlen($postData),
		    'Authorization: Basic '.base64_encode($_SESSION['BMAPIKey'].':'),
		    'User-Agent: Pi-Star '.$_SESSION['PiStarRelease']['Pi-Star']['Version'].'-W0CHP Dashboard for '.$dmrID,
	        );
	    
	        $opts = array(
		    'http' => array(
		        'header'  => $postHeaders,
		        'method'  => 'POST',
		        'content' => $postData,
		        'password' => '',
		        'success' => '',
		        'timeout' => 2,
		    ),
	        );
	        $context = stream_context_create($opts);
	        $result = @file_get_contents($bmAPIurl, false, $context);
	        $feeback=json_decode($result);
	        // Output to the browser
	        echo '<b>BrandMeister Manager</b>'."\n";
	        echo "<table>\n<tr><th>Command Output</th></tr>\n<tr><td>";
	        //echo "Sending command to BrandMeister API";
	        print "BrandMeister API: ".$feeback->{'message'};
	        echo "<br />Page reloading...</td></tr>\n</table>\n";
	        echo "<br />\n";
	        // Clean up...
	        unset($_POST);
	        echo '<script type="text/javascript">setTimeout(function() { window.location=window.location;},3000);</script>';
	    }
	    else { // Do this when we are not handling post data
	        if (isset($_SESSION['BMAPIKey'])) {
		    echo '<b>BrandMeister Manager</b>'."\n";
		    echo '<form id="bm_man" action="'.htmlentities($_SERVER['PHP_SELF']."?func=bm_man").'" method="post">'."\n";
		    echo '<table style="white-space: normal;">'."\n";
		    echo '  <tr>'."\n";
		    echo '    <th colspan="3">Single Static Talkgroup Tools</th>'."\n";
		    echo '    <th rowspan="2">Other Talkgroup Tools</th>'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>'."\n";
		    echo '    <th><a class=tooltip href="#">Enter Static Talkgroup:<span><b>Enter the Talkgroup number</b></span></a></th>',"\n";
 		    echo '    <th><a class=tooltip href="#">Slot<span><b>Where to link/unlink</b></span></a></th>'."\n";
		    echo '    <th><a class=tooltip href="#">Add / Remove<span><b>Add or Remove</b></span></a></th>'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>';
		    echo '    <td><input type="text" id="tgNr" name="tgNr" size="10" maxlength="7" oninput="enableOnNonEmpty(\'tgNr\', \'tgSubmit\', \'tgAdd\', \'tgDel\'); return false;"/></td>'."\n";
		    echo '    <td><input type="radio" id="ts1" name="TS" value="1" '.((getConfigItem("General", "Duplex", $_SESSION['MMDVMHostConfigs']) == "1") ? '' : '').'/><label for="ts1"/>TS1</label> <input type="radio" id="ts2" name="TS" value="2" checked="checked"/><label for="ts2"/>TS2</td>'."\n";
		    echo '    <td style="white-space:nowrap;"><input type="radio" id="tgAdd" name="TGmgr" value="ADD" checked="checked" /><label for="tgAdd">Add</label> <input type="radio" id="tgDel" name="TGmgr" value="DEL" checked="checked" /><label for="tgDel">Delete</label>&nbsp;<input type="submit" value="Add/Delete Static" id="tgSubmit" name="tgSubmit"/></td>'."\n";
		    echo '    <td><input type="submit" value="Drop QSO" title="Drop current QSO" name="dropQso" /><br />'."\n";
		    echo '      <input type="submit" value="Drop All Dynamic" title="Drop all dynamic groups" name="dropDyn" /></td>'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>'."\n";
		    echo '    <th><a class=tooltip href="#">Mass Drop / Mass Re-Add Static Talkgroups<span><b>Mass Drop / Mass Re-Add Static Talkgroups</b></span></a></th>'."\n";
		    echo '    <th colspan="3"><a class=tooltip href="#">Batch-Add/Batch-Delete Static Talkgroups<span><b>Batch-Add/Batch-Delete Static Talkgroups</b></span></a></th>'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>'."\n";
		    echo '    <td>This function drops all current static talkgroups, OR re-adds the previously-dropped static talkgroups.</td>'."\n";
		    echo '    <td colspan="3">This function mass/batch-adds or deletes up to 5 static talkgroups. Enter one talkgroup per line.'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>'."\n";
		    echo '    <td><input type="submit" value="Drop All Static TGs" id="tgStaticDropAll" name="tgStaticDropAll"/><br />'."\n";
		    echo '      <input type="submit" value="Re-Add All Previous  Static TGs" id="tgStaticReAdd" name="tgStaticReAdd"/></td>'."\n";
		    echo '    <td><b>Enter Talkgroups:</b><br /><textarea style="vertical-align: middle; resize: none;" rows="5" cols="20" name="massTGlist" placeholder="One per line."></textarea></td>'."\n";
		    echo '    <td><b>Slot:</b><br /><br /><input type="radio" id="massts1" name="massTGslotSelected" value="1" '.((getConfigItem("General", "Duplex", $_SESSION['MMDVMHostConfigs']) == "1") ? '' : '').'/><label for="ts1"/>TS1</label> <input type="radio" id="massts2" name="massTGslotSelected" value="2" checked="checked"/><label for="ts2"/>TS2</td>'."\n";
		    echo '    <td><input type="radio" id="masstgAdd" name="massTGaction" value="ADD" /><label for="tgAdd">Add</label> <input type="radio" id="masstgDel" name="massTGaction" value="DEL" checked="checked" /><label for="tgDel">Delete</label>&nbsp;<input type="submit" value="Batch Add/Delete Static TGs" id="tgStaticBatch" name="tgStaticBatch"/></td>'."\n";
		    echo '  </tr>'."\n";
		    echo '  <tr>'."\n";
		    echo '    <td colspan="4">(Note: Give all mass/batch static talkgroup management functions some time to process, due to the nature of BrandMeister not natively supporting mass-management functions for static takgroups.)'."\n";
		    echo '  </tr>'."\n";
		    echo '</table>'."\n";
		    echo '</form>'."\n";
	        }
	    }
        }
    }
}
?>
