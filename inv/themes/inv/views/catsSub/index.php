<?php
$this->breadcrumbs=array(
	'Cats Subs',
);

$this->menu=array(
	array('label'=>'Create CatsSub', 'url'=>array('create')),
	array('label'=>'Manage CatsSub', 'url'=>array('admin')),
);
?>

<h1>Cats Subs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
