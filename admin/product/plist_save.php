<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}

$pid=$_REQUEST["pid"];
$ismain=$_REQUEST["ismain"];
$isnew=$_REQUEST["isnew"];
$isbest=$_REQUEST["isbest"];
$isrecom=$_REQUEST["isrecom"];
$stat=$_REQUEST["stat"];

foreach($pid as $p){
    echo $ismain[$p]."<br>";
}

?>