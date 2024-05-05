<?php
$this->breadcrumbs=array(
	'Customer Contact Persons',
);

$this->menu=array(
	array('label'=>'Create CustomerContactPersons', 'url'=>array('create')),
	array('label'=>'Manage CustomerContactPersons', 'url'=>array('admin')),
);
?>

<h1>Customer Contact Persons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
