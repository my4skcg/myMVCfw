<?php
if (\Lib\session::get('status') == 'successful')
{
	if (\Lib\session::get('displayMsg'))
	{
		echo \Lib\session::get('displayMsg');
		\Lib\session::delete('displayMsg');
	}
	\Lib\session::delete('status');
}
else
{
	if ((\Lib\session::get('status') == 'errors') &&
			($errors = \Lib\session::get('displayMsg')))
	{
		foreach ($errors as $err)
			echo $err . "</br>";
		\Lib\session::delete('displayMsg');
	}

	$u = \Lib\session::get('userData');
	$un = isset($u['username']) ?  $u['username'] : '';
	$em = isset($u['email']) ?  $u['email'] : '';
	\Lib\session::delete('userData');
?>

<h1>Edit Credentials</h1>

<form action="editUser" method="post">
	You must confirm your password in order to change your User Name, Password, and E-mail</br>
	</br>
	<label>Current Password</label><input type="password" name="password" /><br />
	</br>
	</br>
	If you are not changing a field, then leave it blank.
	</br>
	<label>New User Name</label><input type="text" name="newusername" value="<?php echo $un ?>" /><br />
	<label>New Password</label><input type="password" name="newpassword" /><br />
	<label>New Password Confirm</label><input type="password" name="newpassword2" /><br />
	<label>New Email</label><input type="text" name="email" value="<?php echo $em ?>"/><br />
	<label></label><input type="submit" value="submit" name="submitform"/>


</form>

<?php
}
?>