<?php
$this->breadcrumbs=array(
	'Mfises'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Mfis', 'url'=>array('index')),
	array('label'=>'Create Mfis', 'url'=>array('create')),
	array('label'=>'Update Mfis', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mfis', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mfis', 'url'=>array('admin')),
);
?>

<h1>View Mfis #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
