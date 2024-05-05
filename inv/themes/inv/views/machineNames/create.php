<?php
$this->breadcrumbs=array(
	'Machine Names'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MachineNames', 'url'=>array('index')),
	array('label'=>'Manage MachineNames', 'url'=>array('admin')),
);
?>

<h1>Create MachineNames</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>