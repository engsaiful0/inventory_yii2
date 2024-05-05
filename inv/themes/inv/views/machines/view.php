<?php
$this->breadcrumbs=array(
	'Machines'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Machines', 'url'=>array('index')),
	array('label'=>'Create Machines', 'url'=>array('create')),
	array('label'=>'Update Machines', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Machines', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Machines', 'url'=>array('admin')),
);
?>

<h1>View Machines #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'details',
	),
)); ?>
