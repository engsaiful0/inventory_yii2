<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'basick-sheet-requisition-form',
            'action' => $this->createUrl('basickSheetRequisition/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Basick Sheet Requisition Form</legend>
        <div class="scrollable">
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Item</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Thickness</th>
                    <th>Unit of distance</th>
                    <th>Quantity</th>
                    <th>Unit of Weight</th>
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
                                    'formName' => 'BasickSheetRequisition',
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
                $store = Stores::model()->findAll(array('order' => 'store_name ASC'));
                if ($store) {
                    foreach ($store as $strs) {
                        ?>
                        <div class="posItemCats store soundBtn" id="store_<?php echo $strs->id; ?>">
                            <span class="prodTitle">
                                <?php
                                $store_name = $strs->store_name;
                                echo $store_name;
                                ?>
                            </span>
                        </div>

                        <?php
                        $cats = Items::model()->findAll(array('condition' => 'store=' . $strs->id . ''));

                        if ($cats) {
                            ?>
                            <div class="categoriesOfThisStore" id="cat_store_<?php echo $strs->id; ?>" style="display: none;">
                                <?php
                                foreach ($cats as $cts) {
                                    ?>
                                    <div class="posItemCats categories soundBtn" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>" style="display: none;">
                                        <span class="prodTitle">
                                            <?php
                                            $catagoryName= Cats::model()->nameOfThis($cts->cat);
                                            echo $catagoryName;
                                            ?>
                                        </span>
                                    </div>
                                    <?php
                                    $subCats = Items::model()->findAll(array('condition' => 'cat=' . $cts->cat . ' AND store=' . $strs->id . ' GROUP BY cat_sub ORDER BY cat_sub ASC'));
                                    if ($subCats) {
                                        ?>
                                        <div class="subCatsOfThisCat" id="subCat_cat_store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>" style="display: none;">
                                            <?php
                                            foreach ($subCats as $subCat) {
                                                if ($subCat->cat_sub != "") {
                                                    ?>
                                                    <div class="posItemCats subCategories soundBtn" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>_subCat_<?php echo $subCat->cat_sub;?>">
                                                        <span class="prodTitle">
                                                            <?php
                                                            $subCatName = CatsSub::model()->nameOfThis($subCat->cat_sub);
                                                            echo $subCatName;
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <?php
                                                    $items = Items::model()->findAll(array('condition' => 'cat=' . $cts->cat . ' AND cat_sub=' . $subCat->cat_sub . ' AND store=' . $strs->id . '  ORDER BY name ASC'));
                                                    if ($items) {
                                                        ?>
                                                        <div class="items" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>_subCat_<?php echo $subCat->cat_sub;?>_item" style="display: none;">
                                                            <?php
                                                            foreach ($items as $itms) {
                                                                $costingPrice = CostingPrice::model()->activeCostingPrice($itms->id);

                                                                $id = $itms->id;
                                                                $cat = $catagoryName;
                                                                $catSub = $subCatName;
                                                                $name = $itms->name;
                                                                $code = $itms->code;
                                                                $desc = $itms->desc;
                                                                $unit = $itms->unit;
                                                                $isVatable = $itms->vatable;

                                                                $item = $name . " (" . $code . ")";
                                                                if ($catSub != "")
                                                                    $item.="- " . $catSub;
                                                                $item.="- " . $cat;
                                                                if ($desc != "")
                                                                    $item.="- " . $desc;
                                                                if ($unit != "")
                                                                    $item.="- " . $unit;
                                                                ?>
                                                                <div class="posItemCats itms soundBtn" cost="<?php echo $costingPrice; ?>" id="<?php echo $id; ?>" name="<?php echo $item; ?>">
                                                                    <span class="prodTitle">
                                                                        <?php echo $item; ?>
                                                                    </span>
                                                                    <span class="prodTitlePrice">
                                                                        Cost/Unit: <?php echo $costingPrice; ?>
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
                                                        <div class="items itemsWithNoSubCat" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>_subCat_no_item" style="display: none;">
                                                            <?php
                                                            foreach ($items as $itms) {
                                                                $costingPrice = CostingPrice::model()->activeCostingPrice($itms->id);

                                                                $id = $itms->id;
                                                                $cat = $catName;
                                                                $catSub = "";
                                                                $name = $itms->name;
                                                                $code = $itms->code;
                                                                $desc = $itms->desc;
                                                                $unit = $itms->unit;
                                                                $isVatable = $itms->vatable;

                                                                $item = $name . " (" . $code . ")";
                                                                if ($catSub != "")
                                                                    $item.="- " . $catSub;
                                                                $item.="- " . $cat;
                                                                if ($desc != "")
                                                                    $item.="- " . $desc;
                                                                if ($unit != "")
                                                                    $item.="- " . $unit;
                                                                ?>
                                                                <div class="posItemCats itms soundBtn" cost="<?php echo $costingPrice; ?>" id="<?php echo $id; ?>" name="<?php echo $item; ?>">
                                                                    <span class="prodTitle">
                                                                        <?php echo $item; ?>
                                                                    </span>
                                                                    <span class="prodTitlePrice">
                                                                        Cost/Unit: <?php echo $costingPrice; ?>
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
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'req_by'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'req_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                         <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'approve_by'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'approve_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'department'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'department', CHtml::listData(Departments::model()->findAll(array('order' => 'department_name ASC')), 'id', 'department_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'req_date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'req_date',
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
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'from_store'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'from_store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
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
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'remarks'); ?></td>
                    <td><?php echo $form->textField($model, 'remarks', array('maxlength' => 255, 'class' => 'coloredInput')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('basickSheetRequisition/create', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $(".categories").show();
                        $(".subCatsOfThisCat").hide();
                        $(".items").hide();
                        newArr.length=0;
                        $("#tbl tr.cartList").remove();
                        sl=0;
                        $("#basick-sheet-requisition-form")[0].reset();
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#ajaxLoaderReport").show(); 
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.voucherPreview).show();
                        $("#ajaxLoaderReport").hide();
                        $.fn.yiiGridView.update("basick-sheet-requisition-grid", {
                                data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#basick-sheet-requisition-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#basick-sheet-requisition-form #"+key+"_em_").show();
                        });
                    }       
                }',
                            'beforeSend' => 'function(){  
                    if($("#tbl tr").length<=1){
                        alertify.alert("Warning: Please add items first!");
                        return false;
                    }else if($("#BasickSheetRequisition_req_by").val()==""){
                        alertify.alert("Warning: Please select requisition by !");
                        return false;
                    }else if($("#BasickSheetRequisition_department").val()==""){
                        alertify.alert("Warning: Please select a department !");
                        return false;
                    }else if($("#BasickSheetRequisition_req_date").val()==""){
                        alertify.alert("Warning: Please set requisition date !");
                        return false;
                    }else if($("#BasickSheetRequisition_from_store").val()==""){
                        alertify.alert("Warning: Please select req. from store !");
                        return false;
                    }else if($("#BasickSheetRequisition_store").val()==""){
                        alertify.alert("Warning: Please select req. to store !");
                        return false;
                    }else if($("#BasickSheetRequisition_store").val()==$("#BasickSheetRequisition_from_store").val()){
                        alertify.alert("Warning: Req. from & Req. to location can not be same !");
                        return false;
                    }else if($("#BasickSheetRequisition_remarks").val()==""){
                        alertify.alert("Warning: Please insert remarks !");
                        return false;
                    }else{
                        $("#ajaxLoader").show();
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Store Requisition Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
    var sl=0;
    var newArr=new Array();
    
    function AddNewItem() {
        if($("#Items_id").val()==""){
            alertify.alert("Please select an item !");
        }else{
            var itemsId=$("#Items_id").val();
            var itemsName=$("#item_text").val();

            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#qtyInpt_"+positionOfArrVal).val(newQty);

                var tempQty= $("#qtyInpt_"+positionOfArrVal).val();
                var tempSp= $("#priceInpt_"+positionOfArrVal).val();

                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+positionOfArrVal).val(tempTotal);
                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            }else{
                add(itemsId, itemsName);
                newArr[sl]=itemsId;
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
        
        $(".store").click(function () {
            var thisStoreId = $(this).attr("id");
            $(".store").hide();
           
             $("#cat_" + thisStoreId).show();
              $(".categories").show();
           // alert(thisStoreId);
        });

        $(".categories").click(function () {
            var thisCatId = $(this).attr("id");
            $(".categories").hide();
            $(".subCategories").show();
            $("#subCat_cat_" + thisCatId).show();
            $("#" + thisCatId + "_subCat_no_item").show();
        });
        $(".subCategories").click(function () {
            var thisSubCatId = $(this).attr("id");
            $(".subCategories").hide();
            $(".itemsWithNoSubCat").show();
            $("#" + thisSubCatId + "_item").show();
        });
        $(".main_menuBtn").click(function(){
            $(".store").show();
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
            $("#basick-sheet-requisition-form")[0].reset();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            
            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                   var noOfSack = $("#width_" + positionOfArrVal).val();
                var weghtPerSack = $("#height_" + positionOfArrVal).val();

                var tempTotal = (noOfSack * weghtPerSack);
                $('#qtyInpt_' + positionOfArrVal).val(tempTotal)
//                $("#qtyInpt_"+positionOfArrVal).val(newQty);
            }else{
                add(itemsId, itemsName);
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
        
    });
    
    function add(itemsId, itemsName){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='BasickSheetRequisition[item][]' value='"+itemsId+"'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
             "</td><td>" +
            "<input style='text-align: center;' id='width_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='BasickSheetRequisition[width][]' value='1'>"+
             "</td><td>" +
            "<input style='text-align: center;' id='height_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='BasickSheetRequisition[height][]' value='1'>"+                 
            "</td><td>" +
            "<input style='text-align: center;' id='thickness_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='BasickSheetRequisition[thickness][]' value='1'>"+                 
            "</td><td>" +
               "<select style='text-align: center;width:80px;' id='unit_of_distance_" + sl + "' myAttr1='unit_of_distance_' myAttr2='" + sl + "' type='text' name='BasickSheetRequisition[unit_of_distance][]'><?php
    $unit = UnitDistance::model()->findAll();
    foreach ($unit as $value):

        echo "<option value='$value->id'>$value->unit_of_distance</option>";

    endforeach;
    ?> < /select>" +
                    "</td><td>" +
            
            "<input style='text-align: center;' id='qtyInpt_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='BasickSheetRequisition[qty][]' value='1'>"+
            "</td><td style='text-align: center;'>" +
            "<select style='text-align: center;width:80px;' id='unit_of_weight_" + sl + "' myAttr1='unit_of_weight_' myAttr2='" + sl + "' type='text' name='BasickSheetRequisition[unit_of_weight][]'><?php
    $unit = Units::model()->findAll();
    foreach ($unit as $value):

        echo "<option value='$value->id'>$value->name_of_unit</option>";

    endforeach;
    ?> < /select>" +
                    "</td><td>" +
            
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt); 
//         $('#qtyInpt_'+sl).css("background-color", "#D7D7D7");
//        $('#qtyInpt_'+sl).focus(function () {
//            $(this).blur();
//        });
         calFnc(sl);
             function calFnc(count) {
        $('#width_' + count).bind('keyup', function () {
            var noOfSack = $('#width_' + count).val();
            var weghtPerSack = $('#height_' + count).val();
            var total = (noOfSack * weghtPerSack);
            $('#qtyInpt_' + count).val(total);
            $('#cashTotal').val($('input.lineTotalInpt').sumValues());
        });
        $('#height_' + count).bind('keyup', function () {
                 var noOfSack = $('#width_' + count).val();
            var weghtPerSack = $('#height_' + count).val();
            var total = (noOfSack * weghtPerSack);
            $('#qtyInpt_' + count).val(total);
            $('#cashTotal').val($('input.lineTotalInpt').sumValues());
        });
    }
    } 
</script>
