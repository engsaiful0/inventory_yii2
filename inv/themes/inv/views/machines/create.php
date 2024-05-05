<?php
$this->breadcrumbs=array(
	'Machines'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Machines', 'url'=>array('index')),
	array('label'=>'Manage Machines', 'url'=>array('admin')),
);
?>

<h1>Create Machines</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>