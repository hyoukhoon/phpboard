<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";
$query="select * from category where step=1";

?>
    <table class="table table-sm table-bordered">
        <tbody id="optTable">
        <tr>
            <th scope="row">*</th>
            <td>옵션 추가 갯수</td>
            <td>
                <select id="optionCnt" style="width:100px;" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option value=0>선택</option>
                    <option value="1">한개</option>
                    <option value="2">두개</option>
                    <option value="3">세개</option>
                </select>
            </td>
            <td><button type="button" id="optionCreate" class="btn btn-primary">만들기</button></td>
        </tr>

        </tbody>
    </table>


<script>
    $("#optionCreate").click(function(){
        var optionCnt = $("#optionCnt option:selected").val();
        
        var data = {
            optionCnt : optionCnt
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'optionCreate.php' ,
                data  : data ,
                dataType : 'html' ,
                error : function() {} ,
                success : function(return_data) {
                    $("#optTable").append(return_data);
                }
        });
    });

    $("#optionType[0]").change(function(){
        var cate1 = $("#cate1 option:selected").val();
        
        var data = {
            cate1 : cate1
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'category2.php' ,
                data  : data ,
                dataType : 'html' ,
                error : function() {} ,
                success : function(return_data) {
                    $("#cate2").html(return_data);
                }
        });
    });
</script>

<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
