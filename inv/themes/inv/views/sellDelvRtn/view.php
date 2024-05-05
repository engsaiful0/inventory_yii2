<?php
$this->breadcrumbs=array(
	'Sell Delv Rtns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SellDelvRtn', 'url'=>array('index')),
	array('label'=>'Create SellDelvRtn', 'url'=>array('create')),
	array('label'=>'Update SellDelvRtn', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SellDelvRtn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SellDelvRtn', 'url'=>array('admin')),
);
?>

<h1>View SellDelvRtn #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'max_sl_no',
		'so_id',
		'so_no',
		'd_date',
		'd_qty',
		'r_qty',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
