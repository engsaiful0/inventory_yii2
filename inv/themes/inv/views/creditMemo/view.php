<?php
$this->breadcrumbs=array(
	'Credit Memos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CreditMemo', 'url'=>array('index')),
	array('label'=>'Create CreditMemo', 'url'=>array('create')),
	array('label'=>'Update CreditMemo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CreditMemo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CreditMemo', 'url'=>array('admin')),
);
?>

<h1>View CreditMemo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'max_sl_no',
		'sl_no',
		'customer_id',
		'bill_no',
		'discount',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
