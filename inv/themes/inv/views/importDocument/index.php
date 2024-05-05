<?php
$this->breadcrumbs=array(
	'Import Documents',
);

$this->menu=array(
	array('label'=>'Create ImportDocument', 'url'=>array('create')),
	array('label'=>'Manage ImportDocument', 'url'=>array('admin')),
);
?>

<h1>Import Documents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
