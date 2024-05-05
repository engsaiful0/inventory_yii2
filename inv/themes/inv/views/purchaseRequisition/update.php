<?php
$this->breadcrumbs=array(
	'Purchase Requisitions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseRequisition', 'url'=>array('index')),
	array('label'=>'Create PurchaseRequisition', 'url'=>array('create')),
	array('label'=>'View PurchaseRequisition', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseRequisition', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseRequisition <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>