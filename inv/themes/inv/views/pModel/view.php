<?php
$this->breadcrumbs=array(
	'Pmodels'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PModel', 'url'=>array('index')),
	array('label'=>'Create PModel', 'url'=>array('create')),
	array('label'=>'Update PModel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PModel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PModel', 'url'=>array('admin')),
);
?>

<h1>View PModel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
