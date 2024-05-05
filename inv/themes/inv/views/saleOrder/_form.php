<?php

$form = $this->beginWidget('CActiveForm', array(
            'id' => 'sale-order-form',
            'action' => $this->createUrl('saleOrder/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));

$yourCompanyInfo = YourCompany::model()->findByAttributes(array('is_active' => YourCompany::ACTIVE,));
if ($yourCompanyInfo) {
    $yourCompanyName = $yourCompanyInfo->company_name;
    $yourCompanyVatRegNo = $yourCompanyInfo->vat_regi_no;
    $yourCompanyLocation = $yourCompanyInfo->location;
    $yourCompanyContact = $yourCompanyInfo->contact;
    $yourCompanyEmail = $yourCompanyInfo->email;
    $yourCompanyWeb = $yourCompanyInfo->web;
    $yourCompanyVat=$yourCompanyInfo->vat_amount;
} else {
    $yourCompanyName = '';
    $yourCompanyVatRegNo = '';
    $yourCompanyLocation = '';
    $yourCompanyContact = '';
    $yourCompanyEmail = '';
    $yourCompanyWeb = '';
    $yourCompanyVat='';
}
?>
<div class="formDiv">
    <fieldset>
        <legend>Sale Order Form</legend>
        <div class="scrollable">
            <table class="checkoutTab" id="tbl">
                <tr>
                    <th style="width: 32px;">Sl</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Convertable Unit</th>
                    <th>Converted Qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
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
                        echo CHtml::submitButton('Search Items / Default', array(
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
                                    'formName' => 'SaleOrder',
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
//                        echo CHtml::submitButton('SFT', array(
//                            'ajax' => array(
//                                'type' => 'POST',
//                                'dataType' => 'json',
//                                'url' => CController::createUrl('items/itemsOfThis'),
//                                'success' => 'function(data) {
//                                                $("#itemsWithCat").html(data.content);
//                                         }',
//                                'data' => array(
//                                    'supplier_id' => 'js:jQuery("#Items_supplier_id").val()',
//                                    'pbrand' => 'js:jQuery("#Items_pbrand").val()',
//                                    'pmodel' => 'js:jQuery("#Items_pmodel").val()',
//                                    'country' => 'js:jQuery("#Items_country").val()',
//                                    'product_type' => 'js:jQuery("#Items_product_type").val()',
//                                    'grade' => 'js:jQuery("#Items_grade").val()',
//                                    'mfi' => 'js:jQuery("#Items_mfi").val()',
//                                    'formName' => 'UnitConvert',
//                                    'unitConvertFrom' => 'sft',
//                                ),
//                                'beforeSend' => 'function(){
//                                                    $("#ajaxLoaderSearch").show();  
//                                         }',
//                                'complete' => 'function(){
//                                                    $("#ajaxLoaderSearch").hide();
//                                        }',
//                            ),
//                                )
//                        );
                        ?>
                    </td>
                    <td rowspan="2">
                        <?php
//                        echo CHtml::submitButton('RFT', array(
//                            'ajax' => array(
//                                'type' => 'POST',
//                                'dataType' => 'json',
//                                'url' => CController::createUrl('items/itemsOfThis'),
//                                'success' => 'function(data) {
//                                                $("#itemsWithCat").html(data.content);
//                                         }',
//                                'data' => array(
//                                    'supplier_id' => 'js:jQuery("#Items_supplier_id").val()',
//                                    'pbrand' => 'js:jQuery("#Items_pbrand").val()',
//                                    'pmodel' => 'js:jQuery("#Items_pmodel").val()',
//                                    'country' => 'js:jQuery("#Items_country").val()',
//                                    'product_type' => 'js:jQuery("#Items_product_type").val()',
//                                    'grade' => 'js:jQuery("#Items_grade").val()',
//                                    'mfi' => 'js:jQuery("#Items_mfi").val()',
//                                    'formName' => 'UnitConvert',
//                                    'unitConvertFrom' => 'rft',
//                                ),
//                                'beforeSend' => 'function(){
//                                                    $("#ajaxLoaderSearch").show();  
//                                         }',
//                                'complete' => 'function(){
//                                                    $("#ajaxLoaderSearch").hide();
//                                        }',
//                            ),
//                                )
//                        );
                        ?>
                    </td>
                    <td rowspan="2">
                        <?php
//                        echo CHtml::submitButton('Inch', array(
//                            'ajax' => array(
//                                'type' => 'POST',
//                                'dataType' => 'json',
//                                'url' => CController::createUrl('items/itemsOfThis'),
//                                'success' => 'function(data) {
//                                                $("#itemsWithCat").html(data.content);
//                                         }',
//                                'data' => array(
//                                    'supplier_id' => 'js:jQuery("#Items_supplier_id").val()',
//                                    'pbrand' => 'js:jQuery("#Items_pbrand").val()',
//                                    'pmodel' => 'js:jQuery("#Items_pmodel").val()',
//                                    'country' => 'js:jQuery("#Items_country").val()',
//                                    'product_type' => 'js:jQuery("#Items_product_type").val()',
//                                    'grade' => 'js:jQuery("#Items_grade").val()',
//                                    'mfi' => 'js:jQuery("#Items_mfi").val()',
//                                    'formName' => 'UnitConvert',
//                                    'unitConvertFrom' => 'inch',
//                                ),
//                                'beforeSend' => 'function(){
//                                                    $("#ajaxLoaderSearch").show();  
//                                         }',
//                                'complete' => 'function(){
//                                                    $("#ajaxLoaderSearch").hide();
//                                        }',
//                            ),
//                                )
//                        );
                        ?>
                    </td>
                    <td rowspan="2">
                        <?php
//                        echo CHtml::submitButton('CFT', array(
//                            'ajax' => array(
//                                'type' => 'POST',
//                                'dataType' => 'json',
//                                'url' => CController::createUrl('items/itemsOfThis'),
//                                'success' => 'function(data) {
//                                                $("#itemsWithCat").html(data.content);
//                                         }',
//                                'data' => array(
//                                    'supplier_id' => 'js:jQuery("#Items_supplier_id").val()',
//                                    'pbrand' => 'js:jQuery("#Items_pbrand").val()',
//                                    'pmodel' => 'js:jQuery("#Items_pmodel").val()',
//                                    'country' => 'js:jQuery("#Items_country").val()',
//                                    'product_type' => 'js:jQuery("#Items_product_type").val()',
//                                    'grade' => 'js:jQuery("#Items_grade").val()',
//                                    'mfi' => 'js:jQuery("#Items_mfi").val()',
//                                    'formName' => 'UnitConvert',
//                                    'unitConvertFrom' => 'cft',
//                                ),
//                                'beforeSend' => 'function(){
//                                                    $("#ajaxLoaderSearch").show();  
//                                         }',
//                                'complete' => 'function(){
//                                                    $("#ajaxLoaderSearch").hide();
//                                        }',
//                            ),
//                                )
//                        );
                        ?>
                    </td>
                    <td rowspan="2">
                        <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                         'title'=>'Add New Item',
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
                            var reqFrom='saleOrder';
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
                    <td colspan="14" style="padding: 10px 0px;"></td>
                </tr>
                <tr>
                    <td>Item/Code/Spec.</td>
                    <td colspan="14">
                        <input type="text" id="item_text"/>
                        <?php echo $form->hiddenField($itemsModel, 'id'); ?>
                        <?php
                            $itemInfoArry='';
                            $itemInfos= Items::model()->findAll(array('order' => 'name ASC'));
                            if($itemInfos){
                                $itemcount=count($itemInfos);
                                $i=1;
                                foreach($itemInfos as $itemInfo){
                                    $costingPrice = SellingPrice::model()->activeSellingPrice($itemInfo->id);
                                    $id=$itemInfo->id;
                                    $cat=Cats::model()->nameOfThis($itemInfo->cat);
                                    $catSub=CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                                    $name=$itemInfo->name;
                                    $code=$itemInfo->code;
                                    $desc=$itemInfo->desc;
                                    $unit=$itemInfo->unit;
                                    $isVatable = $itemInfo->vatable;
                                    $unitConvertable = $itemInfo->unit_convertable;
                                    
                                    $item=$name." (".$code.")";
                                    if($catSub!="")
                                        $item.="- ".$catSub;
                                    $item.="- ".$cat;
                                    if($desc!="")
                                        $item.="- ".$desc;
                                    if($unit!="")
                                        $item.="- ".$unit;

                                    $convertedUnit=Items::model()->convertedUnit($unitConvertable, $desc);
                                    ?>
                                    <div style="display: none;" id="item_info_<?php echo $itemInfo->id; ?>" 
                                            sft="<?php echo $convertedUnit[0]; ?>" 
                                            rft="<?php echo $convertedUnit[1]; ?>"
                                            cft="<?php echo $convertedUnit[2]; ?>"
                                            sqm="<?php echo $convertedUnit[3]; ?>"
                                            unitConv="<?php echo $unitConvertable; ?>" 
                                            cost="<?php echo $costingPrice; ?>"></div>
                                    <?php
                                    
                                    $itemInfoArry.='{value: '.$id.', label: "'.  CHtml::encode($item).'"}';
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
                    <td colspan="14" style="padding: 10px 0px;"></td>
                </tr>
            </table>
        </div>
        <div class="touchWrapper" style="height: 470px;">
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
                                                    $costingPrice = SellingPrice::model()->activeSellingPrice($itms->id);
                                                    
                                                    $id=$itms->id;
                                                    $cat=$catName;
                                                    $catSub=$subCatName;
                                                    $name=$itms->name;
                                                    $code=$itms->code;
                                                    $desc=$itms->desc;
                                                    $unit=$itms->unit;
                                                    $isVatable = $itms->vatable;
                                                    $unitConvertable = $itms->unit_convertable;
                                                    
                                                    $item=$name." (".$code.")";
                                                    if($catSub!="")
                                                        $item.="- ".$catSub;
                                                    $item.="- ".$cat;
                                                    if($desc!="")
                                                        $item.="- ".$desc;
                                                    if($unit!="")
                                                        $item.="- ".$unit;
                                                    
                                                    $convertedUnit=Items::model()->convertedUnit($unitConvertable, $desc);
                                                    ?>
                                                    <div class="posItemCats itms soundBtn"
                                                        sft="<?php echo $convertedUnit[0]; ?>" 
                                                        rft="<?php echo $convertedUnit[1]; ?>"
                                                        cft="<?php echo $convertedUnit[2]; ?>"
                                                        sqm="<?php echo $convertedUnit[3]; ?>"
                                                        unitConv="<?php echo $unitConvertable; ?>" 
                                                        cost="<?php echo $costingPrice; ?>" 
                                                        id="<?php echo $id; ?>" 
                                                        name="<?php echo $item; ?>">
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
                                                    $costingPrice = SellingPrice::model()->activeSellingPrice($itms->id);
                                                    
                                                    $id=$itms->id;
                                                    $cat=$catName;
                                                    $catSub="";
                                                    $name=$itms->name;
                                                    $code=$itms->code;
                                                    $desc=$itms->desc;
                                                    $unit=$itms->unit;
                                                    $isVatable = $itms->vatable;
                                                    $unitConvertable = $itms->unit_convertable;
                                                    
                                                    $item=$name." (".$code.")";
                                                    if($catSub!="")
                                                        $item.="- ".$catSub;
                                                    $item.="- ".$cat;
                                                    if($desc!="")
                                                        $item.="- ".$desc;
                                                    if($unit!="")
                                                        $item.="- ".$unit;
                                                    
                                                    $convertedUnit=Items::model()->convertedUnit($unitConvertable, $desc);
                                                    ?>
                                                     <div class="posItemCats itms soundBtn"
                                                        sft="<?php echo $convertedUnit[0]; ?>" 
                                                        rft="<?php echo $convertedUnit[1]; ?>"
                                                        cft="<?php echo $convertedUnit[2]; ?>"
                                                        sqm="<?php echo $convertedUnit[3]; ?>"
                                                        unitConv="<?php echo $unitConvertable; ?>" 
                                                        cost="<?php echo $costingPrice; ?>" 
                                                        id="<?php echo $id; ?>" 
                                                        name="<?php echo $item; ?>">
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
        <div class="rightDiv" style="height: 470px;">
            <table>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><label>Total</label></td>
                    <td><input type="text" id="cashTotal" class="coloredInput"/></td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'subj'); ?></td>
                    <td><?php echo $form->textField($model, 'subj', array('maxlength' => 255, 'class' => 'coloredInput')); ?></td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'issue_date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'issue_date',
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
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'expected_d_date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig2 = array(
                            'model' => $model,
                            'attribute' => 'expected_d_date',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array("class" => "coloredInput"),
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'order_type2'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'order_type2', Lookup::items("order_type2"), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'pi_no'); ?></td>
                    <td><?php echo $form->textField($model, 'pi_no', array('maxlength' => 255, 'class' => 'coloredInput')); ?></td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'pi_date'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig3 = array(
                            'model' => $model,
                            'attribute' => 'pi_date',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                                'dateFormat' => 'yy-mm-dd',
                            ),
                            'htmlOptions' => array("class" => "coloredInput"),
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig3);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'customer_id', CHtml::listData(Customers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                              'ajax' => array(
                                    'type' => 'POST',
                                    'dataType' => 'json',
                                    'url' => CController::createUrl('customerContactPersons/contactPersonsOfThis'),
                                    'success' => 'function(data) {
                                                $("#SaleOrder_contact_person").html(data.personList);
                                         }',
                                    'data' => array(
                                        'customer_id' => 'js:jQuery("#SaleOrder_customer_id").val()',
                                    ),
                                    'beforeSend' => 'function(){
                                                    document.getElementById("SaleOrder_contact_person").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 100% 1px";   
                                         }',
                                    'complete' => 'function(){
                                                    document.getElementById("SaleOrder_contact_person").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                        }',
                                ),
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'contact_person'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'contact_person', array(), array(
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
                    <td style="text-align: right; padding-righ: 6px;"><?php echo $form->labelEx($model, 'sales_by'); ?></td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'sales_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'full_name'), array(
                            'prompt' => 'Select',
                            'style' => 'width: 100%;',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'created_by'); ?></td>
                    <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Users::model()->fullNameOfThis(Yii::app()->user->id); ?></td>
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
                        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('saleOrder/create', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        errQtyArr.length=0;
                        $(".categories").show();
                        $(".subCatsOfThisCat").hide();
                        $(".items").hide();
                        newArr.length=0;
                        $("#tbl tr.cartList").remove();
                        sl=0;
                        $("#sale-order-form")[0].reset();
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $("#ajaxLoaderReport").show(); 
                        $("#soReportDialogBox").dialog("open");
                        $("#AjFlashReportSo").html(data.voucherPreview).show();
                        $("#ajaxLoaderReport").hide();
                        $.fn.yiiGridView.update("sale-order-grid", {
                                data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#sale-order-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#sale-order-form #"+key+"_em_").show();
                        });
                    }       
                }',
                'beforeSend' => 'function(){  
                        if($("#tbl tr").length<=1){
                            alertify.alert("Please add items first!");
                            return false;
                        }else if($("#SaleOrder_issue_date").val()==""){
                            alertify.alert("Please set issue date !");
                            return false;
                        }else if($("#SaleOrder_order_type2").val()==""){
                            alertify.alert("Please select local/export !");
                            return false;
                        }else if($("#SaleOrder_customer_id").val()==""){
                            alertify.alert("Please select a customer !");
                            return false;
                        }else if($("#SaleOrder_store").val()==""){
                            alertify.alert("Please select a store !");
                            return false;
                        }else if($("#SaleOrder_sales_by").val()==""){
                            alertify.alert("Please select a sales person !");
                            return false;
                        }else if($("#cashTotal").val()==0){
                            alertify.alert("Please check total amount !");
                            return false;
                        }else{
                              $("#ajaxLoader").show();
//                            for(var i=1; i<($("#tbl tr").length); i++){
//                                if($("#orderSpec_"+i).val()==""){
//                                    $("#orderSpec_"+i).css("border-color","red");
//                                    errQtyArr[i]="err_exist";
//                                }else{
//                                    $("#orderSpec_"+i).css("border-color","#aaa");
//                                    errQtyArr[i]="";
//                                }
//                            }
//                            if($.inArray("err_exist", errQtyArr)>-1){
//                                alertify.alert("There is an empty field on items order specification column !");
//                                return false;
//                            }else{
//                                $("#ajaxLoader").show();
//                            }
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
        'title' => 'Sale Order Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<style>
    input.coloredInput[type="text"] {
        padding: 5px 0;
    }
</style>
<script>
    var errQtyArr=new Array();
    var sl=0;
    var newArr=new Array();
    
    var sftVal="<?php echo Items::SFT; ?>";
    var rftVal="<?php echo Items::RFT; ?>";
    var cftVal="<?php echo Items::CFT; ?>";
    var sqmVal="<?php echo Items::SQM; ?>";
    
    function AddNewItem() {
        if($("#Items_id").val()==""){
            alertify.alert("Please select an item !");
        }else{
            var itemsId=$("#Items_id").val();
            var itemsName=$("#item_text").val();
            var itemCost=$("#item_info_"+itemsId).attr("cost");
            var itemUnitConv=$("#item_info_"+itemsId).attr("unitConv");
            var sft=$("#item_info_"+itemsId).attr("sft");
            var rft=$("#item_info_"+itemsId).attr("rft");
            var cft=$("#item_info_"+itemsId).attr("cft");
            var sqm=$("#item_info_"+itemsId).attr("sqm");
            
            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#qtyInpt_"+positionOfArrVal).val(newQty);
                
                var tempQty= $("#qtyInpt_"+positionOfArrVal).val();
                var tempSp= $("#priceInpt_"+positionOfArrVal).val();
                
                var selectedValue=$("#unitSelect_"+positionOfArrVal).val();
                if(selectedValue==sftVal){
                    tempQty=sft;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"SFT");
                }else if(selectedValue==rftVal){
                    tempQty=rft;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"RFT");
                }else if(selectedValue==cftVal){
                    tempQty=cft*tempQty;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"CFT");
                }else if(selectedValue==sqmVal){
                    tempQty=sqm;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"SQM");
                }else{
                    $("#convertedText_"+positionOfArrVal).html("");
                }
            
                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+positionOfArrVal).val(tempTotal);
                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            }else{
                add(itemsId, itemsName, itemCost, itemUnitConv, sft, rft, cft, sqm);
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
            $("#sale-order-form")[0].reset();
        });
        
        $(".itms").click(function(){
            var itemsId=$(this).attr("id");
            var itemsName=$(this).attr("name");
            var itemCost=$(this).attr("cost");
            var itemUnitConv=$(this).attr("unitConv");
            var sft=$(this).attr("sft");
            var rft=$(this).attr("rft");
            var cft=$(this).attr("cft");
            var sqm=$(this).attr("sqm");
            
            $('#cashTotal').val('0');
            
            if($.inArray(itemsId, newArr) > -1){
                var newQty=1;
                var positionOfArrVal=newArr.indexOf(itemsId);
                newQty+=parseFloat( ('0' + $("#qtyInpt_"+positionOfArrVal).val()).replace(/[^0-9-\.]/g, ''), 10 );
                $("#qtyInpt_"+positionOfArrVal).val(newQty);
                
                var tempQty= $("#qtyInpt_"+positionOfArrVal).val();
                var tempSp= $("#priceInpt_"+positionOfArrVal).val();
                
                var selectedValue=$("#unitSelect_"+positionOfArrVal).val();
                if(selectedValue==sftVal){
                    tempQty=sft;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"SFT");
                }else if(selectedValue==rftVal){
                    tempQty=rft;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"RFT");
                }else if(selectedValue==cftVal){
                    tempQty=cft*tempQty;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"CFT");
                }else if(selectedValue==sqmVal){
                    tempQty=sqm;
                    $("#convertedText_"+positionOfArrVal).html(tempQty+"SQM");
                }else{
                    $("#convertedText_"+positionOfArrVal).html("");
                }
            
                var tempTotal=(tempQty*tempSp);
                $('#lineTtlInpt_'+positionOfArrVal).val(tempTotal);
                $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
            }else{
                add(itemsId, itemsName, itemCost, itemUnitConv, sft, rft, cft, sqm);
                newArr[sl]=itemsId;
            }
        });
    })
    
    //-----------------------------------------------------
    
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
        errQtyArr[idCounter]="";
    });
    
    function add(itemsId, itemsName, itemCost, itemUnitConv, sft, rft, cft, sqm){
        sl++;
        var slNumber=$('#tbl tr').length;
        
        var appendTxt = "<tr class='cartList'>"+
            "<input type='hidden' name='SaleOrder[item][]' value='"+itemsId+"'>"+
            "<td class='sno' style='text-align: center;'>"+
            slNumber +
            "</td><td style='text-align: left; padding-left:2px;'>" + 
            itemsName +
             "</td><td>" +
            "<input style='text-align: center;' id='qtyInpt_"+sl+"' myAttr1='qtyInpt_' myAttr2='"+sl+"' type='text' name='SaleOrder[qty][]' value='1'>"+
            "</td><td>" +
            "<select name='SaleOrder[conv_unit][]' id='unitSelect_"+sl+"'><option value=''>Select</option><option value='"+sftVal+"'>SFT</option><option value='"+rftVal+"'>RFT</option><option value='"+cftVal+"'>CFT</option><option value='"+sqmVal+"'>SQM</option></select>"+
            "</td><td>" +
            "<span id='convertedText_"+sl+"'></span>"+
            "</td><td>" +
            "<input style='text-align: center;' id='priceInpt_"+sl+"' myAttr1='priceInpt_' myAttr2='"+sl+"' type='text' name='SaleOrder[price][]' value='"+itemCost+"'>"+
            "</td><td>" +
            "<input style='text-align: center;' id='lineTtlInpt_"+sl+"' class='lineTotalInpt' type='text' value='0'>"+
            "</td><td style='text-align: center;'>" +
            "<input title=\"remove\" id='"+sl+"' type=\"button\" class=\"rdelete dltBtn\"/>"+
            "</td></tr>";
        $("#tbl tr:last").after(appendTxt); 
        
        var tempQty= $("#qtyInpt_"+sl).val();
        var tempSp= $("#priceInpt_"+sl).val();
        var tempTotal=(tempQty*tempSp);
        $('#lineTtlInpt_'+sl).val(tempTotal);
        $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
        
        calFnc(sl, sft, rft, cft, sqm);
        
        if(itemUnitConv==0){
            $("#unitSelect_"+sl).css("background-color", "#D7D7D7");
            $("#unitSelect_"+sl).focus(function(){
                $(this).blur();         
            }); 
         }
        $("input.lineTotalInpt").css("background-color", "#D7D7D7");
        $("input.lineTotalInpt").focus(function(){
            $(this).blur();         
        }); 
    }
    
    function calFnc(count, sft, rft, cft, sqm){ 
        $("#unitSelect_"+count).change(function(){
            var selectedValue=$("#unitSelect_"+count).val();
            var sellPrc=$('#priceInpt_'+count).val();
            var sellQnty=$('#qtyInpt_'+count).val();
            
            var selectedValue=$("#unitSelect_"+count).val();
            if(selectedValue==sftVal){
                sellQnty=sft;
                $("#convertedText_"+count).html(sellQnty+" SFT");
            }else if(selectedValue==rftVal){
                sellQnty=rft;
                $("#convertedText_"+count).html(sellQnty+" RFT");
            }else if(selectedValue==cftVal){
                sellQnty=cft*sellQnty;
                $("#convertedText_"+count).html(sellQnty+" CFT");
            }else if(selectedValue==sqmVal){
                sellQnty=sqm;
                $("#convertedText_"+count).html(sellQnty+" SQM");
            }else{
                $("#convertedText_"+count).html("");
            }
            
            var total=(sellQnty*sellPrc);
            $('#lineTtlInpt_'+count).val(total);
            $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
        });
        
        
        $('#priceInpt_'+count).bind('keyup', function() {
            var selectedValue=$("#unitSelect_"+count).val();
            var sellPrc=$('#priceInpt_'+count).val();
            var sellQnty=$('#qtyInpt_'+count).val();
            
            var selectedValue=$("#unitSelect_"+count).val();
            if(selectedValue==sftVal){
                sellQnty=sft;
                $("#convertedText_"+count).html(sellQnty+" SFT");
            }else if(selectedValue==rftVal){
                sellQnty=rft;
                $("#convertedText_"+count).html(sellQnty+" RFT");
            }else if(selectedValue==cftVal){
                sellQnty=cft*sellQnty;
                $("#convertedText_"+count).html(sellQnty+" CFT");
            }else if(selectedValue==sqmVal){
                sellQnty=sqm;
                $("#convertedText_"+count).html(sellQnty+" SQM");
            }else{
                $("#convertedText_"+count).html("");
            }
            
            var total=(sellQnty*sellPrc);
            $('#lineTtlInpt_'+count).val(total);
            $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );
        });
        $('#qtyInpt_'+count).bind('keyup', function() {
            var selectedValue=$("#unitSelect_"+count).val();
            var sellPrc=$('#priceInpt_'+count).val();
            var sellQnty=$('#qtyInpt_'+count).val();
            
            var selectedValue=$("#unitSelect_"+count).val();
            if(selectedValue==sftVal){
                sellQnty=sft;
                $("#convertedText_"+count).html(sellQnty+" SFT");
            }else if(selectedValue==rftVal){
                sellQnty=rft;
                $("#convertedText_"+count).html(sellQnty+" RFT");
            }else if(selectedValue==cftVal){
                sellQnty=cft*sellQnty;
                $("#convertedText_"+count).html(sellQnty+" CFT");
            }else if(selectedValue==sqmVal){
                sellQnty=sqm;
                $("#convertedText_"+count).html(sellQnty+" SQM");
            }else{
                $("#convertedText_"+count).html("");
            }
            
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
