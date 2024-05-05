<?php
$this->breadcrumbs=array(
	'Purchase Rcv Rtns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PurchaseRcvRtn', 'url'=>array('index')),
	array('label'=>'Manage PurchaseRcvRtn', 'url'=>array('admin')),
);
?>

<h1>Create PurchaseRcvRtn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>