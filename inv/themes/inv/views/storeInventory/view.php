<?php
$this->breadcrumbs=array(
	'Store Inventories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StoreInventory', 'url'=>array('index')),
	array('label'=>'Create StoreInventory', 'url'=>array('create')),
	array('label'=>'Update StoreInventory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StoreInventory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StoreInventory', 'url'=>array('admin')),
);
?>

<h1>View StoreInventory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'store',
		'item',
		'stock_in',
		'stock_out',
		'costing_price',
	),
)); ?>
