<?php

//generic file for generic
//functions and other includes

session_start();

if (is_file('../includes/unused/dbstuff.inc')){
    require_once('../includes/unused/dbstuff.inc');
}
else if (is_file('D:/dbstuff/dbstuff.inc')) {
	require_once('D:/dbstuff/dbstuff.inc');
}
require_once("validation.php");
require_once("ClassUser.php");
?>