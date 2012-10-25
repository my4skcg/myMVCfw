<!doctype html>

<html>
	<head>
		<title>Test</title>
		<link rel="stylesheet" href="<?php echo URI; ?>/public/css/default.css" />
	</head>

	<body>

		<div id="header">
			<h1>
				Hello, 

				<?php if (!\Lib\session::get('username'))
				{
					echo "Guest";
				}
				else 
				{
					echo \Lib\session::get('username');
				} ?>
				<br/>
				<br/>
			</h1>

			<a href="<?php echo URI; ?>/index">Index</a>
			<a href="<?php echo URI; ?>/help">Help</a>
			<?php if (\Lib\session::get('username')): ?>
				<a href="<?php echo URI; ?>/dashboard">Dashboard</a>
				<a href="<?php echo URI; ?>/login/logoutAction">Logout</a>
			<?php else: ?>
				<a href="<?php echo URI; ?>/login">Login</a>
				<a href="<?php echo URI; ?>/user/register">Register</a>
			<?php endif; ?>
		</div>

		<div id="content">
