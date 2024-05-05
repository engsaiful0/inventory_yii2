<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductionWastage', 'url'=>array('index')),
	array('label'=>'Create ProductionWastage', 'url'=>array('create')),
	array('label'=>'Update ProductionWastage', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductionWastage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductionWastage', 'url'=>array('admin')),
);
?>

<h1>View ProductionWastage #<?php echo $model->id; ?></h1>

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
