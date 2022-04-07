<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel-1.8/Classes/PHPExcel.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
ini_set( 'display_errors', '0' );

if(!$_SESSION['AUID']){
    $retun_data = array("result"=>"member");
    echo json_encode($retun_data);
    exit;
}

$objPHPExcel = new PHPExcel();
$allData = array();

$filename = iconv("UTF-8", "EUC-KR", $_FILES['efile']['name']);

if($_FILES['efile']['size']>10240000){//10메가
    $retun_data = array("result"=>"size");
    echo json_encode($retun_data);
    exit;
}


try {

    $objPHPExcel = PHPExcel_IOFactory::load($filename);
	$sheetsCount = $objPHPExcel -> getSheetCount();

    $objPHPExcel -> setActiveSheetIndex(0);
    $sheet = $objPHPExcel -> getActiveSheet();
    $highestRow = $sheet -> getHighestRow();// 마지막 행
    $highestColumn = $sheet -> getHighestColumn();// 마지막 컬럼


    for ($i = 0 ; $i <= $highestRow ; $i++) {

        $rowData = $sheet -> rangeToArray("A" . $i . ":" . $highestColumn . $i, NULL, TRUE, FALSE);
        $allData[$i] = $rowData[0];

            //    $a = $objWorksheet->getCell('A' . $i)->getValue(); 
            //    $b = $objWorksheet->getCell('B' . $i)->getValue(); 
            //    $c = $objWorksheet->getCell('C' . $i)->getValue(); 
            //    $d = $objWorksheet->getCell('D' . $i)->getValue(); 
            //    $e = $objWorksheet->getCell('E' . $i)->getValue(); 
            //    $f = $objWorksheet->getCell('F' . $i)->getValue(); 
            //    $g = $objWorksheet->getCell('G' . $i)->getValue();
            //    $h = $objWorksheet->getCell('H' . $i)->getValue();
            //    $i = $objWorksheet->getCell('I' . $i)->getValue();
            //    $j = $objWorksheet->getCell('J' . $i)->getValue();
            //    $k = $objWorksheet->getCell('K' . $i)->getValue();
            //    $l = $objWorksheet->getCell('L' . $i)->getValue();
            //    $m = $objWorksheet->getCell('M' . $i)->getValue();
            //    $n = $objWorksheet->getCell('N' . $i)->getValue(); 
            //    $n = PHPExcel_Style_NumberFormat::toFormattedString($n, 'YYYY-MM-DD');
            //    $o = $objWorksheet->getCell('O' . $i)->getValue();
            //    $p = $objWorksheet->getCell('P' . $i)->getValue(); 
            //    $q = $objWorksheet->getCell('Q' . $i)->getValue(); 
            //    $r = $objWorksheet->getCell('R' . $i)->getValue(); 
            //    $s = $objWorksheet->getCell('S' . $i)->getValue(); 
            //    $t = $objWorksheet->getCell('T' . $i)->getValue(); 
            //    $u = $objWorksheet->getCell('U' . $i)->getValue(); 

            //    echo "A=>".$a."<br>";
            //    echo "B=>".$b."<br>";
            //    echo "C=>".$c."<br>";
            //    echo "D=>".$d."<br>";
            //    echo "E=>".$e."<br>";
            //    echo "F=>".$f."<br>";
            //    echo "G=>".$g."<br>";
            //    echo "H=>".$h."<br>";
            //    echo "I=>".$i."<br>";
            //    echo "J=>".$j."<br>";
            //    echo "K=>".$k."<br>";
            //    echo "L=>".$l."<br>";
            //    echo "M=>".$m."<br>";
            //    echo "N=>".$n."<br>";
            //    echo "O=>".$o."<br>";
            //    echo "P=>".$p."<br>";
            //    echo "Q=>".$q."<br>";
            //    echo "R=>".$r."<br>";
            //    echo "S=>".$s."<br>";
            //    echo "T=>".$t."<br>";
            //    echo "U=>".$u."<br>";

    }
 

} catch (exception $e) {
    echo '엑셀파일을 읽는도중 오류가 발생하였습니다.!';
}

echo "<pre>";
print_r($allData);
echo "</pre>";


exit;
?>
		