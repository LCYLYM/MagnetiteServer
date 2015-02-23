<?php
	
	define('MAGNETITE_VERSION','0.1');


	//Big thanks to @tha_rami of @Vlambeer for writing presskit(), which has been a huge inspiration for Magnetite

	if(ini_get('safe_mode')){
		echo('<div class="errorBox"><strong>PHP Server Issue Detected: PHP Safe Mode Enabled</strong><p>Unfortunately, it looks like your host has PHP Safe Mode enabled - if you can upgrade to PHP 5.4+ or disable Safe Mode, please do so before you continue.</p>');
		die();
	}

	//We're also going to assume that the server is using 4.3+ - the last version of 4.2.x is over ten years old. Update that shit.

	//Determine whether we have already installed the server... NOW.
	if( !file_exists('magnetite.ini') ){
		//Alright, looks like we are in a clean install - that, or someone deleted the ini file. @TODO: Maybe make this a more definite check. Or maybe not.
		//Anyway, let's grab those files - we'll use the github "full install" branch.
	}

?>