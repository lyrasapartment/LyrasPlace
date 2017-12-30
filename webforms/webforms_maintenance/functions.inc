<?php

//generic file for generic
//functions and other includes
if (session_id() == "") {
session_start();
}

if (is_file('../../../includes/unused/dbstuff.inc')){
    require_once('../../../includes/unused/dbstuff.inc');
}

require_once("../../../includes/validation.php");
require_once("../../../includes/ClassUser.php");
?>