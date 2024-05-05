<?php
$this->breadcrumbs=array(
	'Pmodels',
);

$this->menu=array(
	array('label'=>'Create PModel', 'url'=>array('create')),
	array('label'=>'Manage PModel', 'url'=>array('admin')),
);
?>

<h1>Pmodels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
