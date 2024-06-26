<div class="header">
    <div style="font-size: 10px; text-align: left; padding-left: 8px; float: left;">Hostname: <?php echo exec('cat /etc/hostname'); ?></div><div style="font-size: 10px; text-align: right; padding-right: 8px;">Pi-Star: <?php echo $_SESSION['PiStarRelease']['Pi-Star']['Version'].'<br />';?>
    <?php if (constant("AUTO_UPDATE_CHECK") == "true") { ?> 
    <div id="CheckUpdate"><?php echo $version; system('/usr/local/sbin/pistar-check4updates'); ?></div></div>
    <?php } else { ?>
    <div id="CheckUpdate"><?php echo $version; ?></div></div>
    <?php } ?>    
    <h1>Pi-Star (J-STAR Desktop)Expert/Allstarlink/DVSwitch/FM Network - </h1>
    <p>
	<div class="navbar">
	    <a class="menuconfig" href="/admin/configure.php"><?php echo $lang['configuration'];?></a>
	    <a class="menubackup" href="/admin/config_backup.php"><?php echo $lang['backup_restore'];?></a>
	    <a class="menuupgrade" href="/admin/expert/upgrade.php">Upgrade</a>
	    <a class="menuupdate" href="/admin/update_HostFile_DMRIds.php">Update DMRIds</a>
	    <a class="menuupdate" href="/admin/update.php"><?php echo $lang['update'];?></a>
		<a class="menuadmin" href="/admin/expert/">Allstarlink</a>
		<a class="menuadmin" href="/admin/expert/">Expert</a>
	    <a class="menuadmin" href="/admin/"><?php echo $lang['admin'];?></a>
        <a class="menulive" href="/live/">Live Caller</a>
	    <a class="menudashboard" href="/"><?php echo $lang['dashboard'];?></a>
	</div>

	<div class="lnavbar">
            <ul class="mainnav">
		<li class="has-subs"><a href="#">Quick Editors</a>
		    <ul class="dropdown">
		    	<li class="subs"><a href="edit_mmdvmhost.php">MMDVMHost</a></li>
			<!-- D-Star Sub -->
			<li class="subs has-subs"><a href="#">D-Star</a>
			    <ul class="dropdown">
				<li class="subs"><a href="edit_dstarrepeater.php">D-StarRepeater</a></li>
				<li class="subs"><a href="edit_ircddbgateway.php">ircDDB Gateway</a></li>
				<li class="subs"><a href="edit_timeserver.php">TimeServer</a></li>
			    </ul>
			</li>
			<!-- DMR Sub -->
			<li class="subs has-subs"><a href="#">DMR</a>
			    <ul class="dropdown">
				<li class="subs"><a href="edit_dmrgateway.php">DMR Gateway</a></li>
				<li class="subs"><a href="edit_dmr2ysf.php">DMR to YSF</a></li>
				<li class="subs"><a href="edit_dmr2nxdn.php">DMR to NXDN</a></li>
			    </ul>
			</li>
			<!-- SystemFusion Sub -->
			<li class="subs has-subs"><a href="#">SystemFusion</a>
			    <ul class="dropdown">
				<li class="subs"><a href="edit_ysfgateway.php">YSF Gateway</a></li>
				<li class="subs"><a href="edit_dgidgateway.php">DGId Gateway</a></li>
				<li class="subs"><a href="edit_ysf2dmr.php">YSF to DMR</a></li>
				<li class="subs"><a href="edit_ysf2p25.php">YSF to P25</a></li>
				<li class="subs"><a href="edit_ysf2nxdn.php">YSF to NXDN</a></li>
			    </ul>
			</li>
            <!-- others -->
			<li class="subs"><a href="edit_p25gateway.php">P25 Gateway</a></li>
			<li class="subs"><a href="edit_nxdngateway.php">NXDN Gateway</a></li>
			<li class="subs"><a href="edit_m17gateway.php">M17 Gateway</a></li>
			<li class="subs"><a href="edit_aprsgateway.php">APRS Gateway</a></li>
			<!-- DAPNet Sub -->
			<li class="subs has-subs"><a href="#">DAPNet</a>
			    <ul class="dropdown">
				<li class="subs"><a href="edit_dapnetgateway.php">DAPNet Gateway</a></li>
				<li class="subs"><a href="edit_dapnetapi.php">DAPNet API</a></li>
			    </ul>
			</li>
		    </ul>
		</li>

		<li class="has-subs"><a href="#">Full Editors</a>
		    <ul class="dropdown">
			<li class="subs"><a href="fulledit_mmdvmhost.php">MMDVMHost</a></li>
			<li class="subs"><a href="fulledit_pistar-remote.php">PiStar-Remote</a></li>
			<!-- D-Star Sub -->
			<li class="subs has-subs"><a href="#">D-Star</a>
			    <ul class="dropdown">
				<li class="subs"><a href="fulledit_dstarrepeater.php">D-StarRepeater</a></li>
				<li class="subs"><a href="fulledit_ircddbgateway.php">ircDDB Gateway</a></li>
				<li class="subs"><a href="fulledit_timeserver.php">TimeServer</a></li>
			    </ul>
			</li>
			<!-- DMR Sub -->
			<li class="subs has-subs"><a href="#">DMR</a>
			    <ul class="dropdown">
				<li class="subs"><a href="fulledit_dmrgateway.php">DMR Gateway</a></li>
				<li class="subs"><a href="fulledit_dmr2ysf.php">DMR to YSF</a></li>
				<li class="subs"><a href="fulledit_dmr2nxdn.php">DMR to NXDN</a></li>
				<li class="subs"><a href="fulledit_bmapikey.php">Brandmeister API</a></li>
			    </ul>
			</li>
			<!-- YSF Sub -->
			<li class="subs has-subs"><a href="#">SystemFusion</a>
			    <ul class="dropdown">
				<li class="subs"><a href="fulledit_ysfgateway.php">YSF Gateway</a></li>
				<li class="subs"><a href="fulledit_dgidgateway.php">DGId Gateway</a></li>
				<li class="subs"><a href="fulledit_ysf2dmr.php">YSF to DMR</a></li>
				<li class="subs"><a href="fulledit_ysf2p25.php">YSF to P25</a></li>
				<li class="subs"><a href="fulledit_ysf2nxdn.php">YSF to NXDN</a></li>
			    </ul>
			</li>
            <!-- others -->
			<li class="subs"><a href="fulledit_p25gateway.php">P25 Gateway</a></li>
			<li class="subs"><a href="fulledit_nxdngateway.php">NXDN Gateway</a></li>
			<li class="subs"><a href="fulledit_m17gateway.php">M17 Gateway</a></li>
			<li class="subs"><a href="fulledit_aprsgateway.php">APRS Gateway</a></li>
			<!-- DAPNet Sub -->
			<li class="subs has-subs"><a href="#">DAPNet</a>
			    <ul class="dropdown">
				<li class="subs"><a href="fulledit_dapnetgateway.php">DAPNet Gateway</a></li>
				<li class="subs"><a href="fulledit_dapnetapi.php">DAPNet API</a></li>
			    </ul>
			</li>
			<li class="subs"><a href="fulledit_wpaconfig.php">WiFi</a></li>
			<li class="subs"><a href="fulledit_cron.php">System Cron</a></li>
			<li class="subs"><a href="fulledit_rssidat.php">RSSI Data</a></li>
		    </ul>
		</li>
		
		<li class="has-subs"><a href="#">Hosts File Editors</a>
		    <ul class="dropdown">
		    <li class="subs"><a href="fulledit_hosts_YSF_Hosts.php">YSF Hosts</a></li>
		    <li class="subs"><a href="fulledit_hosts_FCS_Hosts.php">FCS Hosts</a></li>
		    <li class="subs"><a href="fulledit_hosts_XLX_Hosts.php">XLX Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_DMR_Hosts.php">DMR Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_P25_Hosts.php">P25 Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_NXDN_Hosts.php">NXDN Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_M17_Hosts.php">M17 Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_DCS_Hosts.php">DCS Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_DExtra_Hosts.php">DExtra Hosts</a></li>
			<li class="subs"><a href="fulledit_hosts_DPlus_Hosts.php">DPlus Hosts</a></li>
			<li class="subs"><a href="#">--------</a></li> 
			<li class="subs"><a href="services.php?action=HostFilesExcludeDMRidsUpdate">Update Hosts</a></li>
			<li class="subs"><a href="fulledit_tmpUpdatePathLog.php">View Update Log</a></li>
		    </ul>
		</li>
			
		<li class="has-subs"><a href="#">Tools</a>
		    <ul class="dropdown">
			<!-- Services Sub -->
			<li class="subs has-subs"><a href="#">Pi-Star Services</a>
			    <ul class="dropdown">
				<li class="subs"><a href="services.php?action=stop">Stop Services</a></li>
				<li class="subs"><a href="services.php?action=fullstop">Full Stop Services</a></li>
				<li class="subs"><a href="services.php?action=restart">Restart Services</a></li>
				<li class="subs"><a href="services.php?action=status">Services Status</a></li>
				<li class="subs"><a href="services.php?action=killmmdvmhost">Kill MMDVMHost</a></li>
			    </ul>
			</li>
			<li class="subs"><a href="services.php?action=updatehostsfiles">Update Hosts+Ids</a></li>
			<li class="subs"><a href="services.php?action=HostFilesExcludeDMRidsUpdate">Update Hosts</a></li>
			<li class="subs"><a href="security_upgrades.php">Security Upgrades</a></li>
			<li class="subs"><a href="edit_dashboard.php">CSS Tool</a></li>
			<li class="subs"><a href="ssh_access.php">SSH Access</a></li>
			<li class="subs"><a href="jitter_test.php">DMR Jitter Test</a></li>
			<li class="subs"><a href="calibration.php">MMDVM Calibration</a></li>
			<li class="subs"><a href="config_manager.php">Config Manager</a></li>
			<li class="subs"><a href="log_manager.php">Log Manager</a></li>
			<li class="subs"><a href="filemanager.php">File Manager</a></li>
			<li class="subs"><a href="/config/changelog.php">ChangeLog</a></li>
		    </ul>
		</li>

		<li class="has-subs"><a href="#">Allstarlink</a>
		    <ul class="dropdown">
			<li class="subs"><a href="fulledit_asterisk_iax.php">iax.conf</a></li>
			<li class="subs"><a href="fulledit_asterisk_rpt.php">rpt.conf</a></li>
			<li class="subs"><a href="fulledit_asterisk_sip.php">sip.conf</a></li>
			<li class="subs"><a href="fulledit_asterisk_extensions.php">extensions.conf</a></li>  
			<li class="subs"><a href="fulledit_asterisk_manager.php">manager.conf</a></li>  
			<li class="subs"><a href="fulledit_asterisk_supermon.ini.php">supermon.ini</a></li>  
			<li class="subs"><a href="/admin/expert/filemanager.php?p=etc%2Fasterisk&edit=modules.conf">modules.conf</a></li>
			<li class="subs"><a href="/admin/expert/filemanager.php?p=etc%2Fasterisk&edit=echolink.conf">echolink.conf</a></li>
			<li class="subs"><a href="/supermon">ASL Dashboard</a></li>  
			<!-- D-Star Sub -->
			</ul>
		</li>

		<li class="has-subs"><a href="#">DVSwitch</a>
		    <ul class="dropdown">
			<li class="subs"><a href="fulledit_Analog_Bridge.ini.php">Analog_Bridge.ini</a></li>
			<li class="subs"><a href="fulledit_MMDVM_Bridge.ini.php">MMDVM_Bridge.ini</a></li>
			<li class="subs"><a href="fulledit_DVSwitch.ini.php">DVSwitch.ini</a></li>
			<li class="subs"><a href="/admin/expert/filemanager.php?p=opt%2FAnalog_Reflector&edit=Analog_Reflector.json">Analog_Reflector.json</a></li>
			<li class="subs"><a href="http://pi-star:8080">DVS Dashboard</a></li>   
			<li class="subs"><a href="http://pi-star:2812">MonitManager</a></li>
			<!-- D-Star Sub --> 
			</ul>
		</li>

			
		<li class="has-subs"><a href="#">Allstarlink Services</a>
            <ul class="dropdown">
			<li class="subs"><a href="services.php?action=Allstarlink_status">Allstarlink_status</a></li>
			<li class="subs"><a href="services.php?action=MMDVM_Bridge_status">MMDVM_Bridge_status</a></li>
			<li class="subs"><a href="services.php?action=Analog_Bridge_status">Analog_Bridge_status</a></li> 
			<li class="subs"><a href="services.php?action=Allstarlink_restart">Allstarlink_restart</a></li>
			<li class="subs"><a href="services.php?action=MMDVM_Bridge_restart">MMDVM_Bridge_restart</a></li>
			<li class="subs"><a href="services.php?action=Analog_Bridge_restart">Analog_Bridge_restart</a></li> 
			</ul>
		</li>

		<li class="has-subs"><a href="#">Allsarlink logs</a>
            <ul class="dropdown">
			<li class="subs"><a href="/admin/live_Allstarlink_log.php">Allstarlink log</a></li>
			<li class="subs"><a href="/admin/live_MMDVM_Bridge_log.php">MMDVM_Bridge log</a></li>
			<li class="subs"><a href="/admin/live_Analog_Bridge_log.php">Analog_Bridge log</a></li> 
			<li class="subs"><a href="/admin/live_modem_log.php">FM Log</a></li> 
			</ul>
		</li>
		<li class="has-subs"><a href="#">NextionDriver</a>
            <ul class="dropdown"> 
			<li class="subs"><a href="/admin/UnInstallNextionDriver.php">UnInstall</a></li>
			<li class="subs"><a href="/admin/InstallNextionDriver.php">Install</a></li>
			</ul>
		<li class="has-subs"><a href="#">J-StarOS</a>
            <ul class="dropdown">
			<li class="subs"><a href="fulledit_tmpUpdatePath.php">1.Edit Patch Script</a></li>
			<li class="subs"><a href="services.php?action=RunUpdatePatch">2.Run Patch Scipt</a></li>
			<li class="subs"><a href="fulledit_tmpUpdatePathLog.php">3.View Run Log</a></li>
			<li class="subs"><a href="services.php?action=ChangeGithub2Gitee">ChangeGithub2Gitee</a></li>
			<li class="subs"><a href="services.php?action=ChangeGitee2Github">ChangeGitee2Github</a></li>
			<li class="subs"><a href="services.php?action=ForceUpdateGit">Force Update Git</a></li>
			<li class="subs"><a href="services.php?action=Patch_Add_Rustdesk_AutoStart_RPi4B">RustDesk_Onboot</a</li>
			<li class="subs"><a href="fulledit_Modify-And-Todo-list.txt.php">Todo List</a></li>
			</ul>
		</li>
		<li class="has-subs"><a href="#">系统补丁</a>
            <ul class="dropdown">
            <li class="subs"><a href="services.php?action=Patch_Support_HDMI_1080p_FullScrean_RPi4B">修复1080p不满屏</a></li>
            <li class="subs"><a href="services.php?action=Patch_Add_HDMI_Chrome_AutoStart_BPiM2">HDMI开机仪表盘</a></li>
            <li class="subs"><a href="services.php?action=Patch_HDMI_Chrome_Change_Simple">HDMI简单版</a></li>
            <li class="subs"><a href="services.php?action=Patch_HDMI_Chrome_Change_Full">HDMI完整版</a></li>
            <li class="subs"><a href="services.php?action=Patch_HDMI_Chrome_Change_LiveCaller">HDMI直播版</a></li>
            <li class="subs"><a href="services.php?action=Patch_ZeroW_Open_CallerDetails">ZW开呼叫详情</a></li>

            <li class="subs"><a href="services.php?action=Patch_HDMI_Chrome_Close">HDMI关闭仪表盘</a></li>
            <li class="subs"><a href="services.php?action=Patch_Remove_OS_Unattended_upgrades">优化CPU占用</a></li> 
            <li class="subs"><a href="services.php?action=Patch_Change_CSS_to_PinkColor">仪表盘改粉红色</a></li>
            <li class="subs"><a href="services.php?action=Patch_Change_CSS_to_GrayColor">仪表盘改灰黑色</a></li>
            <li class="subs"><a href="services.php?action=Patch_Fix_ASL-3in1-OS-SSL_Certs_not_update_bug">修复ssl证书</a></li>
            <li class="subs"><a href="services.php?action=Patch_Add_XLX_JTA_To_List">添加XLX_JTA</a></li>
            <li class="subs"><a href="services.php?action=HostFilesExcludeDMRidsUpdate">修复国旗不显示</a></li>
            <li class="subs"><a href="services.php?action=Patch_Set_CN_LanguageAndTimeZone">设置中文+时区</a></li>
            <li class="subs"><a href="services.php?action=Patch_Install_Zip_if_Not_exist">修复Zip未安装</a></li> 
            <li class="subs"><a href="/admin/download_all_logs.php">下载所有日志</a></li> 
            <li class="subs"><a href="/admin/expert/filemanager.php?p=var%2Flog%2Fpi-star">浏览日志文件</a></li> 

            <li class="subs"><a href="/admin/expert/log_manager.php">清空QSO日志</a></li> 
            <li class="subs"><a href="/admin/update.php">修复Wi-Fi_AP丢失</a></li> 
            <li class="subs"><a href="services.php?action=Patch_Disable-WiFi-MAC-Randomization">禁止MAC地址变化</a></li> 
            <li class="subs"><a href="services.php?action=onekeyflash_RPi_fw_RPi_Duplex_VR2VYE_Ver1.6.1_CN">升级双工板固件1.6</a></li> 
            <li class="subs"><a href="services.php?action=onekeyflash_RPi_fw_RPi_Simplex_VR2VYE_Ver1.6.1_CN">升级单工板固件1.6</a></li> 
            <li class="subs"><a href="services.php?action=onekeyflash_RPi_fw_NanoPi_NEO_VR2VYE_Ver1.6.1_CN">升级NEO板固件1.6</a></li> 
            <li class="subs"><a href="services.php?action=onekeyflash_RPi_fw_RPi_REP_V3F4">升级中继板固件</a></li>  
			<li class="subs"><a href="/admin/UnInstallNextionDriver.php">卸载Nextion驱动</a></li>
			<li class="subs"><a href="/admin/InstallNextionDriver.php">安装Nextion驱动</a></li>
			<li class="subs"><a href="services.php?action=Patch_Add_Rustdesk_AutoStart_RPi4B">RustDesk_Onboot</a</li>
			<li class="subs"><a href="fulledit_tmpUpdatePathLog.php">查看执行结果</a></li> 
			</ul>
		</li> 
	    </ul>
	</div>
    </p>
</div>
