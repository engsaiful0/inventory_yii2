<?php
$this->breadcrumbs=array(
	'Mfises'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mfis', 'url'=>array('index')),
	array('label'=>'Manage Mfis', 'url'=>array('admin')),
);
?>

<h1>Create Mfis</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>