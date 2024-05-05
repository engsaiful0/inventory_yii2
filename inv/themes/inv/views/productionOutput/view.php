<?php
$this->breadcrumbs=array(
	'Production Outputs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductionOutput', 'url'=>array('index')),
	array('label'=>'Create ProductionOutput', 'url'=>array('create')),
	array('label'=>'Update ProductionOutput', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductionOutput', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductionOutput', 'url'=>array('admin')),
);
?>

<h1>View ProductionOutput #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'production_input_id',
		'max_sl_no',
		'sl_no',
		'date',
		'time',
		'item',
		'qty',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
