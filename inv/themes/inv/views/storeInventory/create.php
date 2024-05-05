<?php
$this->breadcrumbs=array(
	'Store Inventories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StoreInventory', 'url'=>array('index')),
	array('label'=>'Manage StoreInventory', 'url'=>array('admin')),
);
?>

<h1>Create StoreInventory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>