<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}


$catge=$_POST["cate1"].$_POST["cate1"].$_POST["cate1"];//대중소분류를 모두 저장한다.
$name=$_POST["name"];//제품명
$contents=rawurldecode($_POST['contents']);//제품 설명
$ismain=$_POST["ismain"];//메인
$isnew=$_POST["isnew"];//신상품
$isbest=$_POST["isbest"];//베스트
$isrecom=$_POST["isrecom"];//추천
$locate=$_POST["locate"];//위치
$sale_end_date=$_POST["sale_end_date"];//판매종료일
$thumbnail=$_FILES["thumbnail"];//썸네임
$file_table_id=$_POST["file_table_id"];//이미지

$query="INSERT INTO products
(name, cate, content, thumbnail, price, sale_price, sale_ratio, cnt, sale_cnt, isnew, isbest, isrecom, ismain, locate, userid, sale_end_date, reg_date)
VALUES('$name'
, '".$cate."'
, '".$content."'
, '".$thumbnail."'
, '".$price."'
, '".$sale_price."'
, '".$sale_ratio."'
, '".$cnt."'
, '".$sale_cnt."'
, '".$isnew."'
, '".$isbest."'
, '".$isrecom."'
, '".$ismain."'
, '".$locate."'
, '".$userid."'
, '".$sale_end_date."'
, now())";

echo $query;
exit;
//$rs=$mysqli->query($query) or die($mysqli->error);

if($rs){
    
    echo "<script>alert('등록했습니다.');location.href='/admin/product/product_list.php';</script>";
    exit;

}else{
    echo "<script>alert('등록하지 못했습니다. 관리자에게 문의해주십시오.');history.back();</script>";
    exit;
}


?>