<html>

	User is now logged in!</br>
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

	<div id="content">

	<a href="<?php echo URI; ?>/user/editUser">Change User Name, Password and/or Email</br></a>
	<a href="<?php echo URI; ?>/user/delete">Delete User</br></a>
	<a href="<?php echo URI; ?>/profile/editProfile">Edit Profile</br></a>
	<a href="<?php echo URI; ?>/contact/addContact">Add Contact</br></a>

	</div>

