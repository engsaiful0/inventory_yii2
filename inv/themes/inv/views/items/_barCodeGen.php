<div class="formDiv">
    <fieldset>
        <legend>Barcode Generator Form</legend>
        <div class="scrollable">
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Item</th>
                    <th>Code</th>
                    <th>Optional<br/>Comment (Top)</th>
                    <th>Optional<br/>Comment (Bottom)</th>
                    <th>Image Quantity</th>
                    <th style="width: 32px;">Remove</th>
                </tr>
            </table>
        </div>
        <div id="config">
            <div class="config">
                <div class="title">Type</div>
                <input type="radio" name="btype" id="ean8" value="ean8" class="soundBtn"><label for="ean8">EAN 8</label><br />
                <input type="radio" name="btype" id="ean13" value="ean13" class="soundBtn"><label for="ean13">EAN 13</label><br />
                <input type="radio" name="btype" id="upc" value="upc" class="soundBtn"><label for="upc">UPC</label><br />
                <input type="radio" name="btype" id="std25" value="std25" class="soundBtn"><label for="std25">standard 2 of 5 (industrial)</label><br />
                <input type="radio" name="btype" id="int25" value="int25" class="soundBtn"><label for="int25">interleaved 2 of 5</label><br />
                <input type="radio" name="btype" id="code11" value="code11" class="soundBtn"><label for="code11">code 11</label><br />
                <input type="radio" name="btype" id="code39" value="code39" class="soundBtn" checked="checked"><label for="code39">code 39</label><br />
                <input type="radio" name="btype" id="code93" value="code93" class="soundBtn"><label for="code93">code 93</label><br />
                <input type="radio" name="btype" id="code128" value="code128" class="soundBtn"><label for="code128">code 128</label><br />
                <input type="radio" name="btype" id="codabar" value="codabar" class="soundBtn"><label for="codabar">codabar</label><br />
                <input type="radio" name="btype" id="msi" value="msi" class="soundBtn"><label for="msi">MSI</label><br />
                <input type="radio" name="btype" id="datamatrix" value="datamatrix" class="soundBtn"><label for="datamatrix">Data Matrix</label><br /><br />
            </div>
            <div class="config">
                <div class="title">Misc</div>
                Background : <input type="text" id="bgColor" value="#FFFFFF" size="7"><br />
                Foreground : <input type="text" id="color" value="#000000" size="7"><br />
                <br /><br />
                "1" Bar's : <hr />
                <div class="barcode1D">
                    Width: <input type="text" id="barWidth" value="1" size="3"><br />
                    Height: <input type="text" id="barHeight" value="50" size="3"><br />
                </div>
                <div class="barcode2D">
                    Module Size: <input type="text" id="moduleSize" value="5" size="3"><br />
                    Quiet Zone Modules: <input type="text" id="quietZoneSize" value="1" size="3"><br />
                    Form: <input type="checkbox" name="rectangular" id="rectangular" class="soundBtn" style="float: unset; width: unset;"><label for="rectangular">Rectangular</label><br />
                </div>
                <div id="miscCanvas">
                    x : <input type="text" id="posX" value="10" size="3"><br />
                    y : <input type="text" id="posY" value="20" size="3"><br />
                </div>
            </div>
        </div>
        <div class="touchWrapper">
            <div id="itemsWithCat">
                <?php
                $cats = Cats::model()->findAll(array('order' => 'name ASC'));
                if ($cats) {
                    foreach ($cats as $cts) {
                        ?>
                        <div class="posItemCats categories soundBtn" id="cat_<?php echo $cts->id; ?>">
                            <span class="prodTitle">
                                <?php
                                $catName = $cts->name;
                                echo $catName;
                                ?>
                            </span>
                        </div>
                        <?php
                        $subCats = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' GROUP BY cat_sub ORDER BY cat_sub ASC'));
                        if ($subCats) {
                            ?>
                            <div class="subCatsOfThisCat" id="subCat_cat_<?php echo $cts->id; ?>" style="display: none;">
                                <?php
                                foreach ($subCats as $subCat) {
                                    if ($subCat->cat_sub != "") {
                                        ?>
                                        <div class="posItemCats subCategories soundBtn" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>">
                                            <span class="prodTitle">
                                                <?php
                                                $subCatName = CatsSub::model()->nameOfThis($subCat->cat_sub);
                                                echo $subCatName;
                                                ?>
                                            </span>
                                        </div>
                                        <?php
                                        $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' AND cat_sub=' . $subCat->cat_sub . ' ORDER BY name ASC'));
                                        if ($items) {
                                            ?>
                                            <div class="items" id="cat_<?php echo $cts->id; ?>_subCat_<?php echo $subCat->cat_sub; ?>_item" style="display: none;">
                                                <?php
                                                foreach ($items as $itms) {
                                                    ?>
                                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $subCatName; ?> - <?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>" code="<?php echo $itms->code; ?>">
                                                        <span class="prodTitle">
                                                            <?php echo $itms->name; ?><br/>
                                                            <span class="colorSpan">(<?php echo $itms->desc; ?>)</span>
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' AND cat_sub is NULL ORDER BY name ASC'));
                                        if ($items) {
                                            ?>
                                            <div class="items itemsWithNoSubCat" id="cat_<?php echo $cts->id; ?>_subCat_no_item" style="display: none;">
                                                <?php
                                                foreach ($items as $itms) {
                                                    ?>
                                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>" code="<?php echo $itms->code; ?>">
                                                        <span class="prodTitle">
                                                            <?php echo $itms->name; ?><br/>
                                                            <span class="colorSpan">(<?php echo $itms->desc; ?>)</span>
                                                        </span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div class="rightDiv">
            <table>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><label>Total Image</label></td>
                    <td><input type="text" id="cashTotal" class="coloredInput"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn soundBtn" type="button" onclick="generateBarcode();" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generate the barcode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn soundBtn" type="button" onclick="clearImgs();" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clear Images&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn soundBtn" type="button" onclick="resetAll();" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reset All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"/></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="msg"></span>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
    <?php
    echo "<div class='printBtn'>";
    $this->widget('ext.mPrint.mPrint', array(
        'title' => ' ', //the title of the document. Defaults to the HTML title
        'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
        'text' => '', //text which will appear beside the print icon. Defaults to NULL
        'element' => '.barCodeImages', //the element to be printed.
        'exceptions' => array(//the element/s which will be ignored
        ),
        'publishCss' => FALSE, //publish the CSS for the whole page?
        'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
        'alt' => 'print', //text which will appear if image can't be loaded
        'debug' => FALSE, //enable the debugger to see what you will get
        'id' => 'print-div'         //id of the print link
    ));
    echo "</div>";
    ?>
    <div class="barCodeImages" id="barCodeImages">

    </div>
</div>
<style>
    * {
        font-family:Arial,sans-serif;
        font-size:12px;
        font-weight:normal;
    }    
    #config{
        overflow: auto;
        margin-bottom: 10px;
    }
    .config{
        float: left;
        width: 200px;
        height: 260px;
        border: 1px solid #aaa;
        margin-left: 10px;
        padding: 6px;
    }
    .config .title{
        font-weight: bold;
        text-align: center;
    }
    .config .barcode2D,
    #miscCanvas{
        display: none;
    }
    #barcodeTarget,
    #canvasTarget{
        margin-top: 20px;
    }        
    .barcodeTarget{
        float: left;
        margin-bottom: 10px;
    }
    .barCodeImages{
        float: left;
        width: 100%;
    }
    .scrollable{
        width: 65%;
        height: 270px;
    }
    .btn{
        margin: 10px;
        width: 93%;
    }
    .msg{
        color: powderblue;
        float: left;
        font-weight: bold;
        text-align: center;
        width: 100%;
    }
    .barcodeParagraph{
        float: left;
        font-size: 9px;
        font-weight: bold;
        padding: 2px 0px;
        text-align: center;
        width: 100%;
    }
</style>
<script type="text/javascript">
    
    function generateBarcode(){
        var btype = $("input[name=btype]:checked").val();
        var renderer = $("input[name=renderer]:checked").val();

        var quietZone = false;
        if ($("#quietzone").is(':checked') || $("#quietzone").attr('checked')){
            quietZone = true;
        }

        var settings = {
            showHRI: true,
            output:renderer,
            bgColor: $("#bgColor").val(),
            color: $("#color").val(),
            barWidth: $("#barWidth").val(),
            barHeight: $("#barHeight").val(),
            moduleSize: $("#moduleSize").val(),
            posX: $("#posX").val(),
            posY: $("#posY").val(),
            addQuietZone: $("#quietZoneSize").val()
        };
        
        $(".barcodeValue:input").each(function(){
            var value = $(this).val();
            var id = $(this).attr("id");
            var qty=parseFloat( ('0' + $("#"+id+"_qty").val()).replace(/[^0-9-\.]/g, ''), 10 );
            var opcTop=$("#"+id+"_opcTop").val();
            var opcBottom=$("#"+id+"_opcBottom").val();
            
            if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
                value = {code:value, rect: true};
            }
            
            for(var i=1; i<=qty; i++){
                var divId="bc_"+id+"_"+i;
                var div=document.createElement("div");
                div.setAttribute('class', 'barcodeTarget');
                div.setAttribute('id', 'barcodeTarget_'+divId);
                
                $(".barCodeImages").append(div);
                $('#barcodeTarget_'+divId).html("").show().barcode(value, btype, settings).append("<span class='barcodeParagraph'>"+opcBottom+"</span>");
                $('#barcodeTarget_'+divId).prepend("<span class='barcodeParagraph'>"+opcTop+"</span>");
            }
        });
        $(".msg").html("Barcode images are generated below.");
        window.location.href = "#barCodeImages";
    }
          
    function showConfig1D(){
        $('.config .barcode1D').show();
        $('.config .barcode2D').hide();
    }
      
    function showConfig2D(){
        $('.config .barcode1D').hide();
        $('.config .barcode2D').show();
    }
    function clearImgs(){
        $(".barCodeImages").html("");
        $(".msg").html("");
    }
    $(function(){
        $('input[name=btype]').click(function(){
            if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();
        });
        $('input[name=renderer]').click(function(){
            if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();
        });
    });
  
</script>

<script>
    var sl=0;
    var newArr=new Array();
    $(document).ready(function(){
        ion.sound({
            sounds: [
                {name: "beep"}
            ],
            path: "<?php echo Yii::app()->theme->baseUrl; ?>/sounds/",
            preload: true,
            volume: 1.0
        });

        $(".soundBtn").click(function(){
            ion.sound.play("beep");
        });
        
        $(".categories").click(function(){
            var thisCatId=$(this).attr("id");
            $(".categories").hide();
            $(".subCategories").show();
            $("#subCat_"+thisCatId).show();
            $("#"+thisCatId+"_subCat_no_item").show();
        });
        $(".subCategories").click(function(){
            var thisSubCatId=$(this).attr("id");
            $(".subCategories").hide();
            $(".itemsWithNoSubCat").hide();
            $("#"+thisSubCatId+"_item").show();
        });
        $(".main_menuBtn").click(function(){
            $(".categories").show();
            $(".subCatsOfThisCat").hide();
            $(".items").hide();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            var itemCode=$(this).attr("code");
            $('#cashTotal').val('0');
            
            if($.inArray(itemsId, newArr) > -1){
                
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#value_"+positionOfArrVal+"_qty").val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#value_"+positionOfArrVal+"_qty").val(newQty);
                var tempQty= $("#value_"+positionOfArrVal+"_qty").val();
                $('#lineTtlInpt_'+positionOfArrVal).val(tempQty);
                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            }else{
                add(itemsId, itemsName, itemCode);
                newArr[sl]=itemsId;
            }
        });
    })
    
    //-----------------------------------------------------
    
    function resetAll(){
        $(".categories").show();
        $(".subCatsOfThisCat").hide();
        $(".items").hide();
        newArr.length=0;
        $("#tbl tr.cartList").remove();
        sl=0;
        $("#cashTotal").val("0");
        $("#barWidth").val("1");
        $("#barHeight").val("50");
        $("#bgColor").val("#FFFFFF");
        $("#color").val("#000000");
        $("#code39").prop("checked", true);
        $("#moduleSize").val("5");
        $("#quietZoneSize").val("1");
        $("#rectangular").prop("checked", false);
        $("#posX").val("10");
        $("#posY").val("20");
        $('.config .barcode1D').show();
        $('.config .barcode2D').hide();
        $(".barCodeImages").html("");
        $(".msg").html("");
        
    }
    
    var grandTotal=0; 
    $("#cashTotal").val(grandTotal);
    
    $("#tbl td input.rdelete").live("click", function () {
        var idCounter=$(this).attr("id");
        grandTotal=$("#cashTotal").val()-$('#lineTtlInpt_'+idCounter).val();
        $("#cashTotal").val(grandTotal);
        var srow = $(this).parent().parent();
        srow.remove();
        $("#tbl td.sno").each(function(index, element){                 
            $(element).text(index + 1); 
        });
        newArr[idCounter]=0;
        
    });
    
    function add(itemsId, itemsName, itemCode){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
            "</td><td>" +
            "<input style='text-align: center;' id='value_"+sl+"' type='text' class='barcodeValue' value='"+itemCode+"'>"+
            "</td><td>" +
            "<input style='text-align: center;' id='value_"+sl+"_opcTop' type='text'>"+
             "</td><td>" +
            "<input style='text-align: center;' id='value_"+sl+"_opcBottom' type='text'>"+
            "</td><td>" +
            "<input style='text-align: center;' id='value_"+sl+"_qty' type='text' value='1'>"+
            "<input style='text-align: center; display: none;' id='lineTtlInpt_"+sl+"' class='lineTotalInpt' type='text' value='0'>"+
            "</td><td style='text-align: center;'>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        
        $("#tbl tr:last").after(appendTxt);
        
        $("#value_"+sl).css("background-color","#d7d7d7");
        $("#value_"+sl).focus(function(){
            $(this).blur();         
        });
        
        $('#lineTtlInpt_'+sl).val(1);
        $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
        calFnc(sl);
    }
    
    function calFnc(count){ 
        $('#value_'+count+'_qty').bind('keyup', function() {
            var qty=$(this).val();
            $('#lineTtlInpt_'+count).val(qty);
            $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
        });
    }
    
    $.fn.sumValues = function() {
        var sum = 0; 
        this.each(function() {
            if ( $(this).is(':input') ) {
                var val = $(this).val();
            } else {
                var val = $(this).text();
            }
            sum += parseFloat( ('0' + val).replace(/[^0-9-\.]/g, ''), 10 );
        });
        return sum;
    };
    
    $(document).ready(function(){
        $("input#cashTotal").focus(function(){
            $(this).blur();           
        }); 
    }); 
</script>
