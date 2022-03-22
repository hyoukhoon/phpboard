<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

$poid = $_POST['poid'];

$query="select * from product_options where poid='".$poid."'";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();
$image_url = $rs->image_url;
$option_price = $rs->option_price;

$data = array("image_url"=>$image_url,"option_price"=>$option_price);
echo json_encode($data);

?>