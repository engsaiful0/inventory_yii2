<?php
$this->breadcrumbs=array(
	'Customer Bills'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerBill', 'url'=>array('index')),
	array('label'=>'Manage CustomerBill', 'url'=>array('admin')),
);
?>

<h1>Create CustomerBill</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>