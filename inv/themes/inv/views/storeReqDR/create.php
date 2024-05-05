<?php
$this->breadcrumbs=array(
	'Store Req Drs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StoreReqDR', 'url'=>array('index')),
	array('label'=>'Manage StoreReqDR', 'url'=>array('admin')),
);
?>

<h1>Create StoreReqDR</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>