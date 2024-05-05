<?php
$this->breadcrumbs=array(
	'Selling Prices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SellingPrice', 'url'=>array('index')),
	array('label'=>'Manage SellingPrice', 'url'=>array('admin')),
);
?>

<h1>Create SellingPrice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>