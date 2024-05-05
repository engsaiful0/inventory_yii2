<?php
$this->breadcrumbs=array(
	'Purchase Requisitions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseRequisition', 'url'=>array('index')),
	array('label'=>'Manage PurchaseRequisition', 'url'=>array('admin')),
);
?>

<h1>Create PurchaseRequisition</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>