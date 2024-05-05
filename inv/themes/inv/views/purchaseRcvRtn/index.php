<?php
$this->breadcrumbs=array(
	'Purchase Rcv Rtns',
);

$this->menu=array(
	array('label'=>'Create PurchaseRcvRtn', 'url'=>array('create')),
	array('label'=>'Manage PurchaseRcvRtn', 'url'=>array('admin')),
);
?>

<h1>Purchase Rcv Rtns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
