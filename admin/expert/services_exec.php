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
