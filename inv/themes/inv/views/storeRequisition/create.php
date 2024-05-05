<?php
$this->breadcrumbs=array(
	'Store Requisitions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StoreRequisition', 'url'=>array('index')),
	array('label'=>'Manage StoreRequisition', 'url'=>array('admin')),
);
?>

<h1>Create StoreRequisition</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>