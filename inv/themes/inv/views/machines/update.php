<?php
$this->breadcrumbs=array(
	'Machines'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Machines', 'url'=>array('index')),
	array('label'=>'Create Machines', 'url'=>array('create')),
	array('label'=>'View Machines', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Machines', 'url'=>array('admin')),
);
?>

<h1>Update Machines <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>