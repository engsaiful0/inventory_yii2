<?php
$this->breadcrumbs=array(
	'Sell Delv Rtns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SellDelvRtn', 'url'=>array('index')),
	array('label'=>'Create SellDelvRtn', 'url'=>array('create')),
	array('label'=>'View SellDelvRtn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SellDelvRtn', 'url'=>array('admin')),
);
?>

<h1>Update SellDelvRtn <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>