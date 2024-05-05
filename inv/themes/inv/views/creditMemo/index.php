<?php
$this->breadcrumbs=array(
	'Credit Memos',
);

$this->menu=array(
	array('label'=>'Create CreditMemo', 'url'=>array('create')),
	array('label'=>'Manage CreditMemo', 'url'=>array('admin')),
);
?>

<h1>Credit Memos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
