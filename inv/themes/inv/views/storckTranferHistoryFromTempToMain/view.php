<?php
$this->breadcrumbs=array(
	'Storck Tranfer History From Temp To Mains'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StorckTranferHistoryFromTempToMain', 'url'=>array('index')),
	array('label'=>'Create StorckTranferHistoryFromTempToMain', 'url'=>array('create')),
	array('label'=>'Update StorckTranferHistoryFromTempToMain', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StorckTranferHistoryFromTempToMain', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StorckTranferHistoryFromTempToMain', 'url'=>array('admin')),
);
?>

<h1>View StorckTranferHistoryFromTempToMain #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from_temp_store',
		'to_main_store',
		'item',
		'send_qty',
		'rcv_qty',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
