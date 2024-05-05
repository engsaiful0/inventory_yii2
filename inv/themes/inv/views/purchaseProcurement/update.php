<?php
$this->breadcrumbs=array(
	'Purchase Procurements'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseProcurement', 'url'=>array('index')),
	array('label'=>'Create PurchaseProcurement', 'url'=>array('create')),
	array('label'=>'View PurchaseProcurement', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseProcurement', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseProcurement <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>