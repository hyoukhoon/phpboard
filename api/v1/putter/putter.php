<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

header('Content-Type: text/html; charset=utf-8');

$headers = apache_request_headers();

$apikey = $headers['x-apikey'];//apikey 확인

$xapikey = hash('sha512', date("Ymd"));//상대방과 어떤 apikey를 사용할지 정해서 결정.

if($apikey==$xapikey){//apikey가 맞으면

    $jsonData = file_get_contents('php://input');//외부에서 보내온 json 데이터
    $arrayData = json_decode($jsonData, true);//array로 디코드
    $cnt=0;
    foreach($arrayData as $ds){
        $query="select pid, name, cate, content, thumbnail, price, sale_price, sale_ratio, cnt, sale_cnt, isnew, isbest, isrecom, ismain, locate, sale_end_date, status, delivery_fee from products where status=1 and cate like '%".$ds['cate']."%'";
        $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
        while($rs = $result->fetch_object()){
            
            //추가이미지를 불러와서 추가
            $pimg = array();
            $query2="select filename from product_image_table where status=1 and pid=".$rs->pid." order by imgid asc";
            $result2 = $mysqli->query($query2) or die("query error => ".$mysqli->error);
            while($rs2 = $result2->fetch_object()){
                $pimg[] = $rs2->filename;
            }
            $rs->product_images = $pimg;

            //옵션을 불러와서 추가
            $opts = array();
            $query3="select poid, cate, option_name, option_cnt, option_price, image_url from product_options where status=1 and pid=".$rs->pid." order by poid asc";
            $result3 = $mysqli->query($query3) or die("query error => ".$mysqli->error);
            while($rs3 = $result3->fetch_object()){
                $opts[] = $rs3;
            }
            $rs->product_options = $opts;

            //wms(재고)를 불러와서 추가
            $cnts = array();
            $query4="select wcode,cnt from wms where status=1 and pid=".$rs->pid." order by wid asc";
            $result4 = $mysqli->query($query4) or die("query error => ".$mysqli->error);
            while($rs4 = $result4->fetch_object()){
                $cnts[] = $rs4;
            }
            $rs->wms = $cnts;

            $returnArray[]=$rs;
            $cnt++;
        }
    }

    $result=array("success" => "true"
                , "code" => "200"
                , "message" => "OK"
                , "data" => $returnArray
                , "count" => $cnt
                );

}else{

    $result=array("success" => "true"
              , "code" => "401"
              , "message" => "Unauthorized"
              , "data" => array ()
              , "count" => 0
              );

}

echo stripslashes(json_encode($result, JSON_UNESCAPED_UNICODE));
?>