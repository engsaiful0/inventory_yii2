<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionWastage', 'url'=>array('index')),
	array('label'=>'Create DoubliMachinProductionWastage', 'url'=>array('create')),
	array('label'=>'Update DoubliMachinProductionWastage', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DoubliMachinProductionWastage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DoubliMachinProductionWastage', 'url'=>array('admin')),
);
?>

<h1>View DoubliMachinProductionWastage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'production_input_no',
		'wastage_qty',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
