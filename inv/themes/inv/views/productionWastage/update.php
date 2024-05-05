<?php
$this->breadcrumbs=array(
	'Production Wastages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductionWastage', 'url'=>array('index')),
	array('label'=>'Create ProductionWastage', 'url'=>array('create')),
	array('label'=>'View ProductionWastage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductionWastage', 'url'=>array('admin')),
);
?>

<h1>Update ProductionWastage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>