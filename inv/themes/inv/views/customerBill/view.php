<?php
$this->breadcrumbs=array(
	'Customer Bills'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CustomerBill', 'url'=>array('index')),
	array('label'=>'Create CustomerBill', 'url'=>array('create')),
	array('label'=>'Update CustomerBill', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerBill', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerBill', 'url'=>array('admin')),
);
?>

<h1>View CustomerBill #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'sl_no',
		'customer_id',
		'challan_no',
		'bill_date',
		'due_date',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
