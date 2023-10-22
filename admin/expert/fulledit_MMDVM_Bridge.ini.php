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

$editorname = '/opt/MMDVM_Bridge/MMDVM_Bridge.ini';
$configfile = '/opt/MMDVM_Bridge/MMDVM_Bridge.ini';
$tempfile = '/tmp/bW1kdm1ob3N0DQo_MMDVM_Bridge.ini.tmp';
$servicenames = array('mmdvm_bridge.service');

require_once('fulledit_template.php');

?>
