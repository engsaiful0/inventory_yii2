<?php
$this->breadcrumbs=array(
	'Costing Prices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CostingPrice', 'url'=>array('index')),
	array('label'=>'Create CostingPrice', 'url'=>array('create')),
	array('label'=>'View CostingPrice', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CostingPrice', 'url'=>array('admin')),
);
?>

<h1>Update CostingPrice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>