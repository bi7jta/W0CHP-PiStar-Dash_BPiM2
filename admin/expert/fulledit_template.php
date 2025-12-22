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

// Load the language support
require_once $_SERVER['DOCUMENT_ROOT'].'/config/language.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/version.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
    <head>
	<meta name="robots" content="index" />
	<meta name="robots" content="follow" />
	<meta name="language" content="English" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Author" content="Andrew Taylor (MW0MWZ), Chip Cuccio (W0CHP)" />
	<meta name="Description" content="Pi-Star Expert Editor" />
	<meta name="KeyWords" content="MMDVMHost,ircDDBGateway,D-Star,ircDDB,DMRGateway,DMR,YSFGateway,YSF,C4FM,NXDNGateway,NXDN,P25Gateway,P25,Pi-Star,DL5DI,DG9VH,MW0MWZ,W0CHP" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="pragma" content="no-cache" />
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Expires" content="0" />
	<title>Pi-Star - Digital Voice Dashboard - Expert Editor</title>
	<link rel="stylesheet" type="text/css" href="/css/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/pistar-css.php?version=<?php echo $versionCmd; ?>" />
    </head>
    <body>
	<div class="container">
	    <?php include './header-menu.inc'; ?>
	    <div class="contentwide">
		<?php
		$theData = '';

		function safe_open_and_read($filepath) {
		    if (!is_file($filepath) || !is_readable($filepath)) {
		        return '';
		    }

		    $size = filesize($filepath);
		    if ($size === false || $size === 0) {
		        return '';
		    }

		    $fh = fopen($filepath, 'r');
		    if ($fh === false) {
		        return '';
		    }

		    $data = fread($fh, $size);
		    fclose($fh);
		    return $data === false ? '' : $data;
		}

		if (isset($_POST['data'])) {

		    exec('sudo cp ' . escapeshellarg($configfile) . ' ' . escapeshellarg($tempfile));
		    exec('sudo chown www-data:www-data ' . escapeshellarg($tempfile));
		    exec('sudo chmod 664 ' . escapeshellarg($tempfile));

		    $filepath = $tempfile;
		    $data = str_replace("\r", "", $_POST['data']);

		    if (function_exists('process_before_saving')) {
		        process_before_saving($data);
		    }

		    $fh = fopen($filepath, 'w');
		    if ($fh !== false) {
		        fwrite($fh, $data);
		        fclose($fh);
		    }

		    exec('sudo mount -o remount,rw /');
		    exec('sudo cp ' . escapeshellarg($tempfile) . ' ' . escapeshellarg($configfile));
		    exec('sudo chmod 644 ' . escapeshellarg($configfile));
		    exec('sudo chown root:root ' . escapeshellarg($configfile));
		    exec('sudo mount -o remount,ro /');

		    if (!empty($servicenames)) {
		        foreach ($servicenames as $servicename) {
		            exec('sudo systemctl restart ' . escapeshellarg($servicename));
		        }
		    }

		    $theData = safe_open_and_read($filepath);

		} else {

		    exec('sudo cp ' . escapeshellarg($configfile) . ' ' . escapeshellarg($tempfile));
		    exec('sudo chown www-data:www-data ' . escapeshellarg($tempfile));
		    exec('sudo chmod 664 ' . escapeshellarg($tempfile));

		    $theData = safe_open_and_read($tempfile);
		}
		?>

		
		<form name="test" method="post" action="">
		    <label for="data" class="header" style="display:block;text-align:center;" ><?php echo $editorname ?></label> 
		    <textarea id="data" name="data" cols="130" rows="45"><?php echo $theData; ?></textarea><br />
		    <input type="submit" name="submit" value="<?php echo $lang['apply']; ?>" />
		</form>
		
	    </div>
	    
    <div class="footer">
       <?php 
        echo 'Pi-Star / Pi-Star Dashboard, &copy; Andy Taylor (MW0MWZ) 2014-'.date("Y").'<br />'."\n";
        echo '<a href="https://w0chp.net/w0chp-pistar-dash/" style="color: #ffffff; text-decoration:underline;">W0CHP-PiStar-Dash</a> enhancements by W0CHP'.'<br />'."\n";
        echo 'Add <a href="https://github.com/BI7JTA" style="color: #ffffff; text-decoration:underline;">Allstarlink,DVSwitch,BPiM2</a> Modified by BI7JTA';
       ?>
    </div>
	    
	</div>
    </body>
</html>
