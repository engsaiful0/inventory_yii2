<?php
$this->breadcrumbs=array(
	'Cats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cats', 'url'=>array('index')),
	array('label'=>'Manage Cats', 'url'=>array('admin')),
);
?>

<h1>Create Cats</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>