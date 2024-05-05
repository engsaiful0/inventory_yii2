<?php
$this->breadcrumbs=array(
	'Supplier Mrs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SupplierMr', 'url'=>array('index')),
	array('label'=>'Create SupplierMr', 'url'=>array('create')),
	array('label'=>'View SupplierMr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SupplierMr', 'url'=>array('admin')),
);
?>

<h1>Update SupplierMr <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>