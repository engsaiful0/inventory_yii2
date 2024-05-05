<?php
$this->breadcrumbs=array(
	'Production Outputs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductionOutput', 'url'=>array('index')),
	array('label'=>'Create ProductionOutput', 'url'=>array('create')),
	array('label'=>'View ProductionOutput', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductionOutput', 'url'=>array('admin')),
);
?>

<h1>Update ProductionOutput <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>