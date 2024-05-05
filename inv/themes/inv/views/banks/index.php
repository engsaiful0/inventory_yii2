<?php
$this->breadcrumbs=array(
	'Banks',
);

$this->menu=array(
	array('label'=>'Create Banks', 'url'=>array('create')),
	array('label'=>'Manage Banks', 'url'=>array('admin')),
);
?>

<h1>Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
