<?php
$this->breadcrumbs=array(
	'Costing Prices',
);

$this->menu=array(
	array('label'=>'Create CostingPrice', 'url'=>array('create')),
	array('label'=>'Manage CostingPrice', 'url'=>array('admin')),
);
?>

<h1>Costing Prices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
