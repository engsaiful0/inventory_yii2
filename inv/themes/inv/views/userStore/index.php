<?php
$this->breadcrumbs=array(
	'User Stores',
);

$this->menu=array(
	array('label'=>'Create UserStore', 'url'=>array('create')),
	array('label'=>'Manage UserStore', 'url'=>array('admin')),
);
?>

<h1>User Stores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
