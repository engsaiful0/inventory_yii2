<?php
$this->breadcrumbs=array(
	'Mfises',
);

$this->menu=array(
	array('label'=>'Create Mfis', 'url'=>array('create')),
	array('label'=>'Manage Mfis', 'url'=>array('admin')),
);
?>

<h1>Mfises</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
