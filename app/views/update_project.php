<?php
include '../../config/db_connect.php';
$qry = $conn->query("SELECT * FROM project where Id = ".$_GET['Id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'project.php';
?>