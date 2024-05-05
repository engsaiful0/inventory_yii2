<?php
$this->breadcrumbs=array(
	'Supplier Mrs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SupplierMr', 'url'=>array('index')),
	array('label'=>'Manage SupplierMr', 'url'=>array('admin')),
);
?>

<h1>Create SupplierMr</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>