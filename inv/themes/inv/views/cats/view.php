<?php
$this->breadcrumbs=array(
	'Cats'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Cats', 'url'=>array('index')),
	array('label'=>'Create Cats', 'url'=>array('create')),
	array('label'=>'Update Cats', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cats', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cats', 'url'=>array('admin')),
);
?>

<h1>View Cats #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
