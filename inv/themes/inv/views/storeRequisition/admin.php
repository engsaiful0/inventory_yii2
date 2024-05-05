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
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"store-requisition-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('store-requisition-search-form').action='deleteall';
                document.getElementById('store-requisition-search-form').submit();
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
                        "Preview", Yii::app()->createUrl('storeRequisition/requisitionPreview'), array(
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
                    'href' => Yii::app()->createUrl('storeRequisition/requisitionPreview'),
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
<?php
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Store Requisitions</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'store-requisition-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'store-requisition-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'selectableRows' => 2,
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            'sl_no',
            'req_date',
            array(
                'name' => 'department',
                'value' => 'Departments::model()->nameOfThis($data->department)',
                'filter' => CHtml::listData(Departments::model()->findAll(array('order'=>'department_name ASC')), 'id', 'department_name'),
            ),
            array(
                'name' => 'req_by',
                'value' => 'Employees::model()->fullName($data->req_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            array(
                'name' => 'from_store',
                'value' => 'Stores::model()->storeName($data->from_store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
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
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;')
            ),
            array(
                'name' => 'created_by',
                'value' => 'Users::model()->fullNameOfThis($data->created_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'created_time',
            array(
                'name' => 'updated_by',
                'value' => 'Users::model()->fullNameOfThis($data->updated_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'updated_time',
            array(
                'name' => 'sl_no',
                'header' => 'Edit',
                'value' => 'StoreRequisition::model()->update($data->sl_no)',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Delete',
                'value' => 'StoreRequisition::model()->delete($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php $this->endWidget(); ?>
</fieldset>
