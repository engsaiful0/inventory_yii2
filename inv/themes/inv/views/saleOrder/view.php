<?php
$this->breadcrumbs=array(
	'Sale Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SaleOrder', 'url'=>array('index')),
	array('label'=>'Create SaleOrder', 'url'=>array('create')),
	array('label'=>'Update SaleOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SaleOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SaleOrder', 'url'=>array('admin')),
);
?>

<h1>View SaleOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sl_no',
		'max_sl_no',
		'issue_date',
		'expected_d_date',
		'subj',
		'order_type2',
		'pi_no',
		'pi_date',
		'store',
		'customer_id',
		'item',
		'qty',
		'price',
		'created_by',
		'created_time',
		'updated_by',
		'updated_time',
	),
)); ?>
