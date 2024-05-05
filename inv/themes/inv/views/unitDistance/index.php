<?php
$this->breadcrumbs=array(
	'UnitDistance',
);

$this->menu=array(
	array('label'=>'Create Unit Of Distance', 'url'=>array('create')),
	array('label'=>'Manage Unit Of Distance', 'url'=>array('admin')),
);
?>

<h1>Unit Of Distance</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
