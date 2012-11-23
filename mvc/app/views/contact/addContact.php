<?php
$displayForm = true;

$params = \Lib\session::get('params');
$lang = $params['lang'];
$consts = $params['consts'];
$status = $params['status'];
$action = $params['action'];

if ($status != $consts['newRequest']) {

	if ($params['status'] == 'successful')
	{
		if ($params['submit'] == $params['lang']['SUBMITDONE'])
			$displayForm = false;
	}
	else
	{
		if ($params['status'] == 'errors')
		{
			$errors = $params['displayMsg'];
			foreach ($errors as $key => $value)
				$errs[$key] = $value;   
		}

		if (isset($errs['exists']))
			echo $errs['exists'];
	}
}

	$c = isset($params['contactData']) ? $params['contactData'] : array();
	$fn = isset($c['firstname']) ?  $c['firstname'] : '';
	$ln = isset($c['lastname']) ?  $c['lastname'] : '';
	$ph1 = isset($c['phone1']) ?  $c['phone1'] : '';
	$ph1t = isset($c['phone1type']) ?  $c['phone1type'] : '';
	$ph2 = isset($c['phone2']) ?  $c['phone2'] : '';
	$ph2t = isset($c['phone2type']) ?  $c['phone2type'] : '';
	$ph3 = isset($c['phone3']) ?  $c['phone3'] : '';
	$ph3t = isset($c['phone3type']) ?  $c['phone3type'] : '';

\Lib\session::delete('params');

if ($displayForm)
{

?>

<html>
<head>
<meta charset="UTF-8">
<title>Add Contact</title>
<link rel="stylesheet" href="<?php echo URI; ?>/public/css/default.css" type="text/css" />
</head>

<body>
<form action="addContact" method="post" name="addContact" id="addContact">
  <fieldset>
    <legend>Contact</legend>
    <p>
      <label for="firstname">First Name</label>
      <input name="firstname" type="text" id="firstname" size="20" maxlength="20" value="<?php echo $fn ?>">
			<?php if (isset($errs['firstname'])) { ?>
				<span class="formfielderror"><?php echo $errs['firstname'] ?></span>
			<?php } ?>
		</p>
    <p>
      <label for="lastname">Last Name</label>
      <input name="lastname" type="text" id="lastname" size="20" maxlength="20" value="<?php echo $ln ?>">
			<?php if (isset($errs['lastname'])) { ?>
				<span class="formfielderror"><?php echo $errs['lastname'] ?></span>
			<?php } ?>
		</p>
		<fieldset>
			<legend>Phone 1:</legend>
				<p>
					<label>Phone Type: </label>
					<label>  
						<input type="radio" name="phone1type" value="1" id="phonetype_0" <?php echo ($ph1t=='1')?'checked':'' ?> >
						Cell</label>
					<label>
						<input type="radio" name="phone1type" value="2" id="phonetype_1" <?php echo ($ph1t=='2')?'checked':'' ?> >
						Home</label>
					<label>
						<input type="radio" name="phone1type" value="3" id="phonetype_2" <?php echo ($ph1t=='3')?'checked':'' ?> >
						Work</label>
					<label>
						<input type="radio" name="phone1type" value="4" id="phonetype_3" <?php echo ($ph1t=='4')?'checked':'' ?> >
						Pager</label>
					<label>
						<input type="radio" name="phone1type" value="5" id="phonetype_4" <?php echo ($ph1t=='5')?'checked':'' ?> >
						Other</label>
					<?php if (isset($errs['phone1type'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone1type'] ?></span>
					<?php } ?>
					<br>
				</p>
				<p>	
					<label for="phone1">Phone Number: (xxx-xxx-xxxx) </label>
					<input name="phone1" type="text" id="phone1" size="13" maxlength="12" value="<?php echo $ph1 ?>">
					<?php if (isset($errs['phone1'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone1'] ?></span>
					<?php } ?>
				</p>
		</fieldset>
		<fieldset>
			<legend>Phone 2:</legend>
				<p>
					<label>Phone Type: </label>
					<label>
						<input type="radio" name="phone2type" value="1" id="phonetype_0" <?php echo ($ph2t=='1')?'checked':'' ?> >
						Cell</label>
					<label>
						<input type="radio" name="phone2type" value="2" id="phonetype_1" <?php echo ($ph2t=='2')?'checked':'' ?> >
						Home</label>
					<label>
						<input type="radio" name="phone2type" value="3" id="phonetype_2" <?php echo ($ph2t=='3')?'checked':'' ?> >
						Work</label>
					<label>
						<input type="radio" name="phone2type" value="4" id="phonetype_3" <?php echo ($ph2t=='4')?'checked':'' ?> >
						Pager</label>
					<label>
						<input type="radio" name="phone2type" value="5" id="phonetype_4" <?php echo ($ph2t=='5')?'checked':'' ?> >
						Other</label>
					<?php if (isset($errs['phone2type'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone2type'] ?></span>
					<?php } ?>
					<br>
    		</p>
				<p>
					<label for="phone2">Phone Number: (xxx-xxx-xxxx) </label>
					<input name="phone2" type="text" id="phone2" size="13" maxlength="12" value="<?php echo $ph2 ?>">
					<?php if (isset($errs['phone2'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone2'] ?></span>
					<?php } ?>
				</p>
		</fieldset>
		<fieldset>
			<legend>Phone 3:</legend>
    	<p>
				<label>Phone Type: </label>
				<label>
					<input type="radio" name="phone3type" value="1" id="phonetype_0" <?php echo ($ph3t=='1')?'checked':'' ?> >
					Cell</label>
				<label>
					<input type="radio" name="phone3type" value="2" id="phonetype_1" <?php echo ($ph3t=='2')?'checked':'' ?> >
					Home</label>
				<label>
					<input type="radio" name="phone3type" value="3" id="phonetype_2" <?php echo ($ph3t=='3')?'checked':'' ?> >
					Work</label>
				<label>
					<input type="radio" name="phone3type" value="4" id="phonetype_3" <?php echo ($ph3t=='4')?'checked':'' ?> >
					Pager</label>
				<label>
					<input type="radio" name="phone3type" value="5" id="phonetype_4" <?php echo ($ph3t=='5')?'checked':'' ?> >
					Other</label>
					<?php if (isset($errs['phone3type'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone3type'] ?></span>
					<?php } ?>
				<br>
    	</p>
			<p>
				<label for="phone3">Phone Number: (xxx-xxx-xxxx) </label>
				<input name="phone3" type="text" id="phone3" size="13" maxlength="12" value="<?php echo $ph3 ?>">
					<?php if (isset($errs['phone3'])) { ?>
						<span class="formfielderror"><?php echo $errs['phone3'] ?></span>
					<?php } ?>
			</p>
		</fieldset>
    <p>
		<?php
			if ($action == 'add')
			{
		?>
      <input type="submit" name="submit" id="submit_addmore" value="<?php echo $lang['SUBMITADD'] ?>">
      <input type="submit" name="submit" id="submit_nomore" value="<?php echo $lang['SUBMITDONE'] ?>">
		<?php
			}
			else 
			{
		?>
      <input type="submit" name="submit" id="submit_update" value="<?php echo $lang['SUBMITUPDATE'] ?>">
		<?php
			}
		?>
    </p>
  </fieldset>

</form>

</body>
</html>

<?php
	}
?>