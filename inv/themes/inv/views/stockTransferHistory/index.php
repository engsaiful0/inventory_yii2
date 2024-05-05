<?php
$this->breadcrumbs=array(
	'Stock Transfer Histories',
);

$this->menu=array(
	array('label'=>'Create StockTransferHistory', 'url'=>array('create')),
	array('label'=>'Manage StockTransferHistory', 'url'=>array('admin')),
);
?>

<h1>Stock Transfer Histories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
