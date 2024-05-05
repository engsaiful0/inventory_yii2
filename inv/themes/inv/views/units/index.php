<?php
$this->breadcrumbs=array(
	'Units',
);

$this->menu=array(
	array('label'=>'Create Units', 'url'=>array('create')),
	array('label'=>'Manage Units', 'url'=>array('admin')),
);
?>

<h1>Units</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
