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
    $cmdresult = exec('sudo -- /bin/bash -c "mount -o remount,rw /; sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo chmod +x /usr/local/sbin/HostFilesUpdate.sh; sudo /usr/local/sbin/HostFilesUpdate.sh HostOnly  > /tmp/tmpUpdatePath.log; "', $cmdoutput, $retvalue);
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
    $cmdresult = exec('sudo chmod +x /tmp/tmpUpdatePath.sh; sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo /tmp/tmpUpdatePath.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ChangeGithub2Gitee":
    $cmdresult = exec('sudo chmod +x /usr/local/sbin/Change-Github-to-Gitee.sh; sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo /usr/local/sbin/Change-Github-to-Gitee.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ChangeGitee2Github":
    $cmdresult = exec('sudo chmod +x /usr/local/sbin/Recovery-Github-from-Gitee.sh; sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo /usr/local/sbin/Recovery-Github-from-Gitee.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "ForceUpdateGit":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log;  sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Update-Pi-Star-OS-Ignore-Local-Changed.sh |sudo sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo chmod +x /usr/local/sbin/patch-scripts/Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug.sh; sudo /usr/local/sbin/patch-scripts/Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug.sh > /tmp/tmpUpdatePath.log;', $cmdoutput, $retvalue);
    break;

    case "Patch_Support_HDMI_1080p_FullScrean_RPi4B":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Support_HDMI_1080p_FullScrean_RPi4B.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_Add_HDMI_Chrome_AutoStart_BPiM2":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Add_HDMI_Chrome_AutoStart_BPiM2.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_HDMI_Chrome_Change_Simple":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_HDMI_Chrome_Change_Simple.sh | sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_HDMI_Chrome_Change_Full":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_HDMI_Chrome_Change_Full.sh | sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_HDMI_Chrome_Change_LiveCaller":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_HDMI_Chrome_Change_LiveCaller.sh | sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;  

    case "Patch_ZeroW_Open_CallerDetails":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_ZeroW_Open_CallerDetails.sh | sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;  

    case "Patch_HDMI_Chrome_Close":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_HDMI_Chrome_Close.sh | sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_Change_CSS_to_PinkColor":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Change_CSS_to_PinkColor.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_Add_XLX_JTA_To_List":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Add_XLX_JTA_To_List.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;

    case "Patch_Support_RPi5B":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Support_RPi5B.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
    break;
    case "Patch_Set_Chese_LanguageAndTimeZone":
    $cmdresult = exec('sudo touch /tmp/tmpUpdatePath.log; sudo chmod 777 /tmp/tmpUpdatePath.log; sudo curl https://www.bi7jta.cn/files/AndyTaylorTweet/updateScripts/Patch_Set_CN_LanguageAndTimeZone.sh |sudo sh > /tmp/tmpUpdatePath.log; ', $cmdoutput, $retvalue);
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
