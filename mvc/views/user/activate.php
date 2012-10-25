<html>

	Hello, 
	
	<?php if (!\Lib\session::get('username'))
	{
		echo "user";
	}
	else 
	{
		echo \Lib\session::get('username');
	} ?>
	!</br>
	</br>
	Your Registration has been completed.  You may now login. </br>
	<a href="<?php echo URI; ?>/login">Login</a>