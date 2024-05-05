<?php
$this->breadcrumbs=array(
	'Purchase Procurements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseProcurement', 'url'=>array('index')),
	array('label'=>'Manage PurchaseProcurement', 'url'=>array('admin')),
);
?>

<h1>Create PurchaseProcurement</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>