<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('production-input-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"production-input-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('production-input-search-form').action='deleteall';
                document.getElementById('production-input-search-form').submit();
        }
});
");
?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Production Inputs</legend>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'production-input-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'production-input-grid',
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
            'track_no',
            'sl_no',
            array(
                'name' => 'sl_no',
                'header'=>'Date',
                'value' => '$data->date',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header'=>'Time',
                'value' => '$data->time',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header'=>'Store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header'=>'Machine',
                'value' => 'Machines::model()->nameOfThis($data->machine)',
                'filter' => '',
            ),
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order"=>"name ASC")), "id", "nameWithUnit"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'qty',
            'qty_kg',
            'return_qty',
            'return_qty_kg',
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
                'name' => 'sl_no',
                'header' => 'Edit',
                'value' => 'ProductionInput::model()->update($data->sl_no)',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Delete',
                'value' => 'ProductionInput::model()->delete($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php echo CHtml::button('Delete selected records', array('name' => 'btndeleteall', 'class' => 'deleteall-button')); ?>
    <?php $this->endWidget(); ?>
</fieldset>

