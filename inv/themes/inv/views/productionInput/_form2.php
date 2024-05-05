<?php
$data = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
if ($data) {
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'production-input-form',
                'action' => $this->createUrl('productionInput/update'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>
    <?php $model->sl_no = end($data)->sl_no;
    echo $form->hiddenField($model, 'sl_no'); ?>
    <?php $model->max_sl_no = end($data)->max_sl_no;
    echo $form->hiddenField($model, 'max_sl_no'); ?>
    <?php $model->created_by = end($data)->created_by;
    echo $form->hiddenField($model, 'created_by'); ?>
    <?php $model->created_time = end($data)->created_time;
    echo $form->hiddenField($model, 'created_time'); ?>
    <div class="formDiv">
        <fieldset>
            <legend>Production Input Form</legend>
            <div class="scrollable">
                <table class="checkoutTab" id="tbl">
                    <tr>
                        <td colspan="8" style="padding: 6px 0px; font-weight: bold;">Production Input No: <i><?php echo end($data)->sl_no; ?></i></td>
                    </tr>
                    <tr>
                        <th style="width: 32px;">Sl</th>
                        <th>Label/Track No</th>
                        <th>Item</th>
                        <th>Input Qty</th>
                        <th>Input Qty(Kg)</th>
                        <th style="width: 32px;">Remove</th>
                    </tr>
                    <script>
                        var errQtyArr=new Array();
                        var sl=0;
                        var newArr=new Array();
                    </script>
                    <tr></tr>
                    <?php $sl = 1; ?>
                    <?php foreach ($data as $d) { ?>
                        <?php
                        $stockQty = StoreInventory::model()->presentStockOfThisItemAllStore($d->item);
                        $readyProducts = Items::model()->findByPk($d->item);
                        if ($readyProducts) {
                            $id=$readyProducts->id;
                            $cat=Cats::model()->nameOfThis($readyProducts->cat);
                            $catSub=CatsSub::model()->nameOfThis($readyProducts->cat_sub);
                            $name=$readyProducts->name;
                            $code=$readyProducts->code;
                            $desc=$readyProducts->desc;
                            $unit=$readyProducts->unit;
                            $isVatable = $readyProducts->vatable;

                            $item=$name." (".$code.")";
                            if($catSub!="")
                                $item.="- ".$catSub;
                            $item.="- ".$cat;
                            if($desc!="")
                                $item.="- ".$desc;
                            if($unit!="")
                                $item.="- ".$unit;

                        } else {
                            $item = "";
                        }
                        ?>
                        <tr class='cartList'>
                        <script>
                            sl='<?php echo $sl; ?>';
                            newArr[sl]='<?php echo $d->item; ?>';
                        </script>
                        <input type='hidden' name='ProductionInput[id][]' value='<?php echo $d->id; ?>' id="ProductionInput_<?php echo $sl; ?>"/>
                        <input type='hidden' name='ProductionInput[item][]' value='<?php echo $d->item; ?>'/>
                        <input type='hidden' id='stockqtyInpt_<?php echo $sl; ?>' value='<?php echo $stockQty; ?>'/>
                        <td class='sno' style='text-align: center;'>
        <?php echo $sl; ?> 
                        </td>
                        <td>
                            <input style='text-align: center;' id='trackNoInpt_<?php echo $sl; ?>' type='text' name='ProductionInput[track_no][]' value='<?php echo $d->track_no; ?>'/>
                        </td>
                        <td style='text-align: left; padding-left:2px;'>
        <?php echo $item; ?> 
                        </td>
                        <td>
                            <input style='text-align: center;' id='qtyInpt_<?php echo $sl; ?>' type='text' name='ProductionInput[qty][]' value='<?php echo $d->qty; ?>'/>
                        </td>
                        <td>
                            <input style='text-align: center;' id='qtyInptKg_<?php echo $sl; ?>' type='text' name='ProductionInput[qty_kg][]' value='<?php echo $d->qty_kg; ?>'/>
                        </td>
                        <td style='text-align: center;'>
                            <input title="remove" id='<?php echo $sl; ?>' type="button" class="rdelete dltBtn"/>
                        </td>
                        </tr>
        <?php $sl++; ?>
    <?php } ?>
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
                        <td rowspan="2"><?php echo $form->labelEx($itemsModel, 'supplier_id'); ?></td>
                        <td rowspan="2">
                            <?php
                            echo $form->dropDownList(
                                    $itemsModel, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
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
                                        'supplier_id' => 'js:jQuery("#Items_supplier_id").val()',
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
                    <tr>
                    <td colspan="9" style="padding: 10px 0px;"></td>
                </tr>
                <tr>
                    <td>Item/Code/Spec.</td>
                    <td colspan="8">
                        <input type="text" id="item_text"/>
                        <?php echo $form->hiddenField($itemsModel, 'id'); ?>
                        <?php
                            $itemInfoArry='';
                            $itemInfos= Items::model()->findAll(array('order' => 'name ASC'));
                            if($itemInfos){
                                $itemcount=count($itemInfos);
                                $i=1;
                                foreach($itemInfos as $itemInfo){
                                    $stockQty = StoreInventory::model()->presentStockOfThisItemAllStore($itemInfo->id);
                                    ?>
                                        <input type="hidden" id="item_sotckQty_<?php echo $itemInfo->id; ?>" value="<?php echo $stockQty; ?>"/>
                                    <?php
                                    $id=$itemInfo->id;
                                    $cat=Cats::model()->nameOfThis($itemInfo->cat);
                                    $catSub=CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                                    $name=$itemInfo->name;
                                    $code=$itemInfo->code;
                                    $desc=$itemInfo->desc;
                                    $unit=$itemInfo->unit;
                                    $isVatable = $itemInfo->vatable;

                                    $item=$name." (".$code.")";
                                    if($catSub!="")
                                        $item.="- ".$catSub;
                                    $item.="- ".$cat;
                                    if($desc!="")
                                        $item.="- ".$desc;
                                    if($unit!="")
                                        $item.="- ".$unit;

                                    $itemInfoArry.='{value: '.$id.', label: "'.CHtml::encode($item).'"}';
                                    if($i==$itemcount)
                                        $itemInfoArry.='';
                                    else
                                        $itemInfoArry.=',';
                                    $i++;
                                }
                            }
                        ?>
                        <script>
                            var itemInfoArry = [<?php echo $itemInfoArry; ?>];
                            $(function () {
                                $( "#item_text" ).autocomplete({
                                    source: itemInfoArry,
                                    minLength: 2,
                                    select: function(event, ui) {
                                        $("#item_text").val(ui.item.label);
                                        $("#Items_id").val(ui.item.value);
                                        return false;
                                    }
                                });
                            });
                        </script>
                        <input title="Add To The List" type="button" value="Add To The List" onclick="AddNewItem()" />
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="padding: 10px 0px;"></td>
                </tr>
                </table>
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
                                                        $stockQty = StoreInventory::model()->presentStockOfThisItemAllStore($itms->id);

                                                        $id=$itms->id;
                                                        $cat=$catName;
                                                        $catSub=$subCatName;
                                                        $name=$itms->name;
                                                        $code=$itms->code;
                                                        $desc=$itms->desc;
                                                        $unit=$itms->unit;
                                                        $isVatable = $itms->vatable;

                                                        $item=$name." (".$code.")";
                                                        if($catSub!="")
                                                            $item.="- ".$catSub;
                                                        $item.="- ".$cat;
                                                        if($desc!="")
                                                            $item.="- ".$desc;
                                                        if($unit!="")
                                                            $item.="- ".$unit;
                                                        ?>
                                                        <div class="posItemCats itms soundBtn" stockQty="<?php echo $stockQty; ?>" id="<?php echo $id; ?>" name="<?php echo $item; ?>">
                                                            <span class="prodTitle">
                                                                <?php echo $item; ?>
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
                                                        $stockQty = StoreInventory::model()->presentStockOfThisItemAllStore($itms->id);

                                                        $id=$itms->id;
                                                        $cat=$catName;
                                                        $catSub="";
                                                        $name=$itms->name;
                                                        $code=$itms->code;
                                                        $desc=$itms->desc;
                                                        $unit=$itms->unit;
                                                        $isVatable = $itms->vatable;

                                                        $item=$name." (".$code.")";
                                                        if($catSub!="")
                                                            $item.="- ".$catSub;
                                                        $item.="- ".$cat;
                                                        if($desc!="")
                                                            $item.="- ".$desc;
                                                        if($unit!="")
                                                            $item.="- ".$unit;
                                                        ?>
                                                        <div class="posItemCats itms soundBtn" stockQty="<?php echo $stockQty; ?>" id="<?php echo $id; ?>" name="<?php echo $item; ?>">
                                                            <span class="prodTitle">
                                                                <?php echo $item; ?>
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
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'date'); ?></td>
                        <td>
                            <?php
                            $model->date = end($data)->date;
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
                            $model->time = end($data)->time;
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
                            $model->store = end($data)->store;
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
                            $model->machine = end($data)->machine;
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
                            echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('productionInput/update', 'sl_no' => end($data)->sl_no)), array(
                                'dataType' => 'json',
                                'type' => 'post',
                                'success' => 'function(data) {
                                        $("#ajaxLoader").hide();  
                                            if(data.status=="success"){
                                                $(".categories").show();
                                                $(".subCatsOfThisCat").hide();
                                                $(".items").hide();
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
                            echo CHtml::link('Close', array('#'), array('class' => 'closeBtn additionalBtn', 'onclick' => 'closeMe();'));
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'deleteDialogBox',
    'options' => array(
        'title' => 'Processing..',
        'autoOpen' => false,
        'modal' => true,
        'resizable' => false,
    ),
));
?>
<div id='deleteMsg' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <script>
        function closeMe(){
            window.opener = self;
            window.close();
        }
        
        function AddNewItem() {
            if($("#Items_id").val()==""){
                alertify.alert("Please select an item !");
            }else{
                var itemsId=$("#Items_id").val();
                var itemsName=$("#item_text").val();
                var stockQty=$("#item_sotckQty_"+itemsId).val();

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
                        add(itemsId, itemsName, stockQty);
                        newArr[sl]=itemsId;
                    }else{
                        alertify.alert("Warning: Can not add, insufficient stock quantity !");
                    }
                }
            }        
        }
        
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

            $(".resetBtn").click(function(){
                $(".categories").show();
                $(".subCatsOfThisCat").hide();
                $(".items").hide();
                newArr.length=0;
                $("#tbl tr.cartList").remove();
                sl=0;
                $("#production-input-form")[0].reset();
            });
                    
            $(".itms").click(function(){
                var itemsId=$(this).attr("id");
                var itemsName=$(this).attr("name");
                var stockQty=$(this).attr("stockQty");
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
                        add(itemsId, itemsName, stockQty);
                        newArr[sl]=itemsId;
                    }else{
                        alertify.alert("Warning: Can not add, insufficient stock quantity !");
                    }
                }
            });
        })
                
        //-----------------------------------------------------
                
        $("#tbl td input.rdelete").live("click", function () {
            if(confirm("Are you sure you want to delete this record ? The record will be deleted parmanently.")){
                var idCounter=$(this).attr("id");
                
                $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo CController::createUrl('productionInput/deleteFromUpdate'); ?>',
                data: { 'id': $("#ProductionInput_"+idCounter).val() },
                beforeSend:function(){
                    $("#deleteDialogBox").dialog("open");
                    $("#deleteMsg").html("Deleting please wait...").show();
                },
                complete: function(){
                    setTimeout("$('#deleteDialogBox').dialog('close').children(':eq(0)').empty();", 1000 );
                }
            });     
                
                var srow = $(this).parent().parent();
                srow.remove();
                $("#tbl td.sno").each(function(index, element){                 
                    $(element).text(index + 1); 
                });
                newArr[idCounter]=0;
                errQtyArr[idCounter]="";
            }
        });
                
        function add(itemsId, itemsName, stockQty){
            sl++;
            var slNumber=$('#tbl tr').length;
                    
            var appendTxt = "<tr class='cartList'>"+
                "<input type='hidden' name='ProductionInput[id][]' value='0'>"+
                "<input type='hidden' name='ProductionInput[item][]' value='"+itemsId+"'>"+
                "<input type='hidden' id='stockqtyInpt_"+sl+"' value='"+stockQty+"'>"+
                "<td class='sno' style='text-align: center;'>"+
                slNumber +
                "</td><td>" +
                "<input style='text-align: center;' id='trackNoInpt_"+sl+"' type='text' name='ProductionInput[track_no][]'>"+
                "</td><td style='text-align: left; padding-left:2px;'>" + 
                itemsName +
                "</td><td>" +
                "<input style='text-align: center;' id='qtyInpt_"+sl+"' type='text' name='ProductionInput[qty][]' value='1'>"+
                "</td><td>" +
                "<input style='text-align: center;' id='qtyInptKg_"+sl+"' type='text' name='ProductionInput[qty_kg][]'>"+
                "</td><td style='text-align: center;'>" +
                "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
                "</td></tr>";
            $("#tbl tr:last").after(appendTxt);
        }
                
    </script>
    <?php
} else {
    $this->redirect(array('admin'));
}
?>

