<?php
$this->breadcrumbs=array(
	'Member Points'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MemberPoints', 'url'=>array('index')),
	array('label'=>'Create MemberPoints', 'url'=>array('create')),
	array('label'=>'Update MemberPoints', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MemberPoints', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MemberPoints', 'url'=>array('admin')),
);
?>

<h1>View MemberPoints #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'member_id',
		'added_point',
		'used_point',
		'date',
		'remarks',
	),
)); ?>
