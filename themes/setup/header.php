<?php if(!defined('MAGNETITE_VERSION')){ die('Accessing this file directly is not allowed. Would you like to go back to the <a href="../../index.php">index</a>?');} ?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Magnetite Setup</title>

		<link rel="stylesheet" href="css/magnetite.css?v=<?php echo MAGNETITE_VERSION; ?>">
		<link rel="stylesheet" href="css/setup.css?v=<?php echo MAGNETITE_VERSION; ?>">
	</head>

	<body>

		<div id="container">
			<small>Step <?php echo ($config['SETUP_STAGE']+1).' of '.(MAX_SETUP_STAGE+1); ?></small>
			<div id="progress_bar">
				<div id="progress" style="width:<?php echo (((float)$config['SETUP_STAGE']/(float)MAX_SETUP_STAGE)*100).'%'; ?>"></div>
			</div>