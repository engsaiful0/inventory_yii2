<?php
$this->breadcrumbs=array(
	'Your Companys',
);

$this->menu=array(
	array('label'=>'Create YourCompany', 'url'=>array('create')),
	array('label'=>'Manage YourCompany', 'url'=>array('admin')),
);
?>

<h1>Your Companys</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
