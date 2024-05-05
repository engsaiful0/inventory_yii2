<?php
$this->breadcrumbs=array(
	'Selling Prices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SellingPrice', 'url'=>array('index')),
	array('label'=>'Create SellingPrice', 'url'=>array('create')),
	array('label'=>'Update SellingPrice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SellingPrice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SellingPrice', 'url'=>array('admin')),
);
?>

<h1>View SellingPrice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'price',
		'date',
		'is_active',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
