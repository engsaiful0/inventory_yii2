<?php
$this->breadcrumbs=array(
	'Grades'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Grades', 'url'=>array('index')),
	array('label'=>'Create Grades', 'url'=>array('create')),
	array('label'=>'Update Grades', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Grades', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Grades', 'url'=>array('admin')),
);
?>

<h1>View Grades #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
