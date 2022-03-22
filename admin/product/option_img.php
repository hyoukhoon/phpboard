<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

$poid = $_POST['poid'];

$query="select image_url from product_options where poid='".$poid."'";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();
$html = $rs->image_url;
echo $html;

?>