<?php
$this->breadcrumbs=array(
	'Units'=>array('index'),
	$model->name_of_unit=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Units', 'url'=>array('index')),
	array('label'=>'Create Units', 'url'=>array('create')),
	array('label'=>'View Units', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Units', 'url'=>array('admin')),
);
?>

<h1>Update Units <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>