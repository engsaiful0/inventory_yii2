<?php
$this->breadcrumbs=array(
	'Member Points Confs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MemberPointsConf', 'url'=>array('index')),
	array('label'=>'Create MemberPointsConf', 'url'=>array('create')),
	array('label'=>'View MemberPointsConf', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MemberPointsConf', 'url'=>array('admin')),
);
?>

<h1>Update MemberPointsConf <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>