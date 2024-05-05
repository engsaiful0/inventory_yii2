<?php
$this->breadcrumbs=array(
	'Production Inputs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductionInput', 'url'=>array('index')),
	array('label'=>'Manage ProductionInput', 'url'=>array('admin')),
);
?>

<h1>Create ProductionInput</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>