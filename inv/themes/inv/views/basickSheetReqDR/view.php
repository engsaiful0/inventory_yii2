<?php
$this->breadcrumbs=array(
	'Store Req Drs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BasickSheetReqDR', 'url'=>array('index')),
	array('label'=>'Create BasickSheetReqDR', 'url'=>array('create')),
	array('label'=>'Update BasickSheetReqDR', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BasickSheetReqDR', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BasickSheetReqDR', 'url'=>array('admin')),
);
?>

<h1>View BasickSheetReqDR #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'req_no',
		'reBasickSheetReqDRq_id',
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
