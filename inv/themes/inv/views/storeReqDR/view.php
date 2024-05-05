<?php
$this->breadcrumbs=array(
	'Store Req Drs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StoreReqDR', 'url'=>array('index')),
	array('label'=>'Create StoreReqDR', 'url'=>array('create')),
	array('label'=>'Update StoreReqDR', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StoreReqDR', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StoreReqDR', 'url'=>array('admin')),
);
?>

<h1>View StoreReqDR #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'req_no',
		'req_id',
		'd_qty',
		'd_date',
		'r_qty',
		'r_date',
		'remarks',
		'created_by',
		'created_time',
		'update_by',
		'update_time',
	),
)); ?>
