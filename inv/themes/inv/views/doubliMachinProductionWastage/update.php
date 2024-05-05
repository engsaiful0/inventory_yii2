<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DoubliMachinProductionWastage', 'url'=>array('index')),
	array('label'=>'Create DoubliMachinProductionWastage', 'url'=>array('create')),
	array('label'=>'View DoubliMachinProductionWastage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DoubliMachinProductionWastage', 'url'=>array('admin')),
);
?>

<h1>Update DoubliMachinProductionWastage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>