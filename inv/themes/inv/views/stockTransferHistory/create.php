<?php
$this->breadcrumbs=array(
	'Stock Transfer Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StockTransferHistory', 'url'=>array('index')),
	array('label'=>'Manage StockTransferHistory', 'url'=>array('admin')),
);
?>

<h1>Create StockTransferHistory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>