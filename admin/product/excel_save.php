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

$filename = $_FILES['efile']['tmp_name'];//업로드한 파일

$spreadsheet = IOFactory::load($filename);//읽기

$Rows = $spreadsheet->getActiveSheet()->toArray();//모든 row를 가져오기
$maxrows=count($Rows);//최대로우 구하기

echo "<pre>";
print_r($Rows);

$mysqli->autocommit(FALSE);//커밋이 안되도록 지정
try {

    for($i=1;$i<$maxrows;$i++){//첫줄은 제목이니까 1부터 시작
        
        if($Rows[$i][0] and $Rows[$i][1]and $Rows[$i][2]){//필수값에 값이 있는 제품만 등록, 다하면 더 좋겠지만 여기까지만
            $query="INSERT INTO products
                (name
                , cate
                , content
                , thumbnail
                , price
                , sale_price
                , sale_ratio
                , cnt
                , isnew
                , isbest
                , isrecom
                , ismain
                , locate
                , userid
                , sale_end_date
                , reg_date
                , delivery_fee)
                VALUES ('".$Rows[$i][0]."'
                , '".$Rows[$i][1]."'
                , '".$Rows[$i][2]."'
                , '".$Rows[$i][3]."'
                , ".$Rows[$i][4]."
                , ".$Rows[$i][5]."
                , ".$Rows[$i][6]."
                , ".$Rows[$i][7]."
                , ".$Rows[$i][8]."
                , ".$Rows[$i][9]."
                , ".$Rows[$i][10]."
                , ".$Rows[$i][11]."
                , ".$Rows[$i][12]."
                , '".$_SESSION['AUID']."'
                , '".date("Y-m-d",strtotime($Rows[$i][13]))."'
                , now()
                , ".$Rows[$i][14].")";
            $rs=$mysqli->query($query) or die($mysqli->error);
            $pid = $mysqli -> insert_id;

            $opt1Array = explode(",",$Rows[$i][16]);//옵션분류1
            $opt1PriceArray = explode(",",$Rows[$i][18]);//가격
            $opt1ImageArray = explode(",",$Rows[$i][19]);//사진

            $opt2Array = explode(",",$Rows[$i][17]);//옵션분류2
            $opt2PriceArray = explode(",",$Rows[$i][20]);//가격

            $optCntArray = explode(",",$Rows[$i][21]);//전체 재고

            if($opt1Array){
                for($k=0;$k<count($opt1Array);$k++){
                    $optQuery="INSERT INTO product_options
                    (pid, cate, option_name, option_price, image_url) 
                    VALUES (".$pid.", '컬러', '".$opt1Array[$k]."', ".$opt1PriceArray[$k].", '".$opt1ImageArray[$k]."')";
                    $ofs=$mysqli->query($optQuery) or die($mysqli->error);
                    $poid=$mysqli->insert_id;
                    $op1[]=$poid;
                }
            }

            if($opt2Array){
                for($k=0;$k<count($opt2Array);$k++){
                    $optQuery="INSERT INTO product_options
                    (pid, cate, option_name, option_price) 
                    VALUES (".$pid.", '사이즈', '".$opt2Array[$k]."', ".$opt2PriceArray[$k].")";
                    $ofs=$mysqli->query($optQuery) or die($mysqli->error);
                    $poid=$mysqli->insert_id;
                    $op2[]=$poid;
                }
            }

            //재고입력
            $j=0;
            if($op1 and $op2){
                foreach($op1 as $c1){
                    foreach($op2 as $c2){
                        $wcode=$c1."_".$c2;
                        $wmsQuery="INSERT INTO testdb.wms 
                        (pid, wcode, cnt)
                        VALUES (".$pid.",'".$wcode."',".$optCntArray[$j].")";
                        $mysqli->query($wmsQuery) or die($mysqli->error);
                        $j++;
                    }
                }
            }else if($op1 and !$op2){
                foreach($op1 as $c1){
                    $wcode=$c1;
                    $wmsQuery="INSERT INTO testdb.wms 
                    (pid, wcode, cnt)
                    VALUES (".$pid.",'".$wcode."',".$opt1CntArray[$j].")";
                    $mysqli->query($wmsQuery) or die($mysqli->error);
                    $j++;
                }
            }else if(!$op1 and $op2){
                foreach($op2 as $c2){
                    $wcode=$c2;
                    $wmsQuery="INSERT INTO testdb.wms 
                    (pid, wcode, cnt)
                    VALUES (".$pid.",'".$wcode."',".$opt1CntArray[$j].")";
                    $mysqli->query($wmsQuery) or die($mysqli->error);
                    $j++;
                }
            }else if(!$op1 && !$op2){
                $cnt = $Rows[$i][7];//재고
                $wmsQuery="INSERT INTO wms 
                (pid, wcode, cnt)
                VALUES (".$pid.",'".$wcode."',".$cnt.")";
                $mysqli->query($wmsQuery) or die($mysqli->error);
            }
        }
    }
 
    $mysqli->commit();//디비에 커밋한다.

    echo "<script>alert('등록했습니다.');location.href='/admin/product/product_list.php';</script>";
    exit;

} catch (exception $e) {
    $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
    echo "<script>alert('등록하지 못했습니다. 관리자에게 문의해주십시오.');history.back();</script>";
    exit;
}

?>
		