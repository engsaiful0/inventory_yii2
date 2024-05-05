<?php
$this->breadcrumbs=array(
	'Store Inventories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StoreInventory', 'url'=>array('index')),
	array('label'=>'Create StoreInventory', 'url'=>array('create')),
	array('label'=>'View StoreInventory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StoreInventory', 'url'=>array('admin')),
);
?>

<h1>Update StoreInventory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>