<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductionWastage', 'url'=>array('index')),
	array('label'=>'Manage ProductionWastage', 'url'=>array('admin')),
);
?>

<h1>Create ProductionWastage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>