<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('store-requisition-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gridview/styles.css" type="text/css" media="screen" />
<div class="search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'purchase-order-form',
                'action' => Yii::app()->createUrl('/storeRequisition/storeReqReportView'),
            ));
    ?>
    <fieldset>
        <legend>Search Conditions</legend>
        <div class="grid-view" style="float: left;">
            <table class="items">
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th></th>
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
                    <td></td>
                </tr>
                <tr>
                    <th>Department</th>
                    <th>Store</th>
                    <th>Requisition By</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'department', CHtml::listData(Departments::model()->findAll(array('order' => 'department_name ASC')), 'id', 'department_name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->dropDownList(
                                $model, 'req_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Item Category</th>
                    <th colspan="2">Item</th>
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
                                                    $("#StoreRequisition_item").html(data.items);
                                             }',
                                'data' => array(
                                    'catId' => 'js:jQuery("#StoreRequisition_category").val()',
                                ),
                                'beforeSend' => 'function(){
                                                document.getElementById("StoreRequisition_item").style.background="url(' . Yii::app()->theme->baseUrl . '/images/ajax-loader.gif) no-repeat #FFFFFF 98% 2px";   
                                             }',
                                'complete' => 'function(){
                                                document.getElementById("StoreRequisition_item").style.background="url(' . Yii::app()->theme->baseUrl . '/images/downDrop.png) no-repeat #FFFFFF 98% 2px";
                                            }',
                            ),
                        ));
                        ?>
                    </td>
                    <td colspan="2">
                        <?php
                        echo $form->dropDownList(
                                $model, 'item', CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), 'id', 'nameWithDesc'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                    </td>
                </tr>  
                <tr style="border: none;">
                    <td colspan="3" style="text-align: left; border: none;">
                        <?php
                        echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('storeRequisition/storeReqReportView', 'render' => true)), array(
                            'dataType' => 'json',
                            'type' => 'post',
                            'success' => 'function(data) {
                                $("#ajaxLoader").hide(); 
                                $("#resultDiv").html(data.content);
                            }',
                            'beforeSend' => 'function(){ 
                                if($("#StoreRequisition_startDate").val()=="" || $("#StoreRequisition_endDate").val()==""){
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
    <legend>Store Requisitions <span style=" float: right; margin-left: 8px;"><div id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div><span></legend>
                <div id="resultDiv">

                </div>
                </fieldset>
