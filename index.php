<?php
	require_once('config.php');

	if(!isset($config)){
		$config = array();
	}

	define('MAGNETITE_VERSION','0.1');
	define('MAX_SETUP_STAGE',5);

	$stages = array(
		'SETUP_INITIALIZE',
		'SETUP_DIFFICULTY',
		'SETUP_DB_CONFIG',
		'SETUP_ADMIN_PASSWORD',
		'SETUP_COMPLETE'
	);

	foreach($stages as $i=>$stage){
		define($stage,$i);
	}

	$config += array(
		'RESET_PASSWORD' => false,
		'DB' => array(),
		'SETUP_STAGE' => 0
	);

	$config['DB'] += array(
		'type' => 'sqlite',
		'hostname' => './system/',
		'username' => '',
		'password' => '',
		'database' => 'magnetite',
		'prefix' => ''
	);

	$update_config = false;

	if($config['SETUP_STAGE'] < MAX_SETUP_STAGE){

		if($_POST['action'] == 'save' && $_POST['stage'] == $config['SETUP_STAGE']){
			switch($config['SETUP_STAGE']){
				case SETUP_INITIALIZE:
					$config['SETUP_STAGE'] = SETUP_DIFFICULTY;
					$update_config = true;
					break;
				case SETUP_DIFFICULTY:
					if($_POST['type'] == 'easy'){
						//Cool - using sqlite; just make sure config says so, then create the DB
						$config['DB'] = array(
							'type' => 'sqlite',
							'hostname' => './system/',
							'username' => '',
							'password' => '',
							'database' => 'magnetite',
							'prefix' => ''
						);

						include_once "./lib/ezSQL/shared/ez_sql_core.php";

						$database_file = $config['DB']['database'].'.db';

						if(class_exists('SQLite3')){
							$config['DB']['type'] = 'sqlite3';
							include_once "./lib/ezSQL/sqlite/ez_sql_sqlite3.php";
							$db = new ezSQL_sqlite3();
						}else{
							include_once "./lib/ezSQL/sqlite/ez_sql_sqlite.php";
							$db = new ezSQL_sqlite();
						}

						if($db->connect($config['DB']['hostname'],$database_file)){
							$config['SETUP_STAGE'] = SETUP_ADMIN_PASSWORD;
							$update_config = true;
						}
					}else{
						$config['SETUP_STAGE'] = SETUP_DB_CONFIG;
						$update_config = true;
					}
					break;
				case SETUP_DB_CONFIG:
					
					break;
				case SETUP_ADMIN_PASSWORD:
					
					break;
				case SETUP_COMPLETE:
					
					break;
			}
		}
		require_once('./themes/setup/header.php');

		switch($config['SETUP_STAGE']){
			case SETUP_INITIALIZE:

				require_once('./views/setup/initialize.php');
				
				break;
			case SETUP_DIFFICULTY:
				
				require_once('./views/setup/difficulty.php');

				break;
			case SETUP_DB_CONFIG:
				
				break;
			case SETUP_ADMIN_PASSWORD:
				
				break;
			case SETUP_COMPLETE:
				
				break;
		}

		require_once('./themes/setup/footer.php');

	}

	if($update_config){
		file_put_contents(
			"config.php",
			sprintf(
				file_get_contents('./system/config.php'),
				$config['RESET_PASSWORD']?'true':'false',
				$config['DB']['type'],
				$config['DB']['hostname'],
				$config['DB']['username'],
				$config['DB']['password'],
				$config['DB']['database'],
				$config['DB']['prefix'],
				$config['SETUP_STAGE']
			)
		);
	}
	/*echo sprintf(
		file_get_contents('./system/config.php'),
		Magnetite::$config['RESET_PASSWORD']?'true':'false',
		Magnetite::$config['DB']['type'],
		Magnetite::$config['DB']['hostname'],
		Magnetite::$config['DB']['username'],
		Magnetite::$config['DB']['password'],
		Magnetite::$config['DB']['database'],
		Magnetite::$config['DB']['prefix'],
		Magnetite::$config['SETUP_STAGE']
	);*/