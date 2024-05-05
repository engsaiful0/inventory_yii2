<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseOrder', 'url'=>array('index')),
	array('label'=>'Create PurchaseOrder', 'url'=>array('create')),
	array('label'=>'View PurchaseOrder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseOrder', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseOrder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>