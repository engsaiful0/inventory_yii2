<?php
$this->breadcrumbs=array(
	'Supplier Mrs',
);

$this->menu=array(
	array('label'=>'Create SupplierMr', 'url'=>array('create')),
	array('label'=>'Manage SupplierMr', 'url'=>array('admin')),
);
?>

<h1>Supplier Mrs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
