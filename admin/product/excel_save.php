<?php session_start();
ini_set( 'display_errors', '0' );
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
require_once($_SERVER["DOCUMENT_ROOT"].'/lib/PhpOffice/Psr/autoloader.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/lib/PhpOffice/PhpSpreadsheet/autoloader.php');
use PhpOffice\PhpSpreadsheet\IOFactory; 



if(!$_SESSION['AUID']){
    $retun_data = array("result"=>"member");
    echo json_encode($retun_data);
    exit;
}

if($_FILES['efile']['size']>10240000){//10메가
    $retun_data = array("result"=>"size");
    echo json_encode($retun_data);
    exit;
}

$filename = $_FILES['efile']['name'];
$filepath = $_FILES['efile']['tmp_name'];

$spreadsheet = IOFactory::load($filename);


$Rows = $spreadsheet->getActiveSheet()->toArray();
echo "갯수".count($Rows);
echo "<pre>";
print_r($Rows);

try {

    foreach($Rows as $r){
        for($i=0;$i<21;$i++){
            echo $r[$i]."<br>";
        }
    }
 
    // $sql="INSERT INTO products
    // (name, cate, content, thumbnail, price, sale_price, sale_ratio, cnt, sale_cnt, isnew, isbest, isrecom, ismain, locate, userid, sale_end_date, reg_date, status, delivery_fee)
    // VALUES ('', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL)";

} catch (exception $e) {
    echo '엑셀파일을 읽는도중 오류가 발생하였습니다.!';
}

exit;
?>
		