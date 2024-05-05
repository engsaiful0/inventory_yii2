<?php
$this->breadcrumbs=array(
	'Purchase Procurements',
);

$this->menu=array(
	array('label'=>'Create PurchaseProcurement', 'url'=>array('create')),
	array('label'=>'Manage PurchaseProcurement', 'url'=>array('admin')),
);
?>

<h1>Purchase Procurements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
