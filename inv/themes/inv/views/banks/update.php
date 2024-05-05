<?php
$this->breadcrumbs=array(
	'Banks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Banks', 'url'=>array('index')),
	array('label'=>'Create Banks', 'url'=>array('create')),
	array('label'=>'View Banks', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Banks', 'url'=>array('admin')),
);
?>

<h1>Update Banks <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>