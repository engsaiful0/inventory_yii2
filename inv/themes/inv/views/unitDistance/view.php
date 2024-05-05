<?php
$this->breadcrumbs=array(
	'UnitDistance'=>array('index'),
	$model->unit_of_distance,
);

$this->menu=array(
	array('label'=>'List Unit Of Distance', 'url'=>array('index')),
	array('label'=>'Create Unit Of Distance', 'url'=>array('create')),
	array('label'=>'Update Unit Of Distance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Unit Of Distance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Unit Of Distance', 'url'=>array('admin')),
);
?>

<h1>View Unit Of Distance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'unit_of_distance',
	),
)); ?>
