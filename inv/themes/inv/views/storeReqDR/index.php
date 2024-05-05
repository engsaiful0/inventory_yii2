<?php
$this->breadcrumbs=array(
	'Store Req Drs',
);

$this->menu=array(
	array('label'=>'Create StoreReqDR', 'url'=>array('create')),
	array('label'=>'Manage StoreReqDR', 'url'=>array('admin')),
);
?>

<h1>Store Req Drs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
