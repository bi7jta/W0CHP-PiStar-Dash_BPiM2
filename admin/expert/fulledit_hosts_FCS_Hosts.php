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

$editorname = '/root/FCSHosts.txt';
$configfile = '/root/FCSHosts.txt';
$tempfile = '/tmp/2SD3BhQpkuEUM_FCSHosts.tmp';

require_once('fulledit_template.php');

?>
