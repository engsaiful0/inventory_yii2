<?php
$this->breadcrumbs=array(
	'Purchase Procurements'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseProcurement', 'url'=>array('index')),
	array('label'=>'Create PurchaseProcurement', 'url'=>array('create')),
	array('label'=>'Update PurchaseProcurement', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseProcurement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseProcurement', 'url'=>array('admin')),
);
?>

<h1>View PurchaseProcurement #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'req_id',
		'sl_no',
		'max_sl_no',
		'date',
		'store',
		'item',
		'department',
		'qty',
		'cost',
		'remarks',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
		'is_po_created',
	),
)); ?>
