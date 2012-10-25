<?php
if (\Lib\session::get('displayMsg'))
{
	echo \Lib\session::get('displayMsg');
	\Lib\session::delete('displayMsg');
}


/*
 * Attempt at putting an objec in _SESSION; not even sure if it's a good idea
require "/var/www/mvc/models/message.php";
 * 
if ($statusObj = \Lib\session::get('message'))
{
	if ($statusObj->getStatus() == 'successful')
		while ($m = $statusObj->popMsg())
			echo $m . "\n";

}
 */
?>

<h1>Login</h1>

<form action="login/loginAction" method="post">
	<label>UserName</label><input type="text" name="username" /><br />
	<label>Password</label><input type="password" name="password" /><br />
	<label></label><input type="submit"/>
</form>