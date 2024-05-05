<?php
$this->breadcrumbs=array(
	'Customer Mrs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerMr', 'url'=>array('index')),
	array('label'=>'Create CustomerMr', 'url'=>array('create')),
	array('label'=>'View CustomerMr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerMr', 'url'=>array('admin')),
);
?>

<h1>Update CustomerMr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>