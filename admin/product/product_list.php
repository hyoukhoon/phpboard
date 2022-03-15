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


$sql = "select * from products where 1=1";
$sql .= $search_where;
$order = " order by pid desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;
//echo "query=>".$query."<br>";
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
    $rsc[]=$rs;
}

//전체게시물 수 구하기
$sqlcnt = "select count(*) as cnt from products where 1=1";
$sqlcnt .= $search_where;
$countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

if($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;

?>
        <table class="table table-sm table-bordered">
          <thead>
          <tr style="text-align:center;">
            <th scope="col">사진</th>
            <th scope="col">제품명</th>
            <th scope="col">가격</th>
            <th scope="col">재고</th>
            <th scope="col">메인</th>
            <th scope="col">신제품</th>
            <th scope="col">베스트</th>
            <th scope="col">추천</th>
            <th scope="col">상태</th>
          </tr>
          </thead>
          <tbody>
          <?php 
				foreach($rsc as $r){
  			?>
          <tr>
            <th scope="row" style="width:100px;"><img src="<?php echo $r->thumbnail;?>" style="max-width:100px;"></th>
            <td><?php echo $r->name;?></td>
            <td style="text-align:right;"><s><?php echo number_format($r->price);?>원</s><br>
            <?php echo number_format($r->sale_price);?>원
            </td>
            <td style="text-align:right;"><?php echo number_format($r->cnt-$r->sale_cnt);?>EA</td>
          </tr>
          <?php }?>
          </tbody>
        </table>
        <a href="product_up.php">
            <button class="btn btn-primary" type="button">제품등록</button>
        </a>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
