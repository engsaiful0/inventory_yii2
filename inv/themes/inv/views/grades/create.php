<?php
$this->breadcrumbs=array(
	'Grades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Grades', 'url'=>array('index')),
	array('label'=>'Manage Grades', 'url'=>array('admin')),
);
?>

<h1>Create Grades</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>