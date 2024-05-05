<?php
$this->breadcrumbs=array(
	'Machines',
);

$this->menu=array(
	array('label'=>'Create Machines', 'url'=>array('create')),
	array('label'=>'Manage Machines', 'url'=>array('admin')),
);
?>

<h1>Machines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
