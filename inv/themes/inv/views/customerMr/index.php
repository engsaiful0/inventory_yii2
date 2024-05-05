<?php
$this->breadcrumbs=array(
	'Customer Mrs',
);

$this->menu=array(
	array('label'=>'Create CustomerMr', 'url'=>array('create')),
	array('label'=>'Manage CustomerMr', 'url'=>array('admin')),
);
?>

<h1>Customer Mrs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
