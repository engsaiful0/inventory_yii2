<?php
$this->breadcrumbs=array(
	'Sell Delv Rtns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SellDelvRtn', 'url'=>array('index')),
	array('label'=>'Manage SellDelvRtn', 'url'=>array('admin')),
);
?>

<h1>Create SellDelvRtn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>