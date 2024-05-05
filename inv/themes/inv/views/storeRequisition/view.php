<?php
$this->breadcrumbs=array(
	'Store Requisitions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StoreRequisition', 'url'=>array('index')),
	array('label'=>'Create StoreRequisition', 'url'=>array('create')),
	array('label'=>'Update StoreRequisition', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StoreRequisition', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StoreRequisition', 'url'=>array('admin')),
);
?>

<h1>View StoreRequisition #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'max_sl_no',
		'remarks',
		'department',
		'store',
		'item',
		'qty',
		'req_date',
		'req_by',
		'approve_by',
		'approve_time',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
