<?php
$this->breadcrumbs=array(
	'Stock Transfer Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StockTransferHistory', 'url'=>array('index')),
	array('label'=>'Create StockTransferHistory', 'url'=>array('create')),
	array('label'=>'Update StockTransferHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StockTransferHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StockTransferHistory', 'url'=>array('admin')),
);
?>

<h1>View StockTransferHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from_store',
		'to_store',
		'item',
		'send_qty',
		'rcv_qty',
		'send_date',
		'rcv_date',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
		'rcv_by',
		'rcv_time',
	),
)); ?>
