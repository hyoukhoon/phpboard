<?php
//   error_reporting(E_ALL);
//   ini_set("display_errors", 1);

    $apiKey = hash('sha512', date("Ymd"));
    $url = "http://localhost:8008/api/v1/getter/getter.php";

    $postdata = '[
        {"cate":"A0001"},
        {"cate":"A0002"}
        ]';

    $ch = curl_init(); // 리소스 초기화
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'x-apikey: '.$apiKey,
      'Content-Type: application/json'
    ));
  
    $output = curl_exec($ch); // 데이터 요청 후 수신
    //echo $output;
    $rs=json_decode($output);
    curl_close($ch);  // 리소스 해제

    echo "<pre>";
    print_r($rs);

    
?>