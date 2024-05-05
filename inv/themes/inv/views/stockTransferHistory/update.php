<?php
$this->breadcrumbs=array(
	'Stock Transfer Histories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StockTransferHistory', 'url'=>array('index')),
	array('label'=>'Create StockTransferHistory', 'url'=>array('create')),
	array('label'=>'View StockTransferHistory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StockTransferHistory', 'url'=>array('admin')),
);
?>

<h1>Update StockTransferHistory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>