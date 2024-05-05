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
");
?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<fieldset style="float: left; width: 98%;">
    <legend>Create Production Output</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'production-input-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
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
                 'length',
            'width',
            'thickness',
               array(
                'name' => 'item',
                'value' => 'UnitDistance::model()->unit_of_distanceOfThis($data->unit_of_distance)',
                'filter' => CHtml::listData(UnitDistance::model()->findAll(array("order"=>"unit_of_distance ASC")), "id", "unit_of_distance"),
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'qty',
            'qty_kg',
            array(
                'name' => 'sl_no',
                'header' => 'Output',
                'value' => 'DoubliMachinProductionInput::model()->output($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>

