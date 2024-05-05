<?php
$this->breadcrumbs=array(
	'Purchase Requisitions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseRequisition', 'url'=>array('index')),
	array('label'=>'Create PurchaseRequisition', 'url'=>array('create')),
	array('label'=>'Update PurchaseRequisition', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseRequisition', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseRequisition', 'url'=>array('admin')),
);
?>

<h1>View PurchaseRequisition #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'max_sl_no',
		'date',
		'item',
		'desc',
		'department',
		'qty',
		'cost',
		'remarks',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
