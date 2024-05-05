<?php
$this->breadcrumbs=array(
	'Units'=>array('index'),
	$model->name_of_unit,
);

$this->menu=array(
	array('label'=>'List Units', 'url'=>array('index')),
	array('label'=>'Create Units', 'url'=>array('create')),
	array('label'=>'Update Units', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Units', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Units', 'url'=>array('admin')),
);
?>

<h1>View Units #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name_of_unit',
	),
)); ?>
