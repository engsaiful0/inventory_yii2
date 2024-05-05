<?php
$this->breadcrumbs=array(
	'Selling Prices',
);

$this->menu=array(
	array('label'=>'Create SellingPrice', 'url'=>array('create')),
	array('label'=>'Manage SellingPrice', 'url'=>array('admin')),
);
?>

<h1>Selling Prices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
