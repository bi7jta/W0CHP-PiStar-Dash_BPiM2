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

$editorname = 'XLX Hosts';
$configfile = '/usr/local/etc/XLXHosts.txt';
$tempfile = '/tmp/xGTcrAjxp2DN2.tmp';

// Create empty host file if we don't have one
$cmdresult = exec('sudo test -s /usr/local/etc/XLXHosts.txt', $dummyoutput, $retvalue);
if ($retvalue != 0) {
    exec('sudo echo "create XLXHosts.txt" >> /tmp/debug.txt');
    exec('sudo touch /tmp/xGTcrAjxp2DN2.tmp');
    exec('sudo chown www-data:www-data /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#       XLXHosts.txt" > /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#       Written for Pi-Star Digital Voice Node by Andy Taylor (MW0MWZ)" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#       Original idea from Jonathan Naylor (G4KLX)" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#	The format of this file is:" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#	XLX Number;host;default" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#########################################################################" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#	XLX Hosts Below" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('echo "#########################################################################" >> /tmp/xGTcrAjxp2DN2.tmp');
    exec('sudo mount -o remount,rw /');
    exec('sudo mv /tmp/xGTcrAjxp2DN2.tmp /usr/local/etc/XLXHosts.txt');
    exec('sudo chmod 644 /usr/local/etc/XLXHosts.txt');
    exec('sudo chown root:root /usr/local/etc/XLXHosts.txt');
    exec('sudo mount -o remount,ro /');
}

require_once('fulledit_template.php');

?>
