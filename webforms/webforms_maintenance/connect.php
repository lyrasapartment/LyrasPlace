<?php
require_once('../../../includes/unused/dbstuff.inc');
$con = mysqli_connect(DBHOST,DBUSER,DBPASS,DB);
if (!$con) {
die(mysqli_error());
}
?>