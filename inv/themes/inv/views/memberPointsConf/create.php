<?php
$this->breadcrumbs=array(
	'Member Points Confs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MemberPointsConf', 'url'=>array('index')),
	array('label'=>'Manage MemberPointsConf', 'url'=>array('admin')),
);
?>

<h1>Create MemberPointsConf</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>