<?php.
$this->breadcrumbs=array(
	'Purchase Rcv Rtns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PurchaseRcvRtn', 'url'=>array('index')),
	array('label'=>'Create PurchaseRcvRtn', 'url'=>array('create')),
	array('label'=>'Update PurchaseRcvRtn', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PurchaseRcvRtn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PurchaseRcvRtn', 'url'=>array('admin')),
);
?>

<h1>View PurchaseRcvRtn #<?php echo $model->id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'challan_no',
		'po_id',
		'rcv_date',
		'rcv_qty',
		'rtn_date',
		'rtn_qty',
		'remarks',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
