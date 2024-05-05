<?php
$this->breadcrumbs=array(
	'Machine Names'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MachineNames', 'url'=>array('index')),
	array('label'=>'Create MachineNames', 'url'=>array('create')),
	array('label'=>'View MachineNames', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MachineNames', 'url'=>array('admin')),
);
?>

<h1>Update MachineNames <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>