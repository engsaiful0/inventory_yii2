<?php
$this->breadcrumbs=array(
	'Storck Tranfer History From Temp To Mains',
);

$this->menu=array(
	array('label'=>'Create StorckTranferHistoryFromTempToMain', 'url'=>array('create')),
	array('label'=>'Manage StorckTranferHistoryFromTempToMain', 'url'=>array('admin')),
);
?>

<h1>Storck Tranfer History From Temp To Mains</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
