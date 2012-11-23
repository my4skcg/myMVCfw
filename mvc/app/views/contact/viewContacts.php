<?php
$params = \Lib\session::get('params');

\Lib\session::delete('params');

?>

<html>
<head>
<meta charset="UTF-8">
<title>Contacts</title>
<link rel="stylesheet" href="<?php echo URI; ?>/public/css/default.css" type="text/css" />
</head>

<body>
<form action="viewContacts" method="post" name="viewContacts" id="viewContacts">
</form>

</body>
</html>

