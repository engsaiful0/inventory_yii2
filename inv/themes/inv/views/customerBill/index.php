<?php
$this->breadcrumbs=array(
	'Customer Bills',
);

$this->menu=array(
	array('label'=>'Create CustomerBill', 'url'=>array('create')),
	array('label'=>'Manage CustomerBill', 'url'=>array('admin')),
);
?>

<h1>Customer Bills</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
