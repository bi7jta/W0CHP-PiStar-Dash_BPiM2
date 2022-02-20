<?php

if($_POST['action'] == 'enable') {
    echo "For performance, the number of Last Heard rows will be decreased while Current/Last Caller is enabled.\n\n";
    exec('sudo mount -o remount,rw /');
    exec('sudo touch /etc/.CALLERDETAILS');
    exec('sudo mount -o remount,ro /');
}

if($_POST['action'] == 'disable') {
    echo "Current/Last Caller display disabled.\n\nIncreasing Last Heard table rows to user preference (if set) or default (40).";
    exec('sudo mount -o remount,rw /');
    exec('sudo rm -rf /etc/.CALLERDETAILS');
    exec('sudo mount -o remount,ro /');
}

?>
