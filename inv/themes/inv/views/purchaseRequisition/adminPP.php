<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-requisition-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"purchase-requisition-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('purchase-requisition-search-form').action='deleteall';
                document.getElementById('purchase-requisition-search-form').submit();
        }
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Requisition</legend>
    <table>
        <tr>
            <td>
                <label>Requisition No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('purchaseRequisition/requisitionPreview'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       $('#ajaxLoaderReport').show();
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                                           $('#ajaxLoaderReport').hide(); 
                    }",
                    'data' => array('sl_no' => 'js:jQuery("#soForReport").val()')
                        ), array(
                    'href' => Yii::app()->createUrl('purchaseRequisition/requisitionPreview'),
                    'class' => 'additionalBtn'
                        )
                );
                ?>
                <span id="ajaxLoaderReport" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            </td>
        </tr>
    </table>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Purchase Requisition Preview',
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
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
?>
<fieldset style="float: left; width: 98%;">
    <legend>Create Procurement from Purchase Requisitions</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-requisition-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
             array(
                'name' => 'is_pp_created',
                'value' => 'PurchaseRequisition::model()->isPPcreated($data->is_pp_created)',
                'filter'=>array(1 => "PP Created", 0 => "Not Created"),
            ),
            'sl_no',
            'date',
            array(
                'name' => 'department',
                'value' => 'Departments::model()->nameOfThis($data->department)',
                'filter' => CHtml::listData(Departments::model()->findAll(array('order'=>'department_name ASC')), 'id', 'department_name'),
            ),
            array(
                'name' => 'store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), "id", "nameWithDesc"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'qty',
             array(
                'name' => 'name_of_unit',
                'value' => 'Units::model()->name_of_unitOfThis($data->name_of_unit)',
                'filter' => CHtml::listData(Units::model()->findAll(array('order'=>'name_of_unit ASC')), 'id', 'name_of_unit'),
            ),
            'cost',
            array(
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;')
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Procurement',
                'value' => 'PurchaseRequisition::model()->procurement($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>
