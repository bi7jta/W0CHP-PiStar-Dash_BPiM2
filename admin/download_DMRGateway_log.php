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

if ($_SERVER["PHP_SELF"] == "/admin/download_DMRGateway_log.php") {
	if (file_exists('/etc/dstar-radio.mmdvmhost')) {
		$logfile = "/var/log/pi-star/DMRGateway-".gmdate('Y-m-d').".log";
	}
	elseif (file_exists('/etc/dstar-radio.dstarrepeater')) {
		if (file_exists("/var/log/pi-star/DStarRepeater-".gmdate('Y-m-d').".log")) {$logfile = "/var/log/pi-star/DStarRepeater-".gmdate('Y-m-d').".log";}
		if (file_exists("/var/log/pi-star/dstarrepeaterd-".gmdate('Y-m-d').".log")) {$logfile = "/var/log/pi-star/dstarrepeaterd-".gmdate('Y-m-d').".log";}
	}

	$hostNameInfo = exec('cat /etc/hostname');

	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private', false);
	header('Content-Type: text/plain');
	if ($hostNameInfo != "pi-star") {
		header('Content-Disposition: attachment; filename="Pi-Star_'.$hostNameInfo.'_'.basename($logfile).'";');
	} else {
		header('Content-Disposition: attachment; filename="Pi-Star_'.basename($logfile).'";');
	}
	header('Content-Length: '.filesize($logfile));
	header('Accept-Ranges: bytes');

	// User Agent Detection
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'indows') !== false) {
		$userAgent = "Windows";
	} else {
		$userAgent = "NonWindows";
	}

	// Pre-flight checks done, send the output.
	set_time_limit(0);
	$file = @fopen($logfile,"rb");
	while(!feof($file)) {
		if ($userAgent == "Windows") { print(str_replace("\n", "\r\n", @fread($file, 1024*8))); }
		if ($userAgent == "NonWindows") { print(@fread($file, 1024*8)); }
		ob_flush();
		flush();
	}

	// Ok we are done, close the file and clean up.
	@fclose($file);
	exit;
}
else {
    die();
}
?>
