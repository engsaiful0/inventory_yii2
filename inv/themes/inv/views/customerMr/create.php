<?php
$this->breadcrumbs=array(
	'Customer Mrs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerMr', 'url'=>array('index')),
	array('label'=>'Manage CustomerMr', 'url'=>array('admin')),
);
?>

<h1>Create CustomerMr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>