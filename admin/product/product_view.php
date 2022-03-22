<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/header.php";
if(!$_SESSION['AUID']){
    echo "<script>alert('권한이 없습니다.');history.back();</script>";
    exit;
}

$pid = $_GET['pid'];

$query="select * from products where pid=".$pid;
$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
$rs = $result->fetch_object();


$query2="select * from product_options where pid=".$pid;
$result2 = $mysqli->query($query2) or die("query error => ".$mysqli->error);
while($rs2 = $result2->fetch_object()){
    $options[]=$rs2;
}

?>
<style>
    .col{
        border: 1px solid #f1f1f1;
    }
</style>
<link
  rel="stylesheet"
  href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
/>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<div class="container">
  <div class="row">
    <div class="col" style="text-align:center;">
      <img id="pimg" src="<?php echo $rs->thumbnail;?>" style="max-width:200px;">
    </div>
    <div class="col">
      <h3><?php echo $rs->name;?></h3>
        <div>
            가격 : <?php echo number_format($rs->price);?>원
        </div>
        <?php if($options){?>
        <div>
            옵션 : 
            <select name="poption" id="poption">
                <option value="">선택하세요</option>
                <?php foreach($options as $op){?>
                    <option value="<?php echo $op->poid;?>"><?php echo $op->option_name;?></option>
                <?php }?>
            </select>
        </div>
        <?php }?>
    </div>
  </div>
  
</div>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $("#poption").change(function(){
        var poid = $("#poption option:selected").val();
        
        var data = {
            poid : poid
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'option_img.php' ,
                data  : data ,
                dataType : 'html' ,
                error : function() {} ,
                success : function(return_data) {
                    $("#pimg").attr("src", return_data);
                }
        });
    });
</script>
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
