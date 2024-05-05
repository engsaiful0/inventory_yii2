<?php
$this->breadcrumbs=array(
	'Import Documents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportDocument', 'url'=>array('index')),
	array('label'=>'Create ImportDocument', 'url'=>array('create')),
	array('label'=>'View ImportDocument', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ImportDocument', 'url'=>array('admin')),
);
?>

<h1>Update ImportDocument <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>