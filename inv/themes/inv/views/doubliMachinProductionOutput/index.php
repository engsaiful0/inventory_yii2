<?php
$this->breadcrumbs=array(
	'Production Outputs',
);

$this->menu=array(
	array('label'=>'Create DoubliMachinProductionOuput', 'url'=>array('create')),
	array('label'=>'Manage DoubliMachinProductionOuput', 'url'=>array('admin')),
);
?>

<h1>Production Outputs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
