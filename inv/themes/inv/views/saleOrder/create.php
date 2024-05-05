<?php
$this->breadcrumbs=array(
	'Sale Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SaleOrder', 'url'=>array('index')),
	array('label'=>'Manage SaleOrder', 'url'=>array('admin')),
);
?>

<h1>Create SaleOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>