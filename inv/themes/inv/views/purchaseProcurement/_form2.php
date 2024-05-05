<?php
$data = PurchaseProcurement::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
if ($data) {
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'purchase-procurement-form',
                'action' => $this->createUrl('PurchaseProcurement/update'),
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true),
            ));
    ?>
<input type="hidden" name="PurchaseProcurement[created_time]" value="<?php echo end($data)->created_time; ?>"/>
<input type="hidden" name="PurchaseProcurement[created_by]" value="<?php echo end($data)->created_by; ?>"/>
<input type="hidden" name="PurchaseProcurement[sl_no]" value="<?php echo end($data)->sl_no; ?>"/>
<input type="hidden" name="PurchaseProcurement[max_sl_no]" value="<?php echo end($data)->max_sl_no; ?>"/>
    <div class="formDiv">
        <fieldset>
            <legend>Purchase Procurement Update Form</legend>
            <div class="scrollable">
                <table class="checkoutTab" id="tbl">
                    <tr>
                        <td colspan="9" style="text-align: left; padding: 6px 0px; font-weight: bold;">
                            Purchase Requisition No: <i><?php echo end($data)->req_no; ?></i>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 32px;">Sl</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Cost</th>
                        <th>Approx. Amount</th>
                        <th>Remarks</th>
                        <th>Remove</th>
                    </tr>
                    <script>
                        var errQtyArr=new Array();
                        var sl=0;
                        var newArr=new Array();
                    </script>
                    <tr></tr>
                    <?php $sl = 1;
                    $cashTotal = 0; ?>
                    <?php foreach ($data as $d) { ?>
                        <?php
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
                            <input type='hidden' name='PurchaseProcurement[id][]' value='<?php echo $d->id; ?>' id="PurchaseProcurement_<?php echo $sl; ?>"/>
                            <?php echo $form->hiddenField($model, 'req_id[]', array('value' => $d->req_id)); ?>
                            <?php echo $form->hiddenField($model, 'item[]', array('value' => $d->item)); ?>
                        <td class='sno' style='text-align: center;'>
                            <?php echo $sl; ?> 
                        </td>
                        <td style='text-align: left; padding-left:2px;'>
                            <?php echo $item; ?> 
                        </td>
                        <td>
                            <input style='text-align: center;' id='qtyInpt_<?php echo $sl; ?>' type='text' name='PurchaseProcurement[qty][]' value='<?php echo $d->qty; ?>'/>
                        </td>
                        <td>
                            <select style='text-align: center;width:70px; ' id='name_of_unit_<?php echo $sl; ?>' myAttr1='name_of_unit_' myAttr2='<?php echo $sl; ?>' type='text' name='PurchaseProcurement[name_of_unit][]'>
                                <option value="<?php echo $d->name_of_unit ?>"><?php echo Units::model()->name_of_unitOfThis($d->name_of_unit); ?></option>
                                <?php
                                $units = Units::model()->findAll();
                                foreach ($units as $value) :
                                    ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->name_of_unit; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td>
                            <input style='text-align: center;' id='costInpt_<?php echo $sl; ?>' type='text' name='PurchaseProcurement[cost][]' value='<?php echo $d->cost; ?>'/>
                        </td>
                        <td>
                            <input style='text-align: center;' id='lineTtlInpt_<?php echo $sl; ?>' class="lineTotalInpt" type='text' value='0'/>
                        </td>
                        <td>
        <?php echo $form->textField($model, 'remarks[]', array('value' => $d->remarks)); ?>
                        </td>
                        <td style='text-align: center;'>
                            <input title="remove" id='<?php echo $sl; ?>' type="button" class="rdelete dltBtn"/>
                        </td>
        <?php $cashTotal = ($d->qty * $d->cost) + $cashTotal; ?>
                        <script type="text/javascript">
                            var sellPrc=$('#costInpt_<?php echo $sl; ?>').val();
                            var sellQnty=$('#qtyInpt_<?php echo $sl; ?>').val();
                            var total=(sellQnty*sellPrc);
                            $('#lineTtlInpt_<?php echo $sl; ?>').val(total);
                            //$('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                            $('#costInpt_<?php echo $sl; ?>').bind('keyup', function() {
                                var sellPrc=$('#costInpt_<?php echo $sl; ?>').val();
                                var sellQnty=$('#qtyInpt_<?php echo $sl; ?>').val();
                                var total=(sellQnty*sellPrc);
                                $('#lineTtlInpt_<?php echo $sl; ?>').val(total);
                                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                            });
                            $('#qtyInpt_<?php echo $sl; ?>').bind('keyup', function() {
                                var sellPrc=$('#costInpt_<?php echo $sl; ?>').val();
                                var sellQnty=$('#qtyInpt_<?php echo $sl; ?>').val();
                                var total=(sellQnty*sellPrc);
                                $('#lineTtlInpt_<?php echo $sl; ?>').val(total);
                                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
                            });
                        </script>
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
                                        'formName' => 'PurchaseProcurement',
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
                                'title' => 'Add New Item',
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
                                    var reqFrom='purchaseProcurement';
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
                    <tr>
                        <td colspan="10" style="padding: 10px 0px;"></td>
                    </tr>
                    <tr>
                        <td>Item/Code/Spec.</td>
                        <td colspan="9">
                            <input type="text" id="item_text"/>
                            <?php echo $form->hiddenField($itemsModel, 'id'); ?>
                            <?php
                                $itemInfoArry='';
                                $itemInfos= Items::model()->findAll(array('order' => 'name ASC'));
                                if($itemInfos){
                                    $itemcount=count($itemInfos);
                                    $i=1;
                                    foreach($itemInfos as $itemInfo){
                                        $costingPrice = CostingPrice::model()->activeCostingPrice($itemInfo->id);
                                        ?>
                                            <input type="hidden" id="item_cost_<?php echo $itemInfo->id; ?>" value="<?php echo $costingPrice; ?>"/>
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
                        <td colspan="10" style="padding: 10px 0px;"></td>
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
                                            $catagoryName = Cats::model()->nameOfThis($cts->cat);
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
                                                    <div class="posItemCats subCategories soundBtn" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>_subCat_<?php echo $subCat->cat_sub; ?>">
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
                                                        <div class="items" id="store_<?php echo $strs->id ?>_cat_<?php echo $cts->cat; ?>_subCat_<?php echo $subCat->cat_sub; ?>_item" style="display: none;">
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
            <?php echo $form->hiddenField($model, 'req_no', array('value' => end($data)->sl_no)); ?>
            <?php echo $form->hiddenField($model, 'department', array('value' => end($data)->department)); ?>
    <?php echo $form->hiddenField($model, 'store', array('value' => end($data)->store)); ?>
            <div class="rightDiv" style="height: 485px;">
                <table>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Total</label></td>
                        <td><input type="text" id="cashTotal" class="coloredInput" value="<?php echo $cashTotal; ?>"/></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'date'); ?></td>
                        <td>
                            <?php
                            $model->date=end($data)->date;
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
                        <td style="text-align: right; padding-right: 6px;"><label>Store</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Stores::model()->storeName(end($data)->store); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Department</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Departments::model()->nameOfThis(end($data)->department); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td>
                            <?php
                            $model->supplier_id=end($data)->supplier_id;
                            echo $form->dropDownList(
                                    $model, 'supplier_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                                'prompt' => 'Select',
                                'style' => 'width: 100%; padding: 10px 0px;',
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                        <td>
                            <?php
                            $model->order_type=end($data)->order_type;
                            echo $form->dropDownList(
                                    $model, 'order_type', Lookup::items("order_type"), array(
                                'prompt' => 'Select',
                                'style' => 'width: 100%; padding: 10px 0px;',
                                'onchange' => 'orderTypeChange(this.value);'
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <ul>
                                <?php $orderSubTypeLocal = Lookup::items2("local"); ?>
                                <?php foreach ($orderSubTypeLocal as $keyLocal => $valueLocal) { ?>
                                    <li class="localOrderSubType" style="display: none;"><input type="radio" name="PurchaseProcurement[order_sub_type]" class="OrderSubType_<?php echo $keyLocal; ?>" value="<?php echo $keyLocal; ?>" id="<?php echo $valueLocal; ?>"/><label for="<?php echo $valueLocal; ?>"><?php echo $valueLocal; ?></label></li>
                                <?php } ?>
                                <?php $orderSubTypeImport = Lookup::items2("import"); ?>
                                <?php foreach ($orderSubTypeImport as $keyImport => $valueImport) { ?>
                                    <li class="importOrderSubType" style="display: none;"><input type="radio" name="PurchaseProcurement[order_sub_type]" class="OrderSubType_<?php echo $keyLocal; ?>" value="<?php echo $keyImport; ?>" id="<?php echo $valueImport; ?>"/><label for="<?php echo $valueImport; ?>"><?php echo $valueImport; ?></label></li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                    </tr>
                                         <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'approve_to'); ?></td>
                    <td>
                        <?php
                        $model->approve_to = end($data)->approve_to;
                        echo $form->dropDownList(
                                $model, 'approve_to', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'procurement_by'); ?></td>
                    <td>
                        <?php
                        $model->procurement_by = end($data)->procurement_by;
                        echo $form->dropDownList(
                                $model, 'procurement_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                    <td colspan="2">
                        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                        <?php
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('purchaseProcurement/update', 'sl_no' => end($data)->sl_no)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                $("#ajaxLoader").hide();  
                                $(".categories").show();
                                $(".subCatsOfThisCat").hide();
                                $(".items").hide();
                                $("#formResultError").hide();
                                $("#formResult").fadeIn();
                                $("#formResult").html("Data saved successfully.");
                                $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                                $("#ajaxLoaderReport").show(); 
                                $("#soReportDialogBox").dialog("open");
                                $("#AjFlashReportSo").html(data.voucherPreview).show();
                                $("#ajaxLoaderReport").hide();      
                            }',
                            'beforeSend' => 'function(){  
                                if($("#tbl tr").length<=1){
                                    alertify.alert("Please add items first!");
                                    e.preventDefault();
                                }else if($("#PurchaseProcurement_date").val()==""){
                                    alertify.alert("Please set date !");
                                    e.preventDefault();
                                }else if($("#PurchaseProcurement_supplier_id").val()==""){
                                    alertify.alert("Supplier can not be empty.");
                                    e.preventDefault();
                                }else if($("#PurchaseProcurement_order_type").val()==""){
                                    alertify.alert("Local/Import can not be empty.");
                                    e.preventDefault();
                                }else if($("#cashTotal").val()==0){
                                    alertify.alert("Please check total amount !");
                                    e.preventDefault();
                                }else{
                                    $("#ajaxLoader").show();
                                }
                         }'
                        ));
                        ?>
                    </td>
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
        <script>
            var orderType="<?php echo end($data)->order_type; ?>";
            var localOrderType="<?php echo PurchaseProcurement::LOCAL; ?>";
            var importOrderType="<?php echo PurchaseProcurement::IMPORT; ?>";
            
            if(orderType==localOrderType){
                $(".localOrderSubType").show();
                $(".importOrderSubType").hide();
            }else if(orderType==importOrderType){
                $(".localOrderSubType").hide();
                $(".importOrderSubType").show();
            }else{
                $(".localOrderSubType").hide();
                $(".importOrderSubType").hide();
            }
            function orderTypeChange($value){
                if($value==localOrderType){
                    $(".localOrderSubType").show();
                    $(".importOrderSubType").hide();
                }else if($value==importOrderType){
                    $(".localOrderSubType").hide();
                    $(".importOrderSubType").show();
                }else{
                    $(".localOrderSubType").hide();
                    $(".importOrderSubType").hide();
                }
            }
        </script>
    </div>
    <?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Purchase Procurement Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

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
        function AddNewItem() {
            if($("#Items_id").val()==""){
                alertify.alert("Please select an item !");
            }else{
                var itemsId=$("#Items_id").val();
                var itemsName=$("#item_text").val();
                var itemCost=$("#item_cost_"+itemsId).val();

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
                    add(itemsId, itemsName, itemCost);
                    newArr[sl]=itemsId;
                }
            }        
        }
 
            
    $(document).ready(function () {
        ion.sound({
            sounds: [
                {name: "beep"}
            ],
            path: "<?php echo Yii::app()->theme->baseUrl; ?>/sounds/",
            preload: true,
            volume: 1.0
        });
        $(".soundBtn").click(function () {
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
        $(".main_menuBtn").click(function () {
            $(".store").show();
            $(".categories").hide();
            $(".subCatsOfThisCat").hide();
            $(".items").hide();
        });
        $(".resetBtn").click(function () {
            $(".store").show();
            $(".categories").hide();
            $(".subCatsOfThisCat").hide();
            $(".items").hide();
            newArr.length = 0;
            $("#tbl tr.cartList").remove();
            sl = 0;
            $("#purchase-requisition-form")[0].reset();
        });
        $(".itms").click(function () {
            var itemsId = $(this).attr("id");
            var itemsName = $(this).attr("name");
            var itemCost = $(this).attr("cost");
            $('#cashTotal').val('0');
            if ($.inArray(itemsId, newArr) > -1) {
                var newQty = 1;
                var positionOfArrVal = newArr.indexOf(itemsId);
                newQty += parseFloat(('0' + $("#qtyInpt_" + positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10);
                $("#qtyInpt_" + positionOfArrVal).val(newQty);
                var tempQty = $("#qtyInpt_" + positionOfArrVal).val();
                var tempSp = $("#costInpt_" + positionOfArrVal).val();
                var tempTotal = (tempQty * tempSp);
                $('#lineTtlInpt_' + positionOfArrVal).val(tempTotal);
                $('#cashTotal').val($('input.lineTotalInpt').sumValues());
            } else {
                add(itemsId, itemsName, itemCost);
                newArr[sl] = itemsId;
            }
        });
           $("input.lineTotalInpt").css("background-color", "#D7D7D7");
            $("input.lineTotalInpt").focus(function(){
                $(this).blur();         
            });
    })
                
        //-----------------------------------------------------
                
        $("#tbl td input.rdelete").live("click", function () {
            if(confirm("Are you sure you want to delete this record ? The record will be deleted parmanently.")){
                var idCounter=$(this).attr("id");
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '<?php echo CController::createUrl('purchaseProcurement/deleteFromUpdate'); ?>',
                    data: { 'id': $("#PurchaseProcurement_"+idCounter).val() },
                    beforeSend:function(){
                        $("#deleteDialogBox").dialog("open");
                        $("#deleteMsg").html("Deleting please wait...").show();
                    },
                    complete: function(){
                        $('#deleteDialogBox').dialog('close').children(':eq(0)').empty();
                    }
                });
                grandTotal=$("#cashTotal").val()-$('#lineTtlInpt_'+idCounter).val();
                $("#cashTotal").val(grandTotal);
                var srow = $(this).parent().parent();
                srow.remove();
                $("#tbl td.sno").each(function(index, element){                 
                    $(element).text(index + 1); 
                });
                newArr[idCounter]=0;
            }
        });
                
        function add(itemsId, itemsName, itemCost){
            sl++;
            var slNumber=$('#tbl tr').length;
                    
            var appendTxt = "<tr class='cartList'>"+
                "<input type='hidden' name='PurchaseProcurement[id][]' value='0'>"+
                "<input type='hidden' name='PurchaseProcurement[req_id][]'>"+
                "<input type='hidden' name='PurchaseProcurement[item][]' value='"+itemsId+"'>"+
                "<td class='sno' style='text-align: center;'>"+
                slNumber +
                "</td><td style='text-align: left; padding-left:2px;'>" + 
                itemsName +
                "</td><td>" +
                "<input style='text-align: center;' id='qtyInpt_"+sl+"' type='text' name='PurchaseProcurement[qty][]' value='1'>"+
                 
                "</td><td>" +
                "<select style='text-align: center;width:80px;' id='name_of_unit_" + sl + "' myAttr1='name_of_unit_' myAttr2='" + sl + "' type='text' name='PurchaseRequisition[name_of_unit][]' value='1'><?php
    $unit = Units::model()->findAll();
    foreach ($unit as $value):

        echo "<option value='$value->id'>$value->name_of_unit</option>";

    endforeach;
    ?> < /select>" +
                    "</td><td>" +
                "<input style='text-align: center;' id='costInpt_"+sl+"' type='text' name='PurchaseProcurement[cost][]' value='"+itemCost+"'>"+
                "</td><td>" +
                "<input style='text-align: center;' id='lineTtlInpt_"+sl+"' class='lineTotalInpt' type='text' value='0'>"+
                "</td><td>" +
                "<input type='text' name='PurchaseProcurement[remarks][]'>"+
                "</td><td style='text-align: center;'>" +
                "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
                "</td></tr>";
            $("#tbl tr:last").after(appendTxt);
            var tempQty= $("#qtyInpt_"+sl).val();
            var tempSp= $("#costInpt_"+sl).val();

            var tempTotal=(tempQty*tempSp);

            $('#lineTtlInpt_'+sl).val(tempTotal);
            $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            calFnc(sl);
            $("input.lineTotalInpt").css("background-color", "#D7D7D7");
            $("input.lineTotalInpt").focus(function(){
                $(this).blur();         
            }); 
        }
            
        function calFnc(count){ 
            $('#costInpt_'+count).bind('keyup', function() {
                var sellPrc=$('#costInpt_'+count).val();
                var sellQnty=$('#qtyInpt_'+count).val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_'+count).val(total);
                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            });
            $('#qtyInpt_'+count).bind('keyup', function() {
                var sellPrc=$('#costInpt_'+count).val();
                var sellQnty=$('#qtyInpt_'+count).val();
                var total=(sellQnty*sellPrc);
                $('#lineTtlInpt_'+count).val(total);
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
    <?php
} else {
    $this->redirect(array('admin'));
}
?>
