<?php
$this->breadcrumbs=array(
	'Selling Prices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SellingPrice', 'url'=>array('index')),
	array('label'=>'Create SellingPrice', 'url'=>array('create')),
	array('label'=>'View SellingPrice', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SellingPrice', 'url'=>array('admin')),
);
?>

<h1>Update SellingPrice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>