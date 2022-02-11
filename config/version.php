<?php

// Enhanced version status; W0CHP

$configUpdateRequired = 2022021100; // format = YYYYMMDDnn

$gitBranch = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git branch | grep '*' | cut -f2 -d ' '");
$versionCmd = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git rev-parse --short=10 $gitBranch");
$verNo = "W0CHP-PiStar-Dash_Ver.#".$versionCmd;

if ($gitBranch !== "master") {
    $version = "$verNo / Branch: $gitBranch";
} else {
    $version = "$verNo";
}

?>
