<?php
$this->breadcrumbs=array(
	'Member Points',
);

$this->menu=array(
	array('label'=>'Create MemberPoints', 'url'=>array('create')),
	array('label'=>'Manage MemberPoints', 'url'=>array('admin')),
);
?>

<h1>Member Points</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
