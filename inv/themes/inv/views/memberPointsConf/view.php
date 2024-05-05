<?php
$this->breadcrumbs=array(
	'Member Points Confs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MemberPointsConf', 'url'=>array('index')),
	array('label'=>'Create MemberPointsConf', 'url'=>array('create')),
	array('label'=>'Update MemberPointsConf', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MemberPointsConf', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MemberPointsConf', 'url'=>array('admin')),
);
?>

<h1>View MemberPointsConf #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'is_active',
		'start_date',
		'end_date',
		'point_add',
		'over_amount',
		'each_point_amount',
	),
)); ?>
