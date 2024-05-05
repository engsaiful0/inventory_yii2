<?php
$this->breadcrumbs=array(
	'UnitDistance'=>array('index'),
	$model->unit_of_distance=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Unit Of Distance', 'url'=>array('index')),
	array('label'=>'Create Unit Of Distance', 'url'=>array('create')),
	array('label'=>'View Unit Of Distance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Unit Of Distance', 'url'=>array('admin')),
);
?>

<h1>Update Unit Of Distance<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>