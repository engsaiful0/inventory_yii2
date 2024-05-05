<?php
$this->breadcrumbs=array(
	'Production Outputs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductionOutput', 'url'=>array('index')),
	array('label'=>'Manage ProductionOutput', 'url'=>array('admin')),
);
?>

<h1>Create ProductionOutput</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>