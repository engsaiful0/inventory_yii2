<?php
$this->breadcrumbs=array(
	'Poses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pos', 'url'=>array('index')),
	array('label'=>'Manage Pos', 'url'=>array('admin')),
);
?>

<h1>Create Pos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>