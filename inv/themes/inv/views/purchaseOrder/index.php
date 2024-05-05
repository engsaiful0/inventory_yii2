<?php
$this->breadcrumbs=array(
	'Purchase Orders',
);

$this->menu=array(
	array('label'=>'Create PurchaseOrder', 'url'=>array('create')),
	array('label'=>'Manage PurchaseOrder', 'url'=>array('admin')),
);
?>

<h1>Purchase Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
