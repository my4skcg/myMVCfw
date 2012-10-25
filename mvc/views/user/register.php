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
	Thank you for registering!</br>
	To complete your registration, please check your email for the link on activating your account!</br>
