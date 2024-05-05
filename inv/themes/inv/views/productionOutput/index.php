<?php
$this->breadcrumbs=array(
	'Production Outputs',
);

$this->menu=array(
	array('label'=>'Create ProductionOutput', 'url'=>array('create')),
	array('label'=>'Manage ProductionOutput', 'url'=>array('admin')),
);
?>

<h1>Production Outputs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
