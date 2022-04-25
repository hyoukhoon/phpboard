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
          <tr>
            <th scope="row" class="thst">할인가</th>
            <td><input type="number" style="width:200px;text-align:right;" class="form-control" name="coupon_price" id="coupon_price" value='0'>원</td>
          </tr>
          <tr>
            <th scope="row" class="thst">할인비율</th>
            <td><input type="number" style="width:200px;text-align:right;" class="form-control" name="coupon_ratio" id="coupon_ratio" value='0'>%</td>
          </tr>
          <tr>
            <th scope="row" class="thst">최소사용금액</th>
            <td><input type="number" style="width:200px;text-align:right;" class="form-control" name="use_min_price" id="use_min_price"></td>
          </tr>
          <tr>
            <th scope="row" class="thst">최대할인금액</th>
            <td><input type="number" style="width:200px;text-align:right;" class="form-control" name="max_value" id="max_value"></td>
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

    

    function opt1cp(){
        var addHtml=$("#optionTr1").html();
        var addHtml="<tr>"+addHtml+"</tr>";
        $("#option1").append(addHtml);
    }

    function opt2cp(){
        var addHtml=$("#optionTr2").html();
        var addHtml="<tr>"+addHtml+"</tr>";
        $("#option2").append(addHtml);
    }

    function save(){
        var markup = $('#summernote').summernote('code');
        var contents=encodeURIComponent(markup);
        $("#contents").val(contents);

        if($('#summernote').summernote('isEmpty')) {
            alert('상품 설명을 입력하세요.');
            return false;
        }

        if(!$('#thumbnail').val()){
            alert('썸네일을 등록하십시오.');
            return false;
        }

        if(!$('#file_table_id').val()){
            alert('추가 이미지를 최소한 한개 이상 등록하세요.');
            return false;
        }

        var iswms=$("#wmsArea").find('li').length;
        if(!iswms){
            alert('재고를 입력하세요.');
            return false;
        }

        var wmssum = 0;
        $("input[name='wms[]']").each(function(){    
            wmssum = parseInt(wmssum) + parseInt($(this).val());
        });

        if(!wmssum){
            alert('재고를 입력하세요.');
            return false;
        }

    }


    $("#upfile").change(function(){

        var files = $('#upfile').prop('files');
        for(var i=0; i < files.length; i++) {
            attachFile(files[i]);
        }

        $('#upfile').val('');

    });   

    function attachFile(file) {
    var formData = new FormData();
    formData.append("savefile", file);
    $.ajax({
        url: 'product_save_image.php',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType : 'json' ,
        type: 'POST',
        success: function (return_data) {
            if(return_data.result=="member"){
                alert('로그인 하십시오.');
                return;
            }else if(return_data.result=="size"){
                alert('10메가 이하만 첨부할 수 있습니다.');
                return;
            }else if(return_data.result=="image"){
                alert('이미지 파일만 첨부할 수 있습니다.');
                return;
            }else if(return_data.result=="error"){
                alert('첨부하지 못했습니다. 관리자에게 문의하십시오.');
                return;
            }else{
                imgid = $("#file_table_id").val() + return_data.imgid + ",";
                $("#file_table_id").val(imgid);
                var html = "<div class='col' id='f_"+return_data.imgid+"'><div class='card h-100'><img src='/pdata/"+return_data.savename+"' class='card-img-top'><div class='card-body'><button type='button' class='btn btn-warning' onclick='file_del("+return_data.imgid+")'>삭제</button></div></div></div>";
                $("#imageArea").append(html);
            }
        }
    });

    }

    function file_del(imgid){

        if(!confirm('삭제하시겠습니까?')){
        return false;
        }
            
        var data = {
            imgid : imgid
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'image_delete.php' ,
                data  : data ,
                dataType : 'json' ,
                error : function() {} ,
                success : function(return_data) {
                    if(return_data.result=="member"){
                        alert('로그인 하십시오.');
                        return;
                    }else if(return_data.result=="my"){
                        alert('본인이 작성한 제품의 이미지만 삭제할 수 있습니다.');
                        return;
                    }else if(return_data.result=="no"){
                        alert('삭제하지 못했습니다. 관리자에게 문의하십시오.');
                        return;
                    }else{
                        $("#f_"+imgid).hide();
                    }
                }
        });

        }

</script>    
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
