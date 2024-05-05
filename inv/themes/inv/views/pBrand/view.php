<?php
$this->breadcrumbs=array(
	'Pbrands'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PBrand', 'url'=>array('index')),
	array('label'=>'Create PBrand', 'url'=>array('create')),
	array('label'=>'Update PBrand', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PBrand', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PBrand', 'url'=>array('admin')),
);
?>

<h1>View PBrand #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
