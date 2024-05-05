<?php
$this->breadcrumbs=array(
	'Master Lcs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MasterLc', 'url'=>array('index')),
	array('label'=>'Create MasterLc', 'url'=>array('create')),
	array('label'=>'View MasterLc', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MasterLc', 'url'=>array('admin')),
);
?>

<h1>Update MasterLc <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>