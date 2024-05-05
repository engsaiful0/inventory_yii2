<?php
$this->breadcrumbs=array(
	'UnitDistance'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Unit Of Distance', 'url'=>array('index')),
	array('label'=>'Manage Unit Of Distance', 'url'=>array('admin')),
);
?>

<h1>Create Unit Of Distance</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>