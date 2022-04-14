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
        $query="select * from products where status=1 and cate like '%".$ds['cate']."%'";
        $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
        while($rs = $result->fetch_object()){
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