<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('store-req-dr-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"store-req-dr-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('store-req-dr-search-form').action='deleteall';
                document.getElementById('store-req-dr-search-form').submit();
        }
});
");
?>
<?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<fieldset style="float: left; width: 98%;">
    <legend>Approve Purchase Requisition</legend>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'store-req-dr-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-requisition-grid',
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
            'cost',
            array(
                'name'=>'remarks',
                'htmlOptions'=>array('style'=>'text-align: right;')
            ),
            array(
                'name' => 'created_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->created_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'created_time',
            array(
                'name' => 'updated_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->updated_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order"=>"full_name ASC")), "id", "full_name"),
            ),
            'updated_time',
            array(
                'name' => 'is_superadmin_approved',
                'value' => 'PurchaseRequisition::model()->isSuperadminApproved($data->is_superadmin_approved)',
                'filter' => array(1 => "Approved", 0 => "Pending"),
            ),
            array(
                'name' => ' superadmin_approved_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->is_superadmin_approved))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'superadmin_approved_time',

             array(
                'name' => 'sl_no',
                'header' => 'Approve',
                'value' => 'PurchaseRequisition::model()->approveAll($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php
    $condition = "is_superadmin_approved!=1 GROUP BY sl_no";
    $poData = PurchaseRequisition::model()->findAll(array('condition' => $condition,), 'id');
    if ($poData) {
        foreach ($poData as $pod):
            $sl_no = $pod->sl_no;
            echo '<script type="text/javascript">';
            echo 'function allApprove' . $sl_no . '(){';
            echo CHtml::ajax(array(
                'url' => array('purchaseRequisition/allApprove', 'sl_no' => $sl_no),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                    $('.ajaxLoaderViewApproveAll').show();
                }",
                'complete' => "function(){
                    $('.ajaxLoaderViewApproveAll').hide();
                }",
                'success' => "function(data){
                    if (data.status == 'failure'){
                        $.fn.yiiGridView.update('store-req-dr-grid');
                        $('#approveAll-dialog div.approveAll-dialog-content').html(data.content);
                        $('#approveAll-dialog div.approveAll-dialog-content form').submit(allApprove" . $sl_no . ");
                    }else{
                        $.fn.yiiGridView.update('store-req-dr-grid');
                        $('#approveAll-dialog div.approveAll-dialog-content').html(data.content);
                        setTimeout(\"$('#approveAll-dialog').dialog('close') \",1000);
                    }
                }",
            ));
            echo ';';
            echo 'return false;';
            echo '}';
            echo '</script>';
        endforeach;
    }
    ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'approveAll-dialog',
        'options' => array(
            'title' => 'Approve Items',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1240,
            'resizable' => false,
        ),
    ));
    ?>
    <div id="ajaxLoaderViewApproveAll" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>

    <div class="approveAll-dialog-content"></div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>

</fieldset>
