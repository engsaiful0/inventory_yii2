<?php
$this->breadcrumbs=array(
	'Cats Subs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CatsSub', 'url'=>array('index')),
	array('label'=>'Create CatsSub', 'url'=>array('create')),
	array('label'=>'View CatsSub', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CatsSub', 'url'=>array('admin')),
);
?>

<h1>Update CatsSub <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>