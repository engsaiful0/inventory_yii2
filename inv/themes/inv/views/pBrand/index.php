<?php
$this->breadcrumbs=array(
	'Pbrands',
);

$this->menu=array(
	array('label'=>'Create PBrand', 'url'=>array('create')),
	array('label'=>'Manage PBrand', 'url'=>array('admin')),
);
?>

<h1>Pbrands</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
