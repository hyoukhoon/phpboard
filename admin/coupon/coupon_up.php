<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";
if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}

?>
<style>
    .thst{
        text-align: center;
    vertical-align: middle;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <div style="text-align:center;padding:20px;"><H3>쿠폰등록하기</H3></div>
<form method="post" action="cupok.php" onsubmit="return save()" enctype="multipart/form-data">        
        <table class="table table-sm table-bordered">
          <tbody>
            <input type="hidden" name="file_table_id" id="file_table_id" value="">
            <input type="hidden" name="contents" id="contents" value="">
            
          
          <tr>
            <th scope="row" class="thst">쿠폰명</th>
            <td><input type="text" class="form-control" name="coupon_name" id="coupon_name" required></td>
          </tr>
          <tr>
            <th scope="row" class="thst">쿠폰이미지</th>
            <td><input type="file" class="form-control" name="coupon_image" id="coupon_image"></td>
          </tr>
          <tr>
            <th scope="row" class="thst">쿠폰타입</th>
            <td>
                <select class="form-select" name="coupon_type" id="coupon_type" aria-label="Default select example">
                    <option value="1">정액</option>
                    <option value="2">정율</option>
                </select>
            </td>
          </tr>
          <tr id="ct1">
            <th scope="row" class="thst">할인가</th>
            <td>
            <div class="input-group">
              <input type="text" style="width:200px;text-align:right;" class="form-control" name="coupon_price" id="coupon_price" value='0'>
              <span class="input-group-text">원</span>
            </div>
          </td>
          </tr>
          <tr id="ct2" style="display:none;">
            <th scope="row" class="thst">할인비율</th>
            <td>
            <div class="input-group">  
              <input type="text" style="width:200px;text-align:right;" class="form-control" name="coupon_ratio" id="coupon_ratio" value='0'>
              <span class="input-group-text">%</span>
            </div>
            </td>
          </tr>
          <tr>
            <th scope="row" class="thst">최소사용금액</th>
            <td>
              <div class="input-group">    
              <input type="number" style="width:200px;text-align:right;" class="form-control" name="use_min_price" id="use_min_price">
              <span class="input-group-text">원</span>
              </div>
            </td>
          </tr>
          <tr>
            <th scope="row" class="thst">최대할인금액</th>
            <td>
            <div class="input-group">  
            <input type="number" style="width:200px;text-align:right;" class="form-control" name="max_value" id="max_value">
            <span class="input-group-text">원</span>
            </div>
          </td>
          </tr>

          <tr>
            <th scope="row" class="thst">상태</th>
            <td>
                <select class="form-select" name="status" id="status" aria-label="Default select example">
                    <option value="1">대기</option>
                    <option value="2">사용중</option>
                    <option value="3">폐기</option>
                </select>
            </td>
          </tr>
          </tbody>
        </table>
        
        <button class="btn btn-primary" type="submit">등록완료</button>
</form>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>

    $("#coupon_type").change(function(){
        var ct1 = $("#coupon_type option:selected").val();
        
        if(ct1==1){
          $("#ct1").show();
          $("#ct2").hide();
        }else if(ct1==2){
          $("#ct2").show();
          $("#ct1").hide();
        }else{
          $("#ct1").show();
          $("#ct2").hide();
        }
    });

    function save(){

        if(!$('#coupon_image').val()){
            alert('썸네일을 등록하십시오.');
            return false;
        }


    }



</script>    
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
