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
    <legend>Return Production Input Qty</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'production-input-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'sl_no',
            'date',
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"),
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'length',
            'width',
            'thickness',
            array(
                'name' => 'unit_of_distance',
                'value' => 'CHtml::encode(UnitDistance::model()->unit_of_distanceOfThis($data->unit_of_distance))',
                'filter' => CHtml::listData(UnitDistance::model()->findAll(array("order" => "unit_of_distance ASC")), "id", "unit_of_distance"),
            ),
            'qty',
            'qty_kg',
            'return_qty',
            'return_qty_kg',
            array(
                'name' => 'sl_no',
                'header' => 'Return',
                'value' => 'DoubliMachinProductionInput::model()->returnQty($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>

