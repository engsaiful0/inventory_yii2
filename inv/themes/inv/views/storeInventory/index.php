<?php
$this->breadcrumbs=array(
	'Store Inventories',
);

$this->menu=array(
	array('label'=>'Create StoreInventory', 'url'=>array('create')),
	array('label'=>'Manage StoreInventory', 'url'=>array('admin')),
);
?>

<h1>Store Inventories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
