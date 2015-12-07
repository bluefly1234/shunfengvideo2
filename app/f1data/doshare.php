<?php
include_once "config_data.php";
include_once "api_data.php";
date_default_timezone_set('Asia/Shanghai');
$titleid = $_GET['titleid'];
$uuid = $_GET['uuid'];
$shareid = $_GET['shareid'];
$state = $_GET['state'];

$sql = "insert into share (titleid, uuid, shareid, state, create_tm) values ( $titleid, $uuid, $shareid, $state, ".time()." );";

DATA_ExecSql($sql);

echo ("var svrRet=0;");
?>