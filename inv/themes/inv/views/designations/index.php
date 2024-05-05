<?php
$this->breadcrumbs=array(
	'Designations',
);

$this->menu=array(
	array('label'=>'Create Designations', 'url'=>array('create')),
	array('label'=>'Manage Designations', 'url'=>array('admin')),
);
?>

<h1>Designations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
