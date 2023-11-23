<?php
if (isset($_COOKIE['PHPSESSID']))
{
    session_id($_COOKIE['PHPSESSID']); 
}
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION) || !is_array($_SESSION) || (count($_SESSION, COUNT_RECURSIVE) < 10)) {
    session_id('pistardashsess');
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$cmdoutput = array();
switch ($action) {
    case "stop":
	$cmdresult = exec('sudo /usr/local/sbin/pistar-services stop', $cmdoutput, $retvalue);
	break;
    case "fullstop":
	$cmdresult = exec('sudo /usr/local/sbin/pistar-services fullstop', $cmdoutput, $retvalue);
	break;
    case "restart":
	$cmdresult = exec('sudo /usr/local/sbin/pistar-services restart', $cmdoutput, $retvalue);
	break;
    case "status":
	$cmdresult = exec('sudo /usr/local/sbin/pistar-services status', $cmdoutput, $retvalue);
	break;
    case "killmmdvmhost":
	$cmdresult = exec('sudo /usr/bin/killall -q -9 MMDVMHost', $cmdoutput, $retvalue);
	break;
    case "updatehostsfiles":
	$cmdresult = exec('sudo -- /bin/bash -c "/usr/local/sbin/pistar-services fullstop; mount -o remount,rw /; /usr/local/sbin/HostFilesUpdate.sh; /usr/local/sbin/pistar-services restart;"', $cmdoutput, $retvalue);
	break; 
    case "HostFilesExcludeDMRidsUpdate":
    $cmdresult = exec('sudo -- /bin/bash -c "mount -o remount,rw /; sudo chmod +x /usr/local/sbin/HostFilesExcludeDMRidsUpdate.sh;sudo /usr/local/sbin/HostFilesExcludeDMRidsUpdate.sh;"', $cmdoutput, $retvalue);
    break;

    case "Allstarlink_status":
    $cmdresult = exec('sudo systemctl status asterisk', $cmdoutput, $retvalue);
    break;

    case "MMDVM_Bridge_status":
    $cmdresult = exec('sudo systemctl status mmdvm_bridge', $cmdoutput, $retvalue);
    break;

    case "Analog_Bridge_status":
    $cmdresult = exec('sudo systemctl status analog_bridge', $cmdoutput, $retvalue);
    break;

    case "Allstarlink_restart":
    $cmdresult = exec('sudo systemctl restart asterisk', $cmdoutput, $retvalue);
    break;

    case "MMDVM_Bridge_restart":
    $cmdresult = exec('sudo systemctl restart mmdvm_bridge', $cmdoutput, $retvalue);
    break;

    case "Analog_Bridge_restart":
    $cmdresult = exec('sudo systemctl restart analog_bridge', $cmdoutput, $retvalue);
    break;

    case "RunUpdatePatch":
    $cmdresult = exec('sudo chmod +x /tmp/tmpUpdatePath.sh; sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo /tmp/tmpUpdatePath.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ChangeGithub2Gitee":
    $cmdresult = exec('sudo chmod +x /usr/local/sbin/Change-Github-to-Gitee.sh; sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo /usr/local/sbin/Change-Github-to-Gitee.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ChangeGitee2Github":
    $cmdresult = exec('sudo chmod +x /usr/local/sbin/Recovery-Github-from-Gitee.sh; sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo /usr/local/sbin/Recovery-Github-from-Gitee.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ForceUpdateGit":
    $cmdresult = exec('sudo chmod +x /usr/local/sbin/Update-Pi-Star-OS-Ignore-Local-Changed.sh; sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo /usr/local/sbin/Update-Pi-Star-OS-Ignore-Local-Changed.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug":
    $cmdresult = exec('sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug.sh | sudo sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "Patch_Support_HDMI_1080p_FullScrean_RPi4B":
    $cmdresult = exec('sudo touch tmp/tmpUpdatePath.log > /dev/null 2>&1; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Support_HDMI_1080p_FullScrean_RPi4B.sh | sudo sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    default:
	$cmdoutput = array('error No operate call  !');
}
echo "<br />";
foreach ($cmdoutput as $l) {
    echo $l."<br />";
}
if ($retvalue == 0) {
    echo "<h2>** Success **</h2>";
}
else {
    echo "<h2>!! Failure !!</h2>";
}
echo "<br />";
?>
