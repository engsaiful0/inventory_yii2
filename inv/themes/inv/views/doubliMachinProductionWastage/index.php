<?php
$this->breadcrumbs=array(
	'Production Wastages',
);

$this->menu=array(
	array('label'=>'Create DoubliMachinProductionWastage', 'url'=>array('create')),
	array('label'=>'Manage DoubliMachinProductionWastage', 'url'=>array('admin')),
);
?>

<h1>Production Wastages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
