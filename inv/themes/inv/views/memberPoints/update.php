<?php
$this->breadcrumbs=array(
	'Member Points'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MemberPoints', 'url'=>array('index')),
	array('label'=>'Create MemberPoints', 'url'=>array('create')),
	array('label'=>'View MemberPoints', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MemberPoints', 'url'=>array('admin')),
);
?>

<h1>Update MemberPoints <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>