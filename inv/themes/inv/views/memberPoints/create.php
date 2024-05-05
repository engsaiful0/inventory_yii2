<?php
$this->breadcrumbs=array(
	'Member Points'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MemberPoints', 'url'=>array('index')),
	array('label'=>'Manage MemberPoints', 'url'=>array('admin')),
);
?>

<h1>Create MemberPoints</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>