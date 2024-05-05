<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseOrder', 'url'=>array('index')),
	array('label'=>'Manage PurchaseOrder', 'url'=>array('admin')),
);
?>

<h1>Create PurchaseOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>