<?php
$this->breadcrumbs=array(
	'Store Requisitions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StoreRequisition', 'url'=>array('index')),
	array('label'=>'Create StoreRequisition', 'url'=>array('create')),
	array('label'=>'View StoreRequisition', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StoreRequisition', 'url'=>array('admin')),
);
?>

<h1>Update StoreRequisition <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>