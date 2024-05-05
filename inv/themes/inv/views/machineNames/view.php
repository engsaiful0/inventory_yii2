<?php
$this->breadcrumbs=array(
	'Machine Names'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MachineNames', 'url'=>array('index')),
	array('label'=>'Create MachineNames', 'url'=>array('create')),
	array('label'=>'Update MachineNames', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MachineNames', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MachineNames', 'url'=>array('admin')),
);
?>

<h1>View MachineNames #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ip_address',
		'machine_name',
	),
)); ?>
