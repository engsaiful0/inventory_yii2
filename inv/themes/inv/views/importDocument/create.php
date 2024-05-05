<?php
$this->breadcrumbs=array(
	'Import Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportDocument', 'url'=>array('index')),
	array('label'=>'Manage ImportDocument', 'url'=>array('admin')),
);
?>

<h1>Create ImportDocument</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>