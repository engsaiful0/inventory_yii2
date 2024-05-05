<?php
$this->breadcrumbs=array(
	'Supplier Contact Persons',
);

$this->menu=array(
	array('label'=>'Create SupplierContactPersons', 'url'=>array('create')),
	array('label'=>'Manage SupplierContactPersons', 'url'=>array('admin')),
);
?>

<h1>Supplier Contact Persons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
