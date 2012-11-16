<?php

/* 
------------------
Language: English
------------------
*/

$lang = array();

// Error messages
$lang['USERNAMEREQ'] = 'Username is a required field.';
$lang['PWDREQ'] = 'Password is a required field.';
$lang['PWDCONFIRMREQ'] = 'Confirm Password is a required field.';
$lang['EMAILREQ'] = 'Email is a required field.';
$lang['USEREXISTS'] = 'That user name is unavailable.';
$lang['ACCTNOTACT'] = 'Account has not yet been activated.';
$lang['INVALIDUSRPWD'] = 'Invalid Username/Password.';
$lang['PWDCONFIRMNOMATCH'] = 'Password and Confirm Password do not match.';
$lang['EMAILNOTVALID'] = 'Email address is not a valid email.';
$lang['PWDVERIFYFAIL'] = 'Password Verification failed.';

// Status messages
$lang['USERDELETED'] = 'User has been deleted.';
$lang['USERUPDATED'] = 'User has been updated.';
$lang['USERLOGGEDOUT'] = 'You are now logged out.';

include (SITEPATH . 'app/languages/lang.en.php');
?>
