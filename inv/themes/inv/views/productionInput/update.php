<?php
$this->breadcrumbs=array(
	'Production Inputs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductionInput', 'url'=>array('index')),
	array('label'=>'Create ProductionInput', 'url'=>array('create')),
	array('label'=>'View ProductionInput', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductionInput', 'url'=>array('admin')),
);
?>

<h1>Update ProductionInput <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>