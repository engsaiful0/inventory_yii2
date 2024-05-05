<?php
$this->breadcrumbs=array(
	'Storck Tranfer History From Temp To Mains'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StorckTranferHistoryFromTempToMain', 'url'=>array('index')),
	array('label'=>'Manage StorckTranferHistoryFromTempToMain', 'url'=>array('admin')),
);
?>

<h1>Create StorckTranferHistoryFromTempToMain</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>