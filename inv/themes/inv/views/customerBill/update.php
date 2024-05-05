<?php
$this->breadcrumbs=array(
	'Customer Bills'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CustomerBill', 'url'=>array('index')),
	array('label'=>'Create CustomerBill', 'url'=>array('create')),
	array('label'=>'View CustomerBill', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CustomerBill', 'url'=>array('admin')),
);
?>

<h1>Update CustomerBill <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>