<?php
$this->breadcrumbs=array(
	'Member Points Confs',
);

$this->menu=array(
	array('label'=>'Create MemberPointsConf', 'url'=>array('create')),
	array('label'=>'Manage MemberPointsConf', 'url'=>array('admin')),
);
?>

<h1>Member Points Confs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
