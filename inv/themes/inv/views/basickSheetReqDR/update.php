<?php
$this->breadcrumbs=array(
	'Store Req Drs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StoreReqDR', 'url'=>array('index')),
	array('label'=>'Create StoreReqDR', 'url'=>array('create')),
	array('label'=>'View StoreReqDR', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StoreReqDR', 'url'=>array('admin')),
);
?>

<h1>Update StoreReqDR <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>