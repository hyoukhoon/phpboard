<?php
//   error_reporting(E_ALL);
//   ini_set("display_errors", 1);

    $apiKey = hash('sha512', date("Ymd"));
    $url = "http://localhost:8008/api/v1/putter/putter.php";

    $postdata = '[
        {
            "name":"API 테스트상품"
            ,"cate":"A0001B0001C0001"
            ,"content":"테스트상품"
            ,"thumbnail":"http://localhost:8008/pdata/20220329030809178595.jpeg"
            ,"price":"5000000"
            ,"sale_price":"3000000"
            ,"sale_ratio":"0"
            ,"cnt":"0"
            ,"sale_cnt":"0"
            ,"isnew":"1"
            ,"isbest":"0"
            ,"isrecom":"0"
            ,"ismain":"0"
            ,"locate":"0"
            ,"sale_end_date":"2022-09-29 00:00:00"
            ,"status":"1"
            ,"delivery_fee":"0"
            ,"product_images":[
                "http://localhost:8008/pdata/20220329030800919193.jpg"
                ,"http://localhost:8008/pdata/20220329030800191315.jpg"
                ,"http://localhost:8008/pdata/20220329030800779496.jpeg"
                ,"http://localhost:8008/pdata/20220329030800188108.gif"
            ]
            ,"product_options":[]
            ,"wms":[
                    {
                        "wcode":""
                        ,"cnt":"100"
                    }
                ]
            },
        {
            "name":"API 옵션많은노트북"
            ,"cate":"A0001B0001C0001"
            ,"content":"옵션많은노트북"
            ,"thumbnail":"http://localhost:8008/pdata/20220329030809178595.jpeg"
            ,"price":"2000000"
            ,"sale_price":"1500000"
            ,"sale_ratio":"0"
            ,"cnt":"100"
            ,"sale_cnt":0
            ,"isnew":"1"
            ,"isbest":"0"
            ,"isrecom":"1"
            ,"ismain":"0"
            ,"locate":"1"
            ,"sale_end_date":"2022-09-20 00:00:00"
            ,"status":"1"
            ,"delivery_fee":"0"
            ,"product_images":[]
            ,"product_options":[
                {"poid":"51","cate":"컬러","option_name":"블루","option_price":"0","image_url":"http://localhost:8008/pdata/20220329031038408140.jpg"}
                ,{"poid":"52","cate":"컬러","option_name":"레드","option_price":"0","image_url":"http://localhost:8008/pdata/20220329030809178595.jpeg"}
                ,{"poid":"53","cate":"사이즈","option_name":"대형","option_price":"500000","image_url":null}
                ,{"poid":"54","cate":"사이즈","option_name":"소형","option_price":"0","image_url":null}
            ]
            ,"wms":[
                {"wcode":"51_53","cnt":"200"}
                ,{"wcode":"51_54","cnt":"150"}
                ,{"wcode":"52_53","cnt":"100"}
                ,{"wcode":"52_54","cnt":"50"}
            ]
        },
        {"name":"Api오디오앰프","cate":"A0001B0001C0001","content":"오디오앰프","thumbnail":"http://localhost:8008/pdata/20220329031038408140.jpg","price":"3000000","sale_price":"2000000","sale_ratio":"0","cnt":"0","sale_cnt":"0","isnew":"1","isbest":"0","isrecom":"0","ismain":"0","locate":"0","sale_end_date":"2022-09-29 00:00:00","status":"1","delivery_fee":"0","product_images":["http://localhost:8008/pdata/20220329031017292182.jpg","http://localhost:8008/pdata/20220329031017210883.jpeg"],"product_options":[{"poid":"29","cate":"컬러","option_name":"블루","option_cnt":null,"option_price":"0","image_url":"http://localhost:8008/pdata/optiondata/20220329031038737067.jpg"},{"poid":"30","cate":"컬러","option_name":"블랙","option_cnt":null,"option_price":"0","image_url":"http://localhost:8008/pdata/optiondata/20220329031038104695.gif"}],"wms":[{"wcode":"29","cnt":"100"},{"wcode":"30","cnt":"100"}]}
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
    echo $output;
    $rs=json_decode($output);
    curl_close($ch);  // 리소스 해제

    echo "<pre>";
    print_r($rs);

    
?>