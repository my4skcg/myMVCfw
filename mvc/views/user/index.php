<?php
if (\Lib\session::get('errorMsg'))
{
	$errors = \Lib\session::get('errorMsg');
	foreach ($errors as $err)
		echo $err . "</br>";
	\Lib\session::delete('errorMsg');
}

$u = \Lib\session::get('userData');
$un = isset($u['username']) ?  $u['username'] : '';
$em = isset($u['email']) ?  $u['email'] : '';
\Lib\session::delete('userData');

?>

<h1>Registration</h1>

<form action="profile/register" method="post">
	<label>UserName</label><input type="text" name="username" value="<?php echo $un ?>" /><br />
	<label>Password</label><input type="password" name="password" /><br />
	<label>Password Confirm</label><input type="password" name="password2" /><br />
	<label>Email</label><input type="text" name="email" value="<?php echo $em ?>"/><br />
	<label></label><input type="submit"/>

	<!--
	  <fieldset>
    <legend>Registration Form </legend>

    <p>Create A new Account <span style="background:#EAEAEA none repeat scroll 0 0;line-height:1;margin-left:210px;;padding:5px 7px;">
Already a member? <a href="<?php echo URI; ?>/login">Log in</a></span> </p>

    <div class="elements">
      <label for="name">UserName :</label>
      <input type="text" id="username" name="username" size="25" />
    </div>
    <div class="elements">
      <label for="email">E-mail :</label>
      <input type="text" id="email" name="email" size="25" />
    </div>
    <div class="elements">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" size="25" />
    </div>
    <div class="elements">
      <label for="password2">Confirm Password:</label>
      <input type="password2" id="password2" name="password2" size="25" />
    </div>
    <div class="submit">
     <input type="hidden" name="formsubmitted" value="TRUE" />
      <input type="submit" value="Register" />
    </div>
  </fieldset>
 -->
</form>
