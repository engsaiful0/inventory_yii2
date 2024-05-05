<?php
$this->breadcrumbs=array(
	'Machine Names',
);

$this->menu=array(
	array('label'=>'Create MachineNames', 'url'=>array('create')),
	array('label'=>'Manage MachineNames', 'url'=>array('admin')),
);
?>

<h1>Machine Names</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
