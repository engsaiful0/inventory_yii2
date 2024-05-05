<?php
$this->breadcrumbs=array(
	'Sell Delv Rtns',
);

$this->menu=array(
	array('label'=>'Create SellDelvRtn', 'url'=>array('create')),
	array('label'=>'Manage SellDelvRtn', 'url'=>array('admin')),
);
?>

<h1>Sell Delv Rtns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
