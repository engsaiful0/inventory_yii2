<?php
$this->breadcrumbs=array(
	'Master Lcs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MasterLc', 'url'=>array('index')),
	array('label'=>'Manage MasterLc', 'url'=>array('admin')),
);
?>

<h1>Create MasterLc</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>