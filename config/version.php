<?php
// Enhanced version status; W0CHP
$ver_no = '20211219_03-W0CHP';
//
//
//
$git_branch = exec("git --work-tree=/var/www/dashboard --git-dir=/var/www/dashboard/.git branch | grep '*' | cut -f2 -d ' '");
$version = "$ver_no / Branch: $git_branch";
?>
