<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

$userid=$_POST["userid"];
$passwd=$_POST["passwd"];
$passwd=hash('sha512',$passwd);

$query = "select * from admins where userid='".$userid."' and passwd='".$passwd."' and end_login_date>now()";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();

if($rs){
    $sql="update admins set last_login=now() where idx=".$rs->idx;
    $result=$mysqli->query($sql) or die($mysqli->error);
    $_SESSION['AUID']= $rs->userid;
    $_SESSION['AUNAME']= $rs->username;
    $_SESSION['ALEVEL']= $rs->level;

    echo "<script>alert('어서오십시오.');location.href='/admin/product/product_list.php';</script>";
    exit;

}else{
    echo "<script>alert('아이디나 암호가 틀렸습니다. 다시한번 확인해주십시오.');history.back();</script>";
    exit;
}


?>