<div class="header">
    <div style="font-size: 8px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 8px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version']?> / <?php echo $lang['dashboard'].": ".$version; ?></div>
    <h1>Pi-Star Digital Voice - Expert</h1>
    <p>
	<div class="navbar">
	    <a class="menuconfig" href="/admin/configure.php"><?php echo $lang['configuration'];?></a>
	    <a class="menubackup" href="/admin/config_backup.php"><?php echo $lang['backup_restore'];?></a>
	    <a class="menuupgrade" href="/admin/expert/upgrade.php">Upgrade</a>
	    <a class="menuupdate" href="/admin/update.php"><?php echo $lang['update'];?></a>
	    <a class="menuadmin" href="/admin/"><?php echo $lang['admin'];?></a>
	    <a class="menudashboard" href="/"><?php echo $lang['dashboard'];?></a>
	</div>

    </p>
</div>
