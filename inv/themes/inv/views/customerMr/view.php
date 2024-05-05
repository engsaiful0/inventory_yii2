<?php
$this->breadcrumbs=array(
	'Customer Mrs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CustomerMr', 'url'=>array('index')),
	array('label'=>'Create CustomerMr', 'url'=>array('create')),
	array('label'=>'Update CustomerMr', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerMr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerMr', 'url'=>array('admin')),
);
?>

<h1>View CustomerMr #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'sl_no',
		'bill_no',
		'customer_id',
		'date',
		'received_type',
		'bank_name',
		'cheque_no',
		'cheque_date',
		'model_of_payment',
		'paid_amount',
		'discount',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
