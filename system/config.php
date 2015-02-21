<?php
	// In general, you shouldn't have to touch this file - the only instance that you will have to is if you have forgotten your password.
	// Everything else will be handled by the setup script when you first run the Magnetite server.
	
	// Change this to true to reset the Magnetite server admin password. Make sure to set this to false again after you have changed it.
	$config['RESET_PASSWORD'] = %s;

	// Database Connection Settings
	$config['DB'] = array(
		'type' => '%s',
		'hostname' => '%s',
		'username' => '%s',
		'password' => '%s',
		'database' => '%s',
		'prefix' => '%s'
	);

	$config['SETUP_STAGE'] = '%d';