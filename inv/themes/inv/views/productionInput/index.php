<?php
$this->breadcrumbs=array(
	'Production Inputs',
);

$this->menu=array(
	array('label'=>'Create ProductionInput', 'url'=>array('create')),
	array('label'=>'Manage ProductionInput', 'url'=>array('admin')),
);
?>

<h1>Production Inputs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
