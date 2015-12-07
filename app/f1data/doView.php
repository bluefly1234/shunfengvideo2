<?php
include_once "config_data.php";
include_once "api_data.php";

$id=0;
if (isset($_GET['id']) ){
	$id=intval($_GET['id']);
}

$sql = "update access set screen='".$_GET['screen']."' where id=$id;";
//echo $sql;
DATA_ExecSql($sql);

echo ("var svrRet=0;");
?>
