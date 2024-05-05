<?php
$this->breadcrumbs=array(
	'Purchase Requisitions',
);

$this->menu=array(
	array('label'=>'Create PurchaseRequisition', 'url'=>array('create')),
	array('label'=>'Manage PurchaseRequisition', 'url'=>array('admin')),
);
?>

<h1>Purchase Requisitions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
