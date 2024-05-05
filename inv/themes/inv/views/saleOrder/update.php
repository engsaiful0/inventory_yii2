<?php
$this->breadcrumbs=array(
	'Sale Orders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SaleOrder', 'url'=>array('index')),
	array('label'=>'Create SaleOrder', 'url'=>array('create')),
	array('label'=>'View SaleOrder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SaleOrder', 'url'=>array('admin')),
);
?>

<h1>Update SaleOrder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>