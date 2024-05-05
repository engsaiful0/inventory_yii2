<?php
$this->breadcrumbs=array(
	'Poses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pos', 'url'=>array('index')),
	array('label'=>'Create Pos', 'url'=>array('create')),
	array('label'=>'Update Pos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pos', 'url'=>array('admin')),
);
?>

<h1>View Pos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'inv_no',
		'date',
		'store_id',
		'item_id',
		'price',
		'qty',
		'discount',
		'overall_discount',
		'initiated_by',
	),
)); ?>
