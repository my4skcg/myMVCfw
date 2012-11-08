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

	$u = \Lib\session::get('profileData');
	$fn = isset($u['firstname']) ?  $u['firstname'] : '';
	$ln = isset($u['lastname']) ?  $u['lastname'] : '';
	$addr1 = isset($u['address1']) ?  $u['address1'] : '';
	$addr2 = isset($u['address2']) ?  $u['address2'] : '';
	$city = isset($u['city']) ?  $u['city'] : '';
	$state = isset($u['state']) ?  $u['state'] : '';
	$zip = isset($u['zip']) ?  $u['zip'] : '';
	$zip4 = isset($u['zip4']) ?  $u['zip4'] : '';
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
		<div class="elements">
			<label for="address1">Address :</label>
			<input type="text" id="address1" name="address1" size="25" value="<?php echo $addr1 ?>"/>
		</div>
		<div class="elements">
			<label for="address2">Address :</label>
			<input type="text" id="address2" name="address2" size="25" value="<?php echo $addr2 ?>"/>
		</div>
		<div class="elements">
			<label for="city">City :</label>
			<input type="text" id="city" name="city" size="25" value="<?php echo $city ?>"/>
		</div>
		<div class="elements">
			<label for="state">State :</label>
			<input type="text" id="state" name="state" size="25" value="<?php echo $state ?>"/>
		</div>
		<div class="elements">
			<label for="zip">Zip :</label>
			<input type="text" id="zip" name="zip" size="25" value="<?php echo $zip ?>"/>
		</div>
		<div class="elements">
			<label for="zip4">Zip 4 digit extension :</label>
			<input type="text" id="zip4" name="zip4" size="25" value="<?php echo $zip4 ?>"/>
		</div>
		<div class="submit">
			<input type="submit" value="submit" name="submitform"/>
		</div>
		</fieldset>

	</form>
	</div>

<?php
}
?>
