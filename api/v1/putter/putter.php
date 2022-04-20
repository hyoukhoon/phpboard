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

        $sale_cnt = 0;//판매량
        $query="INSERT INTO products
        (name, cate, content, thumbnail, price, sale_price, sale_ratio, cnt, sale_cnt, isnew, isbest, isrecom, ismain, locate, userid, sale_end_date, reg_date, delivery_fee)
        VALUES('".$ds['name']."'
        , '".$ds['cate']."'
        , '".$ds['content']."'
        , '".$ds['thumbnail']."'
        , '".$ds['price']."'
        , '".$ds['sale_price']."'
        , '".$ds['sale_ratio']."'
        , ".$ds['cnt']."
        , ".$ds['sale_cnt']."
        , '".$ds['isnew']."'
        , '".$ds['isbest']."'
        , '".$ds['isrecom']."'
        , '".$ds['ismain']."'
        , '".$ds['locate']."'
        , 'API'
        , '".$ds['sale_end_date']."'
        , now()
        , '".$ds['delivery_fee']."'
        )";

        $rs=$mysqli->query($query) or die($mysqli->error);
        $pid = $mysqli -> insert_id;

        if(count($ds['product_images'])>0){
            foreach($ds['product_images'] as $p){
                $insquery="INSERT INTO product_image_table
                (pid, userid, filename) VALUES(".$pid.", 'api', '".$p."')";
                $fs=$mysqli->query($insquery) or die($mysqli->error);
            }
        }

        //옵션부분
        $ws = array();
        if(count($ds['product_options'])>0){
            foreach($ds['product_options'] as $s){
                $insquery="INSERT INTO product_options
                (pid, cate, option_name, option_price, image_url, status)
                VALUES(".$pid.", '".$s['cate']."', '".$s['option_name']."', '".$s['option_price']."', '".$s['image_url']."', 1)";
                $fs=$mysqli->query($insquery) or die($mysqli->error);
                $poid = $mysqli -> insert_id;
                if($s['poid']){
                    $ws[$s['poid']] = $poid;
                }
            }
        }

        //wms
        if(count($ds['wms'])>0){
            foreach($ds['wms'] as $w){
                if($w['wcode']){
                    $code = explode("_",$w['wcode']);
                    $xcode = $ws[$code[0]];
                    if($code[1])$xcode.="_".$ws[$code[1]];
                }else{
                    $xcode = '';
                }
                $insquery="INSERT INTO wms
                (pid, wcode, cnt)
                VALUES(".$pid.", '".$xcode."', ".$w['cnt'].")";
                $fs=$mysqli->query($insquery) or die($mysqli->error);
            }
        }

        
        

        $cnt++;
        
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