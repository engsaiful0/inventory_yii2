<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'production-input-form',
            'action' => $this->createUrl('productionInput/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<?php
    $productionOutputs=ProductionOutput::model()->findAll();
    if($productionOutputs){
        foreach($productionOutputs as $productionOutput){
            $prdotItemsInfo=Items::model()->findByPk($productionOutput->item);
            if($prdotItemsInfo){
                $prodId=$prdotItemsInfo->id;
                $prodName=$prdotItemsInfo->name;
                $prodUnit=$prdotItemsInfo->unit;
                $prodDesc=$prdotItemsInfo->desc;
                ?>
                <span style="display: none;" id="<?php echo $productionOutput->sl_no; ?>" itemId="<?php echo $prodId; ?>" itemName="<?php echo $prodName; ?>" itemUnit="<?php echo $prodUnit; ?>" itemDesc="<?php echo $prodDesc; ?>" itemQty="<?php echo $productionOutput->qty; ?>"></span>
            <?php
            }
        }
    }
?>
<div class="formDiv">
    <fieldset>
        <legend>Production Input Form</legend>
        <div class="scrollable">
            <table>
                <tr>
                    <td><input class="addRight" id="addLabelTrackBtn" type="button" value="" title="Add"/></td>
                    <td><input type="text" id="addLabelTrackInpt" placeholder="Enter Label/Track No. Here and Click Arrow to Add" /></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Label/Track No</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th style="width: 32px;">Remove</th>
                </tr>
            </table>
        </div>
        <div style="float: left; width: 100%;">
            <table>
                <tr>                     
                    <td><?php echo $form->labelEx($itemsModel, 'pbrand'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $itemsModel, 'pbrand', CHtml::listData(PBrand::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>  
                    <td><?php echo $form->labelEx($itemsModel, 'pmodel'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $itemsModel, 'pmodel', CHtml::listData(PModel::model()->findAll(array('order' => 'id DESC')), 'id', 'name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                    <td><?php echo $form->labelEx($itemsModel, 'country'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $itemsModel, 'country', CHtml::listData(Countries::model()->findAll(array('order' => 'country ASC')), 'id', 'country'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td> 
                    <td rowspan="2">
                        <span id="ajaxLoaderSearch" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::submitButton('Search Items', array(
                            'ajax' => array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'url' => CController::createUrl('items/itemsOfThis'),
                                'success' => 'function(data) {
                                                $("#itemsWithCat").html(data.content);
                                         }',
                                'data' => array(
                                    'pbrand' => 'js:jQuery("#Items_pbrand").val()',
                                    'pmodel' => 'js:jQuery("#Items_pmodel").val()',
                                    'country' => 'js:jQuery("#Items_country").val()',
                                    'product_type' => 'js:jQuery("#Items_product_type").val()',
                                    'grade' => 'js:jQuery("#Items_grade").val()',
                                    'mfi' => 'js:jQuery("#Items_mfi").val()',
                                    'formName' => 'ProductionInput',
                                ),
                                'beforeSend' => 'function(){
                                                    $("#ajaxLoaderSearch").show();
                                         }',
                                'complete' => 'function(){
                                                    $("#ajaxLoaderSearch").hide();
                                        }',
                            ),
                                )
                        );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($itemsModel, 'product_type'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList($itemsModel, 'product_type', Lookup::items('product_type'), array('prompt' => 'select'));
                        ?>
                    </td> 
                    <td><?php echo $form->labelEx($itemsModel, 'grade'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $itemsModel, 'grade', CHtml::listData(Grades::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td> 
                    <td><?php echo $form->labelEx($itemsModel, 'mfi'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $itemsModel, 'mfi', CHtml::listData(Mfis::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td> 
                </tr>
            </table>
        </div>
        <div class="touchWrapper">
            <div id="itemsWithCat">
                <?php
                $cats = Cats::model()->findAll(array('order' => 'name ASC'));
                if ($cats) {
                    foreach ($cats as $cts):
                        ?>
                        <div class="posItemCats categories soundBtn" id="<?php echo $cts->id; ?>">
                            <span class="prodTitle"><?php echo $cts->name; ?></span>
                        </div>
                        <div class="itemsOfThisCat" id="item_<?php echo $cts->id; ?>" style="display: none;">
                            <?php
                            $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' AND is_rawmat=1 ORDER BY name ASC'));
                            if ($items) {
                                foreach ($items as $itms):
                                    $stockQty=StoreInventory::model()->presentStockOfThisItemAllStore($itms->id);
                                    ?>
                                    <div class="posItemCats itms soundBtn" stockQty="<?php echo $stockQty; ?>" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
                                        <span class="prodTitle">
                                            <?php echo $itms->name; ?><br/>
                                            (<?php echo $itms->desc; ?>)
                                        </span>
                                    </div>
                                    <?php
                                endforeach;
                            }
                            ?>
                        </div>
                        <?php
                    endforeach;
                }
                ?>
            </div>
        </div>
        <div class="rightDiv">
            <table>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'date',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array("class" => "coloredInput"),
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'time'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig2 = array(
                            'model' => $model,
                            'attribute' => 'time',
                            'mode' => 'time',
                            'language' => 'en-AU',
                            'htmlOptions' => array("class" => "coloredInput"),
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'store'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%; padding: 10px 0px;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'machine'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'machine', CHtml::listData(Machines::model()->findAll(), 'id', 'nameWithCode'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%; padding: 10px 0px;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('productionInput/create', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                        $("#ajaxLoader").hide();  
                                            if(data.status=="success"){
                                                for(var i=0; i<data.itemsArrCount; i++){
                                                    $("#"+data.itemsArr[i]).attr("stockQty", data.itemsStockQtyArr[i]);
                                                }
                                                errQtyArr.length=0;
                                                $(".categories").show();
                                                $(".itemsOfThisCat").hide();
                                                newArr.length=0;
                                                newArr2.length=0;
                                                $("#tbl tr.cartList").remove();
                                                sl=0;
                                                $("#production-input-form")[0].reset();
                                                $("#formResultError").hide();
                                                $("#formResult").fadeIn();
                                                $("#formResult").html("Data saved successfully.");
                                                $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                                            }else{
                                                $("#formResult").hide();
                                                $("#formResultError").show();
                                                $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                                                $.each(data, function(key, val) {
                                                    $("#production-input-form #"+key+"_em_").html(""+val+"");                                                    
                                                    $("#production-input-form #"+key+"_em_").show();
                                                });
                                            }       
                            }',
                            'beforeSend' => 'function(){  
                                    if($("#tbl tr").length<=1){
                                        alertify.alert("Please add items first!");
                                        return false;
                                    }else if($("#ProductionInput_date").val()==""){
                                        alertify.alert("Please set date !");
                                        return false;
                                    }else if($("#ProductionInput_time").val()==""){
                                        alertify.alert("Please set time !");
                                        return false;
                                    }else if($("#ProductionInput_store").val()==""){
                                        alertify.alert("Please select a store !");
                                        return false;
                                    }else if($("#ProductionInput_machine").val()==""){
                                        alertify.alert("Please select a machine !");
                                        return false;
                                    }else{
                                        for(var i=1; i<($("#tbl tr").length); i++){
                                            if($("#qtyInpt_"+i).val()==""){
                                                $("#qtyInpt_"+i).css("border-color","red");
                                                errQtyArr[i]="err_exist";
                                            }else{
                                                $("#qtyInpt_"+i).css("border-color","#aaa");
                                                errQtyArr[i]="";
                                            }
                                        }
                                        if($.inArray("err_exist", errQtyArr)>-1){
                                            alertify.alert("There is an empty field on items quantity column !");
                                            return false;
                                        }else{
                                            $("#ajaxLoader").show();
                                        }
                                    }
                             }'
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><span class="resetBtn soundBtn" title="Re-Initialize"></span></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
                        <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
<script>
    var errQtyArr=new Array();
    var sl=0;
    var newArr=new Array();
    var newArr2=new Array();
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
            $("#item_"+thisCatId).show();
        });
        
        $(".main_menuBtn").click(function(){
            $(".categories").show();
            $(".itemsOfThisCat").hide();
        });
        
        $(".resetBtn").click(function(){
            $(".categories").show();
            $(".itemsOfThisCat").hide();
            newArr.length=0;
            newArr2.length=0;
            $("#tbl tr.cartList").remove();
            sl=0;
            $("#production-input-form")[0].reset();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            var itemQtyUnit=$(this).attr("qtyUnit");
            var itemDesc=$(this).attr("desc");
            var stockQty=$(this).attr("stockQty");
            var labelTrackNo="";
            var outputQty=1;
            
            if($.inArray(itemsId, newArr) > -1){
                var positionOfArrVal=newArr.indexOf(itemsId);
                var tempQty=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                var tempStockQty=parseFloat( ('0' + $("#stockqtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                if(tempQty >= tempStockQty){
                    alertify.alert("Warning: Can not add more, insufficient stock quantity !");
                }else{
                    var newQty=1;
                    newQty+=tempQty;
                    $("#qtyInpt_"+positionOfArrVal).val(newQty);
                }
            }else{
                if(stockQty >0 ){
                    add(itemsId, itemsName, itemQtyUnit, itemDesc, stockQty, outputQty, labelTrackNo);
                    newArr[sl]=itemsId;
                }else{
                    alertify.alert("Warning: Can not add, insufficient stock quantity !");
                }
            }
        });
        
        $("#addLabelTrackBtn").click(function(){
            
            var givenLabelTrackNo=$("#addLabelTrackInpt").val();
            if(givenLabelTrackNo!="" && document.getElementById(givenLabelTrackNo)){
                var spanInfo = document.getElementById(givenLabelTrackNo);
                var itemsId=$(spanInfo).attr("itemId");
                var itemsName=$(spanInfo).attr("itemName");
                var itemQtyUnit=$(spanInfo).attr("itemUnit");
                var itemDesc=$(spanInfo).attr("itemDesc");
                var outputQty=$(spanInfo).attr("itemQty");
                var labelTrackNo=$(spanInfo).attr("id");
                var stockQty=outputQty;
                
                if($.inArray(labelTrackNo, newArr2) > -1){
                    alertify.alert("Warning: Already added !");
                }else{
                    add(itemsId, itemsName, itemQtyUnit, itemDesc, stockQty, outputQty, labelTrackNo);
                    
                    newArr2[sl]=labelTrackNo;
                }
            }else{
                alertify.alert("Please enter correct label/track no.");
            }
        });
    })
    
    //-----------------------------------------------------
    
    $("#tbl td input.rdelete").live("click", function () {
        var idCounter=$(this).attr("id");
        
        var srow = $(this).parent().parent();
        srow.remove();
        $("#tbl td.sno").each(function(index, element){                 
            $(element).text(index + 1); 
        });
        newArr[idCounter]=0;
        newArr2[idCounter]=0;
        
        errQtyArr[idCounter]="";
    });
    
    function add(itemsId, itemsName, itemQtyUnit, itemDesc, stockQty, outputQty, labelTrackNo){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='ProductionInput[item][]' value='"+itemsId+"'>"+
            "<input type='hidden' id='stockqtyInpt_"+sl+"' value='"+stockQty+"'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td>" +
            "<input style='text-align: center;' id='trackNoInpt_"+sl+"' type='text' name='ProductionInput[track_no][]' value='"+labelTrackNo+"'>"+
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
            "</td><td style='text-align: left; padding-left:2px;'>" +
            itemDesc+
            "</td><td style='text-align: center;'>" +
            itemQtyUnit+
            "</td><td>" +
            "<input style='text-align: center;' id='qtyInpt_"+sl+"' type='text' name='ProductionInput[qty][]' value='"+outputQty+"'>"+
            "</td><td style='text-align: center;'>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt);
        $("#trackNoInpt_"+sl).css("background-color", "#eeeeee");
        $("#trackNoInpt_"+sl).focus(function(){
            $(this).blur();         
        });
        calFnc(sl);
    }
    
    function calFnc(count){
        $('#qtyInpt_'+count).bind('keyup', function() {
            var stckQty=parseFloat( ('0' + $("#stockqtyInpt_"+count).val()).replace(/[^0-9-\.]/g, ''), 10 );
            var qty=parseFloat( ('0' + $("#qtyInpt_"+count).val()).replace(/[^0-9-\.]/g, ''), 10 );
            if(qty>stckQty){
                alertify.alert("Warning: Can not add more, insufficient stock quantity !");
                $("#qtyInpt_"+count).val(stckQty);
            }
        });
    }
    
</script>
