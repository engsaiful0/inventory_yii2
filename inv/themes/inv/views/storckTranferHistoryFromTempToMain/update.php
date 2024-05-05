<?php
$this->breadcrumbs=array(
	'Storck Tranfer History From Temp To Mains'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StorckTranferHistoryFromTempToMain', 'url'=>array('index')),
	array('label'=>'Create StorckTranferHistoryFromTempToMain', 'url'=>array('create')),
	array('label'=>'View StorckTranferHistoryFromTempToMain', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StorckTranferHistoryFromTempToMain', 'url'=>array('admin')),
);
?>

<h1>Update StorckTranferHistoryFromTempToMain <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>