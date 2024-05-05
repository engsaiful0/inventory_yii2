<?php
$this->breadcrumbs=array(
	'Master Lcs',
);

$this->menu=array(
	array('label'=>'Create MasterLc', 'url'=>array('create')),
	array('label'=>'Manage MasterLc', 'url'=>array('admin')),
);
?>

<h1>Master Lcs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
