<?php
$this->breadcrumbs=array(
	'Cats',
);

$this->menu=array(
	array('label'=>'Create Cats', 'url'=>array('create')),
	array('label'=>'Manage Cats', 'url'=>array('admin')),
);
?>

<h1>Cats</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
