<?php
$this->breadcrumbs=array(
	'Store Requisitions',
);

$this->menu=array(
	array('label'=>'Create StoreRequisition', 'url'=>array('create')),
	array('label'=>'Manage StoreRequisition', 'url'=>array('admin')),
);
?>

<h1>Store Requisitions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
