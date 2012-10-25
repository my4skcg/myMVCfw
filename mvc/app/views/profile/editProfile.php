<?php
if (\Lib\session::get('displayMsg'))
{
	$errors = \Lib\session::get('displayMsg');
	foreach ($errors as $err)
		echo $err . "</br>";
	\Lib\session::delete('displayMsg');
}

$data = \Lib\session::get('profileData');
$fn = isset($u['firstname']) ?  $u['firstname'] : '';
$ln = isset($u['lastname']) ?  $u['lastname'] : '';
\Lib\session::delete('profileData');
?>

<div id="content">

<h1>Profile</h1>

<form action="editProfile" method="post">

	<fieldset>
  <legend>Profile Form </legend>

	<div class="elements">
		<label for="firstname">First Name :</label>
		<input type="text" id="firstname" name="firstname" size="25" value="<?php echo $fn ?>"/>
	</div>
	<div class="elements">
		<label for="lastname">Last Name :</label>
		<input type="text" id="lastname" name="lastname" size="25" value="<?php echo $ln ?>"/>
	</div>
	<div class="submit">
		<input type="submit" value="submit" name="submitform"/>
	</div>
	</fieldset>

</form>
</div>

