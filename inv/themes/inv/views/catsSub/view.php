<?php
$this->breadcrumbs=array(
	'Cats Subs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CatsSub', 'url'=>array('index')),
	array('label'=>'Create CatsSub', 'url'=>array('create')),
	array('label'=>'Update CatsSub', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatsSub', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatsSub', 'url'=>array('admin')),
);
?>

<h1>View CatsSub #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
