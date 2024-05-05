<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'inventory-form',
            'action' => $this->createUrl('inventory/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Manual Stock Entry Form (Main Inventory)</legend>
        <div class="scrollable">
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Item</th>
                    <th>Specification</th>
                    <th>Stock In Quantity</th>
                    <th>Unit</th>
                    <th>Costing Price</th>
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
                                    'formName' => 'Inventory',
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
                    <td rowspan="2">
                        <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                         'title'=>'Add New',
                        'class' => 'add-additional-btn',
                        'onclick' => "{addNewItemItem(); $('#dialogAddNewItem').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogAddNewItem',
                        'options' => array(
                            'title' => 'Add New Item',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                    <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addNewItemItem(){
                            var reqFrom='inventory';
<?php
echo CHtml::ajax(array(
    'url' => array('items/createItemFromOutSide'),
    'data' => "js:$(this).serialize()+'&reqFrom='+reqFrom",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure'){
                                            $('#dialogAddNewItem div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddNewItem div.divForForm form').submit(addNewItemItem);
                                        }
                                        else
                                        {
                                            $('#itemsWithCat').html(data.div);
                                            setTimeout(\"$('#dialogAddNewItem').dialog('close') \",1000);
                                        }
                                                                }",
))
?>;
        return false; 
    } 
                    </script> 
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
                            $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->id . ' ORDER BY name ASC'));
                            if ($items) {
                                foreach ($items as $itms):
                                    ?>
                                    <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
                                        <span class="prodTitle">
                                            <?php echo $itms->name; ?><br/>
                                            <span class="colorSpan">(<?php echo $itms->desc; ?>)</span>
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
                    <td></td>
                    <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('inventory/create', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        errQtyArr.length=0;
                        errPriceArr.length=0;
                        $(".categories").show();
                        $(".itemsOfThisCat").hide();
                        newArr.length=0;
                        $("#tbl tr.cartList").remove();
                        sl=0;
                        $("#inventory-form")[0].reset();
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("inventory-grid", {
                                data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#inventory-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#inventory-form #"+key+"_em_").show();
                        });
                    }       
                }',
                            'beforeSend' => 'function(){  
                    if($("#tbl tr").length<=1){
                        alertify.alert("Please add items first!");
                        return false;
                    }else if($("#Inventory_date").val()==""){
                        alertify.alert("Please set date !");
                        return false;
                    }else if($("#Inventory_store").val()==""){
                        alertify.alert("Please select a store !");
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
                            if($("#priceInpt_"+i).val()==""){
                                $("#priceInpt_"+i).css("border-color","red");
                                errPriceArr[i]="err_exist";
                            }else{
                                $("#priceInpt_"+i).css("border-color","#aaa");
                                errPriceArr[i]="";
                            }
                        }
                        if($.inArray("err_exist", errQtyArr)>-1){
                            alertify.alert("There is an empty field on items stock in quantity column !");
                            return false;
                        }else if($.inArray("err_exist", errPriceArr)>-1){
                            alertify.alert("There is an empty field on items costing price column !");
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
    var errPriceArr=new Array();
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
            $("#tbl tr.cartList").remove();
            sl=0;
            $("#inventory-form")[0].reset();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            var itemQtyUnit=$(this).attr("qtyUnit");
            var itemDesc=$(this).attr("desc");
            
            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#qtyInpt_"+positionOfArrVal).val(newQty);
            }else{
                add(itemsId, itemsName, itemQtyUnit, itemDesc);
                newArr[sl]=itemsId;
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
        errQtyArr[idCounter]="";
        errPriceArr[idCounter]="";
    });
    
    function add(itemsId, itemsName, itemQtyUnit, itemDesc){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='Inventory[item][]' value='"+itemsId+"'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
            "</td><td style='text-align: left; padding-left:2px;'>" +
            itemDesc+
            "</td><td>" +
            "<input style='text-align: center;' id='qtyInpt_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='Inventory[stock_in][]' value='1'>"+
            "</td><td style='text-align: center;'>" +
            itemQtyUnit+
            "</td><td>" +
            "<input style='text-align: center;' id='priceInpt_"+sl+"' type='text' name='Inventory[costing_price][]'>"+
            "</td><td style='text-align: center;'>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt);
    }
    
</script>
