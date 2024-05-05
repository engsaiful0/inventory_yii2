<?php
$this->breadcrumbs=array(
	'Purchase Rcv Rtns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PurchaseRcvRtn', 'url'=>array('index')),
	array('label'=>'Create PurchaseRcvRtn', 'url'=>array('create')),
	array('label'=>'View PurchaseRcvRtn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PurchaseRcvRtn', 'url'=>array('admin')),
);
?>

<h1>Update PurchaseRcvRtn <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>