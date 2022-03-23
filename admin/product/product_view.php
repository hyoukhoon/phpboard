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

    [type=radio] { 
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    [type=radio] + span {
        cursor: pointer;
    }
    [type=radio]:checked + span {
        outline: 5px solid indigo;
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
            가격 : <span id="price"><?php echo number_format($rs->price);?></span>원
        </div>
        <?php if($options){?>
        <br>
        <div>
            옵션 : 
            <select name="poption" id="poption">
                <option value="">선택하세요</option>
                <?php foreach($options as $op){?>
                    <option value="<?php echo $op->poid;?>"><?php echo $op->option_name;?></option>
                <?php }?>
            </select>
        </div>
        <br>
        <div>

            <?php foreach($options as $op){?>
                <input type="radio" name="poption" class="optradio" id="poption_<?php echo $op->poid;?>" value="<?php echo $op->poid;?>">
                    <span  onclick="jQuery('#poption_<?php echo $op->poid;?>').click();" style="content:url(<?php echo $op->image_url;?>);height:100px;width:100px;"></span>
                </input>
            <?php }?>
            
        </div>
        <?php }?>
    </div>
  </div>
  
</div>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $("input[name='poption']:radio").change(function () {
        var poid = $('input:radio[name="poption"]:checked').val();
        var data = {
            poid : poid
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'option_change.php' ,
                data  : data ,
                dataType : 'json' ,
                error : function() {} ,
                success : function(data) {
                    var price=parseInt(data.option_price)+<?php echo $rs->price;?>;
                    $("#pimg").attr("src", data.image_url);
                    $("#price").text(number_format(price));
                }
        });
    });

    function number_format(num){ 
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g,','); 
    }


    $("#poption").change(function(){
        var poid = $("#poption option:selected").val();
        
        var data = {
            poid : poid
        };
            $.ajax({
                async : false ,
                type : 'post' ,
                url : 'option_change.php' ,
                data  : data ,
                dataType : 'json' ,
                error : function() {} ,
                success : function(data) {
                    var price=parseInt(data.option_price)+<?php echo $rs->price;?>;
                    $("#pimg").attr("src", data.image_url);
                    $("#price").text(number_format(price));
                }
        });
    });
</script>
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/footer.php";
?>
