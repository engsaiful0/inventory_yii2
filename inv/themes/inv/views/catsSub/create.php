<?php
$this->breadcrumbs=array(
	'Cats Subs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CatsSub', 'url'=>array('index')),
	array('label'=>'Manage CatsSub', 'url'=>array('admin')),
);
?>

<h1>Create CatsSub</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>