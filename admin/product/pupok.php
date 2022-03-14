<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}


$cate=$_POST["cate1"].$_POST["cate1"].$_POST["cate1"];//대중소분류를 모두 저장한다.
$name=$_POST["name"];//제품명
$contents=rawurldecode($_POST['contents']);//제품 설명
$ismain=$_POST["ismain"];//메인
$isnew=$_POST["isnew"];//신상품
$isbest=$_POST["isbest"];//베스트
$isrecom=$_POST["isrecom"];//추천
$locate=$_POST["locate"];//위치
$sale_end_date=$_POST["sale_end_date"];//판매종료일
$file_table_id=$_POST["file_table_id"];//이미지
$file_table_id=rtrim($file_table_id,",");//오른쪽 끝에 , 삭제

if($_FILES["thumbnail"]["name"]){//첨부한 파일이 있으면

        if($_FILES['thumbnail']['size']>10240000){//10메가
            echo "<script>alert('10메가 이하만 첨부할 수 있습니다.');history.back();</script>";
            exit;
        }

        if($_FILES['thumbnail']['type']!='image/jpeg' and $_FILES['thumbnail']['type']!='image/gif' and $_FILES['thumbnail']['type']!='image/png'){//이미지가 아니면, 다른 type은 and로 추가
            echo "<script>alert('이미지만 첨부할 수 있습니다.');history.back();</script>";
            exit;
        }

        $save_dir = $_SERVER['DOCUMENT_ROOT']."/pdata/";//파일을 업로드할 디렉토리
        $filename = $_FILES["thumbnail"]["name"];
        $ext = pathinfo($filename,PATHINFO_EXTENSION);//확장자 구하기
        $newfilename = date("YmdHis").substr(rand(),0,6);
        $thumbnail = $newfilename.".".$ext;//새로운 파일이름과 확장자를 합친다
        
        if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $save_dir.$thumbnail)){
            $thumbnail = "http://localhost:8008/pdata/".$thumbnail;
        }else{
            echo "<script>alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주십시오.');history.back();</script>";
            exit;
        }

}

$sale_cnt = 0;//판매량
$query="INSERT INTO products
(name, cate, content, thumbnail, price, sale_price, sale_ratio, cnt, sale_cnt, isnew, isbest, isrecom, ismain, locate, userid, sale_end_date, reg_date)
VALUES('$name'
, '".$cate."'
, '".$contents."'
, '".$thumbnail."'
, '".$price."'
, '".$sale_price."'
, '".$sale_ratio."'
, ".$cnt."
, ".$sale_cnt."
, '".$isnew."'
, '".$isbest."'
, '".$isrecom."'
, '".$ismain."'
, '".$locate."'
, '".$_SESSION['AUID']."'
, '".$sale_end_date."'
, now())";



$rs=$mysqli->query($query) or die($mysqli->error);
$pid = $mysqli -> insert_id;
if($rs){

    $upquery="update product_image_table set pid=".$pid." where imgid in (".$file_table_id.")";
    $fs=$mysqli->query($upquery) or die($mysqli->error);
    echo "<script>alert('등록했습니다.');location.href='/admin/product/product_list.php';</script>";
    exit;

}else{
    echo "<script>alert('등록하지 못했습니다. 관리자에게 문의해주십시오.');history.back();</script>";
    exit;
}


?>