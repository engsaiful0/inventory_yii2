<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseOrder', 'url'=>array('index')),
	array('label'=>'Create PurchaseOrder', 'url'=>array('create')),
	array('label'=>'Update PurchaseOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseOrder', 'url'=>array('admin')),
);
?>

<h1>View PurchaseOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'max_sl_no',
		'ref_no',
		'issue_date',
		'requisition_id',
		'order_qty',
		'supplier_id',
		'subj',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
