<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";
if(!$_SESSION['AUID']){
  echo "<script>alert('권한이 없습니다.');history.back();</script>";
  exit;
}

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??10;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'];
$search_keyword=$_GET["search_keyword"];

if($search_keyword){
    $search_where.=" and (coupon_name like '%".$search_keyword."%')";//like 검색으로 검색
}

$sql = "select * from coupons c where 1=1";
$sql .= $search_where;
$order = " order by cid desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;
//echo "query=>".$query."<br>";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
    $rsc[]=$rs;
}

//전체게시물 수 구하기
$sqlcnt = "select count(*) as cnt from coupons where 1=1";
$sqlcnt .= $search_where;
$countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

if($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;



?>
<div style="text-align:center;"><h3>쿠폰 리스트</h3></div>

    <form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">
        
        <div class="input-group mb-4">
            <input class="form-control me-2" type="search"  name="search_keyword" id="search_keyword" placeholder="제목에서 검색합니다." aria-label="Search" value="<?php echo $search_keyword;?>">
            <button class="btn btn-outline-dark" type="submit">Search</button>
        </div>
        
		</form>
       
        <table class="table table-sm table-bordered">
          <thead>
          <tr style="text-align:center;">
            <th scope="col">사진</th>
            <th scope="col">쿠폰명</th>
            <th scope="col">쿠폰타입</th>
            <th scope="col">할인가</th>
            <th scope="col">할인율</th>
            <th scope="col">최소사용금액</th>
            <th scope="col">최대할인금액</th>
            <th scope="col">등록자</th>
            <th scope="col">상태</th>
          </tr>
          </thead>
          <tbody>
          <?php 
				foreach($rsc as $r){
  			?>
          <tr>
            <th scope="row" style="width:200px;"><img src="<?php echo $r->coupon_image;?>" style="max-width:100px;"></th>
            <td><?php echo $r->coupon_name;?></td>
            <td><?php echo $r->coupon_type;?></td>
            <td style="text-align:right;"><?php echo number_format($r->coupon_price);?>원</td>
            <td style="text-align:right;"><?php echo number_format($r->coupon_ratio);?>%</td>
            <td style="text-align:right;"><?php echo number_format($r->use_min_price);?>원</td>
            <td style="text-align:right;"><?php echo number_format($r->max_value);?>원</td>
            <td><?php echo $r->userid;?></td>
            <td><?php echo $r->status;?></td>
          </tr>
          <?php }?>
          </tbody>
        </table>

        <a href="coupon_up.php">
            <button class="btn btn-primary" type="button">쿠폰등록</button>
        </a>
        
        <!-- Modal -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">        
<script>
    $(function(){
        $("#sale_end_date").datepicker({ dateFormat: 'yy-mm-dd' });
    });

      
</script>
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
