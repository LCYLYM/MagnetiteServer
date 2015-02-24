<?php
	//Big thanks to @tha_rami of @Vlambeer for writing presskit(), which has been a huge inspiration for Magnetite

	define('MAGNETITE_VERSION','0.1');
	define('MAGNETITE_DIR',__FILE__);
	define('SYSTEM_DIR',MAGNETITE_DIR.'/system');
	define('DBO_DIR',SYSTEM_DIR.'/dbo');

	if(ini_get('safe_mode')){
		echo('<div class="errorBox"><strong>PHP Server Issue Detected: PHP Safe Mode Enabled</strong><p>Unfortunately, it looks like your host has PHP Safe Mode enabled - if you can upgrade to PHP 5.4+ or disable Safe Mode, please do so before you continue.</p>');
		die();
	}

	include('./themes/magnetite/templates/header.php');

	function do_install_step($step_name,$config){
		switch($step_name){
			case 'intro':
				$simple_allowed = class_exists("SQLite3") || function_exists('sqlite_open');
				include('./themes/magnetite/templates/intro.php');
				break;
			case 'auto_build':
				//check to see whether we are using SQLite or SQLite3
				if( !class_exists("SQLite3") ){
					require_once(DBO_DIR.'/sqlite.php');
				}else{
					require_once(DBO_DIR.'/sqlite3.php');
				}
				//add auto plugins to $_POST['plugins_queried']
				do_install_step('install_plugins',$config);
				break;
			case 'db_select':
				include('./themes/magnetite/templates/db_select.php');
				break;
			case 'db_config':
				include('./themes/magnetite/templates/db_config.php');
				break;
			case 'select_plugins':
				include('./themes/magnetite/templates/select_plugins.php');
				break;
			case 'install_plugins':
				include('./themes/magnetite/templates/install_plugins.php');
				break;
			case 'complete':
				include('./themes/magnetite/templates/complete.php');
				break;
		}
	}

	function install_plugin($plugin,$config){
		$success = false;

		return $success?'1':'0';
	}

	//We're also going to assume that the server is using 4.3+ - the last version of 4.2.x is over ten years old. Update that shit.

	$do_install = false;

	$default_config = array(

	);

	//Determine whether we have already installed the server... NOW.
	if( !file_exists('./system/config.php') ){
		$do_install = true;
		$config = $default_config;
	}else{
		require_once('./system/config.php');
		$config += $default_config;
	}

	if(!empty($_POST['plugin'])){
		die(install_plugin($_POST['plugin'],$config));
	}else if($do_install){
		//Determine install step!
		$main_config_changes = array_diff_assoc($config,$default_config);
		$num_main_config_changes = count($main_config_changes);
		
		$db_config_changes = array_diff_assoc($config['db'],$default_config['db']);
		$num_db_config_changes = count($db_config_changes);
		

		if($num_main_config_changes == 0 && $num_db_config_changes == 0 && !isset($_POST['install_type'])){
			do_install_step('intro',$config);
		}else if($num_main_config_changes == 0 && $num_db_config_changes == 0 && isset($_POST['install_type']) && $_POST['install_type'] != ''){
			if($_POST['install_type']=='simple'){
				do_install_step('auto_build',$config);	
			}else{
				do_install_step('db_select',$config);
			}
		}else if($num_db_config_changes == 1 && array_key_exists('type',$db_config_changes) && $num_config_changes == 0){
			do_install_step('db_config',$config);
		}else if($num_db_config_changes == 5 && $num_config_changes == 0 && !isset($_POST['plugins_queried'])){
			do_install_step('select_plugins',$config);
		}else if($num_db_config_changes == 5 && $num_config_changes == 0 && isset($_POST['plugins_queried'])){
			do_install_step('install_plugins',$config);
		}else{
			do_install_step('complete',$config);
		}
	}

	include('./themes/magnetite/templates/footer.php');

?>