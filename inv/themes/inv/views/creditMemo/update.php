<?php
$this->breadcrumbs=array(
	'Credit Memos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CreditMemo', 'url'=>array('index')),
	array('label'=>'Create CreditMemo', 'url'=>array('create')),
	array('label'=>'View CreditMemo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CreditMemo', 'url'=>array('admin')),
);
?>

<h1>Update CreditMemo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>