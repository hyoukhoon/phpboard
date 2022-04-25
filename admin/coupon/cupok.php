<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}


$coupon_name=$_POST["coupon_name"];//쿠폰명
$coupon_type=$_POST["coupon_type"];//쿠폰타입
$coupon_price=$_POST["coupon_price"];//할인가
$coupon_ratio=$_POST["coupon_ratio"];//할인율
$status=$_POST["status"];//상태
$max_value=$_POST["max_value"];//최대할인금액
$use_min_price=$_POST["use_min_price"];//최소사용가능금액

if($_FILES["coupon_image"]["name"]){//첨부한 파일이 있으면

        if($_FILES['coupon_image']['size']>10240000){//10메가
            echo "<script>alert('10메가 이하만 첨부할 수 있습니다.');history.back();</script>";
            exit;
        }

        if($_FILES['coupon_image']['type']!='image/jpeg' and $_FILES['coupon_image']['type']!='image/gif' and $_FILES['coupon_image']['type']!='image/png'){//이미지가 아니면, 다른 type은 and로 추가
            echo "<script>alert('이미지만 첨부할 수 있습니다.');history.back();</script>";
            exit;
        }

        $save_dir = $_SERVER['DOCUMENT_ROOT']."/pdata/";//파일을 업로드할 디렉토리
        $filename = $_FILES["coupon_image"]["name"];
        $ext = pathinfo($filename,PATHINFO_EXTENSION);//확장자 구하기
        $newfilename = "CPN_".date("YmdHis").substr(rand(),0,6);
        $coupon_image = $newfilename.".".$ext;//새로운 파일이름과 확장자를 합친다
        
        if(move_uploaded_file($_FILES["coupon_image"]["tmp_name"], $save_dir.$coupon_image)){
            $coupon_image = $_CONFIG["CDN_SERVER"]."/pdata/".$coupon_image;
        }else{
            echo "<script>alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주십시오.');history.back();</script>";
            exit;
        }

}

$mysqli->autocommit(FALSE);//커밋이 안되도록 지정

try {

    $query="INSERT INTO testdb.coupons
    (coupon_name, coupon_image, coupon_type, coupon_price, coupon_ratio, status, regdate, userid, max_value, use_min_price)
    VALUES('".$coupon_name."'
    , '".$coupon_image."'
    , '".$coupon_type."'
    , '".$coupon_price."'
    , '".$coupon_ratio."'
    , '".$status."'
    , now()
    , '".$_SESSION['AUID']."'
    , '".$max_value."'
    , '".$use_min_price."'
    )";

    $rs=$mysqli->query($query) or die($mysqli->error);
    $pid = $mysqli -> insert_id;

    $mysqli->commit();//디비에 커밋한다.

    echo "<script>alert('등록했습니다.');location.href='/admin/coupon/coupon_list.php';</script>";
    exit;

}catch (Exception $e) {

    $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.

    echo "<script>alert('등록하지 못했습니다. 관리자에게 문의해주십시오.');history.back();</script>";
    exit;

}


?>