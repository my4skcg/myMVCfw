<?php namespace Views;?>
<?php
if (\Lib\session::get('displayMsg'))
{
	echo \Lib\session::get('displayMsg');
	\Lib\session::delete('displayMsg');
	echo "</br>";
}
?>


<html>

	This is the main page welcome!
