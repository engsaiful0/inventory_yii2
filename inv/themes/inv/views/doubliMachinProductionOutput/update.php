<?php
$this->breadcrumbs=array(
	'Production Outputs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionOuput', 'url'=>array('index')),
	array('label'=>'Create DoubliMachinProductionOuput', 'url'=>array('create')),
	array('label'=>'View DoubliMachinProductionOuput', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DoubliMachinProductionOuput', 'url'=>array('admin')),
);
?>

<h1>Update DoubliMachinProductionOuput <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>