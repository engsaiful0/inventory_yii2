<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'pos-form',
                'action' => Yii::app()->createUrl('/pos/posReportView'),
            ));
    ?>
    <fieldset>
        <legend>Search Conditions</legend>
        <div class="grid-view" style="float: left;">
            <table class="items">
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Store</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'startDate',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth'=>'true', 
                                'changeYear'=>'true',
                                'dateFormat' => 'yy-mm-dd',
                                'width' => '100',
                            )
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                        ?>
                    </td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig2 = array(
                            'model' => $model,
                            'attribute' => 'endDate',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth'=>'true', 
                                'changeYear'=>'true',
                                'dateFormat' => 'yy-mm-dd',
                                'width' => '100',
                            )
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'store_id', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                </tr>  
                <tr>
                    <th>VOID/Established</th>
                    <th>Counter</th>
                    <th>Cashier</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo $form->dropDownList($model, 'is_void', array(0 => "ESTABLISHED", 1 => "VOID"), array('prompt' => 'Select'));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'machine_id', CHtml::listData(MachineNames::model()->findAll(array("order" => "machine_name ASC")), 'id', 'machine_name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'initiated_by', CHtml::listData(Users::model()->posUsers(), 'id', 'fullName'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                </tr>  
                <tr>
                    <th>Item Category</th>
                    <th>Supplier</th>
                    <th>Item</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'category', CHtml::listData(Cats::model()->findAll(array("order" => "name ASC")), 'id', 'name'), array(
                            'prompt' => 'Select',
                            'ajax' => array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'url' => CController::createUrl('items/itemsOfThisCat'),
                                'success' => 'function(data) {
                                                    $("#Pos_item_id").html(data.items);
                                             }',
                                'data' => array(
                                    'catId' => 'js:jQuery("#Pos_category").val()',
                                ),
                                'beforeSend' => 'function(){
                                                document.getElementById("Pos_item_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                'complete' => 'function(){
                                                document.getElementById("Pos_item_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                            }',
                            ),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'supplier_id', CHtml::listData(Items::model()->existingItemSupplier(), 'supplier_id', 'supplierName'), array(
                            'prompt' => 'Select',
                            'ajax' => array(
                                'type' => 'POST',
                                'dataType' => 'json',
                                'url' => CController::createUrl('items/itemsOfThisSupplier'),
                                'success' => 'function(data) {
                                                    $("#Pos_item_id").html(data.items);
                                             }',
                                'data' => array(
                                    'catId' => 'js:jQuery("#Pos_category").val()',
                                    'supplierId' => 'js:jQuery("#Pos_supplier_id").val()',
                                ),
                                'beforeSend' => 'function(){
                                                document.getElementById("Pos_item_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                'complete' => 'function(){
                                                document.getElementById("Pos_item_id").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                            }',
                            ),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'item_id', CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), 'id', 'nameWithDesc'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                </tr>
                <tr style="border: none;">
                    <td colspan="6" style="text-align: left; border: none;">
                        <?php
                        echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('pos/posReportView', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                $("#ajaxLoader").hide(); 
                                $("#resultDiv").html(data.content);
                            }',
                            'beforeSend' => 'function(){ 
                                if($("#Pos_startDate").val()=="" || $("#Pos_endDate").val()==""){
                                    alertify.alert("Warning! Please select a date range !");
                                    return false;
                                }
                                $("#ajaxLoader").show();
                            }',
                        ));
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<fieldset style="float: left; width: 98%;">
    <legend>Sales Summery <span style=" float: right; margin-left: 8px;"><div id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div><span></legend>
        <div id="resultDiv">

        </div>
</fieldset>
