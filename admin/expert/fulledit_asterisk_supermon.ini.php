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

$editorname = '/var/www/dashboard/supermon/allmon.ini';
$configfile = '/var/www/dashboard/supermon/allmon.ini';
$tempfile = '/tmp/bW1kdm1ob3N0DQo_supermonAllmon.ini.tmp';
$servicenames = array('');

require_once('fulledit_template.php');

?>
