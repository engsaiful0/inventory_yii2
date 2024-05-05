<?php
$this->breadcrumbs=array(
	'Doubli Machine Production Input'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionInput', 'url'=>array('index')),
	array('label'=>'Create DoubliMachinProductionInput', 'url'=>array('create')),
	array('label'=>'View DoubliMachinProductionInput', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DoubliMachinProductionInput', 'url'=>array('admin')),
);
?>

<h1>Update DoubliMachinProductionInput <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>