<?php
$this->breadcrumbs=array(
	'Credit Memos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CreditMemo', 'url'=>array('index')),
	array('label'=>'Manage CreditMemo', 'url'=>array('admin')),
);
?>

<h1>Create CreditMemo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>