<?php
//$data = ProductionInput::model()->findAll(array("condition" => "sl_no='" . $sl_no . "'"));
if ($data) {
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'production-output-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    ));
    ?>
    <div class="formDiv">
        <fieldset>
            <legend>Production Output Form</legend>
            <div class="scrollable">
                <table class="checkoutTab" id="tbl">
                    <tr>
                        <td colspan="5" style="text-align: left; padding: 6px 0px; font-weight: bold;">
                            Production Input No: <i><?php echo end($data)->sl_no; ?></i>
                            <br/>Date: <i><?php echo end($data)->date; ?></i>
                            <br/>Time: <i><?php echo end($data)->time; ?></i>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 32px;">Sl</th>
                        <th>Output/Batch No</th>
                        <th>Item</th>
                        <th>Input Qty</th>
                        <th>Input Qty(Kg)</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $totalQtyKg = 0;
                    ?>
    <?php foreach ($data as $d) { ?>
                        <tr class='cartList'>
                            <td class='sno' style='text-align: center;'>
                                <input type='hidden' name='ProductionInput[id][]' value='<?php echo $d->id; ?>'/>
        <?php echo $sl; ?> 
                            </td>
                            <td style='padding-left:2px; text-align: left;'>
        <?php echo $d->track_no; ?> 
                            </td>
                            <td style='text-align: left; padding-left:2px;'>
        <?php echo Items::model()->item($d->item); ?> 
                            </td>
                            <td>
        <?php echo $d->qty; ?>
                            </td>
                            <td>
                                <?php
                                echo number_format(floatval($d->qty_kg), 2);
                                $totalQtyKg = $d->qty_kg + $totalQtyKg;
                                ?> 
                                <input id="input_qty" type="hidden" value="<?php echo $d->qty_kg?>">
                            </td>
                        </tr>
        <?php $sl++; ?>
    <?php } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td style="font-weight: bold; color: teal;">Total</td>
                        <td style="font-weight: bold; color: teal;"><?php echo number_format(floatval($totalQtyKg), 2); ?></td>
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
                                        'formName' => 'ProductionOutput',
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
                                function addNewItemItem() {
                                    var reqFrom = 'productionOutput';
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
                                    $('#ProductionOutput_item').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
            <div class="touchWrapper" style="height: 485px;">
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
                                                        <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $subCatName; ?> - <?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
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
                                                        <div class="posItemCats itms soundBtn" id="<?php echo $itms->id; ?>" name="<?php echo $itms->name; ?><br><?php echo $catName; ?>" qtyUnit="<?php echo $itms->unit; ?>" desc="<?php echo $itms->desc; ?>">
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
            <div class="rightDiv" style="height: 485px;">
                <table>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'item'); ?></td>
                        <td>
                            <?php
                            echo $form->dropDownList(
                                    $model, 'item', CHtml::listData(Items::model()->findAll(array('order' => 'name ASC')), 'id', 'nameWithUnit'), array(
                                'prompt' => 'Select',
                                'style' => 'width: 100%; padding: 10px 0px;',
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'unit_of_distance'); ?></td>
                        <td>
                            <?php
                            echo $form->dropDownList(
                                    $model, 'unit_of_distance', CHtml::listData(UnitDistance::model()->findAll(array('order' => 'id ASC')), 'id', 'unit_of_distance'), array(
                                'prompt' => 'Select',
                                'style' => 'width: 100%; padding: 10px 0px;',
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'unit_of_distance'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'length'); ?></td>
                        <td>
    <?php echo $form->textField($model, 'length', array("class" => "coloredInput")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'length'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'width'); ?></td>
                        <td>
    <?php echo $form->textField($model, 'width', array("class" => "coloredInput")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'width'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'thickness'); ?></td>
                        <td>
    <?php echo $form->textField($model, 'thickness', array("class" => "coloredInput")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'thickness'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'qty'); ?></td>
                        <td>
    <?php echo $form->textField($model, 'qty', array("class" => "coloredInput")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo $form->error($model, 'qty'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'qty_kg'); ?></td>
                        <td>
    <?php echo $form->textField($model, 'qty_kg', array("id"=>"qty_kg","class" => "coloredInput")); ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php //echo $form->error($model, 'qty_kg'); ?></td>
                    </tr>
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
                        <td></td>
                        <td><?php echo $form->error($model, 'date'); ?></td>
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
                        <td></td>
                        <td><?php echo $form->error($model, 'time'); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Store</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Stores::model()->storeName(end($data)->store); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding-right: 6px;"><label>Machine</label></td>
                        <td style="font-weight: bold; color: #aaa; font-style: italic;"><?php echo Machines::model()->nameOfThis(end($data)->machine); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="main_menuBtn soundBtn">Main Menu</span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
                            <?php
                            echo CHtml::submitButton('Save', array('onclick' => 'loadingDivDisplay();'));
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
    <style>
        div.errorMessage {
            color: springgreen;
        }
    </style>
    <script>
        $('#qty_kg').bind('keyup', function() {
                                    var qty_kg=parseFloat( ('0' + $('#qty_kg').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                    var input_qty=parseFloat( ('0' + $('#input_qty').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                    
                                    
                                    if(input_qty<qty_kg){
                                        alertify.alert("Warning! Output  Quantity Kg exceeds");
                                        $('#qty_kg').val(input_qty);
                                    }     
                                });
        $.fn.sumValues = function () {
            var sum = 0;
            this.each(function () {
                if ($(this).is(':input')) {
                    var val = $(this).val();
                } else {
                    var val = $(this).text();
                }
                sum += parseFloat(('0' + val).replace(/[^0-9-\.]/g, ''), 10);
            });
            return sum;
        };
        function loadingDivDisplay(e) {
            $("#ajaxLoaderMR").show();
        }
        function closeMe() {
            window.opener = self;
            window.close();
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

            $(".categories").click(function () {
                var thisCatId = $(this).attr("id");
                $(".categories").hide();
                $(".subCategories").show();
                $("#subCat_" + thisCatId).show();
                $("#" + thisCatId + "_subCat_no_item").show();
            });
            $(".subCategories").click(function () {
                var thisSubCatId = $(this).attr("id");
                $(".subCategories").hide();
                $(".itemsWithNoSubCat").hide();
                $("#" + thisSubCatId + "_item").show();
            });
            $(".main_menuBtn").click(function () {
                $(".categories").show();
                $(".subCatsOfThisCat").hide();
                $(".items").hide();
            });

            $(".resetBtn").click(function () {
                $(".categories").show();
                $(".subCatsOfThisCat").hide();
                $(".items").hide();
                $("#production-output-form")[0].reset();
            });

            $(".itms").click(function () {
                var itemsId = $(this).attr("id");
                $("#ProductionOutput_item").val(itemsId);
                $("#ProductionOutput_qty").val(1);
            });
        })
    </script>
    <?php
} else {
    $this->redirect(array('/productionInput/adminOutput'));
}
?>
