<?php
$this->breadcrumbs=array(
	'Supplier Mrs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SupplierMr', 'url'=>array('index')),
	array('label'=>'Create SupplierMr', 'url'=>array('create')),
	array('label'=>'Update SupplierMr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SupplierMr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SupplierMr', 'url'=>array('admin')),
);
?>

<h1>View SupplierMr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'sl_no',
		'supplier_id',
		'mr_date',
		'narration',
		'received_type',
		'bank_id',
		'cheque_no',
		'cheque_date',
		'paid_amount',
		'discount',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
