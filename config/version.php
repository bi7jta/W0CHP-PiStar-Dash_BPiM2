<?php

// Enhanced version status; W0CHP

$ver_cmd = exec('git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git rev-parse HEAD | tail -1 | awk \'{ print substr($1,1,10) }\''); # last pipe to awk: converts long hash to 10 chars.
$ver_no = "W0CHP-PiStar-Dash_Ver.#".$ver_cmd;

$git_branch = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git branch | grep '*' | cut -f2 -d ' '");
$version = "$ver_no / Branch: $git_branch";

?>
