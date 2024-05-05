<?php
$this->breadcrumbs=array(
	'User Stores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserStore', 'url'=>array('index')),
	array('label'=>'Create UserStore', 'url'=>array('create')),
	array('label'=>'Update UserStore', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserStore', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserStore', 'url'=>array('admin')),
);
?>

<h1>View UserStore #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'store_id',
		'is_active',
	),
)); ?>
