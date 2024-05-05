<?php
$this->breadcrumbs=array(
	'Production Inputs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductionInput', 'url'=>array('index')),
	array('label'=>'Create ProductionInput', 'url'=>array('create')),
	array('label'=>'Update ProductionInput', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductionInput', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductionInput', 'url'=>array('admin')),
);
?>

<h1>View ProductionInput #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'sl_no',
		'date',
		'time',
		'store',
		'machine',
		'item',
		'qty',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
