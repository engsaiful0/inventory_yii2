<?php
$this->breadcrumbs=array(
	'Production Outputs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionOuput', 'url'=>array('index')),
	array('label'=>'Manage DoubliMachinProductionOuput', 'url'=>array('admin')),
);
?>

<h1>Create DoubliMachinProductionOuput</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>