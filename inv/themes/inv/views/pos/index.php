<?php
$this->breadcrumbs=array(
	'Poses',
);

$this->menu=array(
	array('label'=>'Create Pos', 'url'=>array('create')),
	array('label'=>'Manage Pos', 'url'=>array('admin')),
);
?>

<h1>Poses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
