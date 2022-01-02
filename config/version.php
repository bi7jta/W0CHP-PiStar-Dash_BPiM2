<?php

// Enhanced version status; W0CHP

$gitBranch = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git branch | grep '*' | cut -f2 -d ' '");
$versionCmd = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git rev-parse --short=10 $gitBranch");
$verNo = "W0CHP-PiStar-Dash_Ver.#".$versionCmd;

$version = "$verNo / Branch: $gitBranch";

?>
