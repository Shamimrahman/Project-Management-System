<?php
include '../../config/db_connect.php';
$qry = $conn->query("SELECT * FROM users where Id = ".$_GET['Id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'user.php';
?>