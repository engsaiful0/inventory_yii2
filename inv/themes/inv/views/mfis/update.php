<?php
$this->breadcrumbs=array(
	'Mfises'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mfis', 'url'=>array('index')),
	array('label'=>'Create Mfis', 'url'=>array('create')),
	array('label'=>'View Mfis', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mfis', 'url'=>array('admin')),
);
?>

<h1>Update Mfis <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>