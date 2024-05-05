<?php
$this->breadcrumbs=array(
	'Costing Prices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CostingPrice', 'url'=>array('index')),
	array('label'=>'Manage CostingPrice', 'url'=>array('admin')),
);
?>

<h1>Create CostingPrice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>