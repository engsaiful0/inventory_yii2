<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionWastage', 'url'=>array('index')),
	array('label'=>'Manage DoubliMachinProductionWastage', 'url'=>array('admin')),
);
?>

<h1>Create DoubliMachinProductionWastage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>