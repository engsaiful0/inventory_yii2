<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('store')); ?>:</b>
	<?php echo CHtml::encode($data->store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item')); ?>:</b>
	<?php echo CHtml::encode($data->item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_in')); ?>:</b>
	<?php echo CHtml::encode($data->stock_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_out')); ?>:</b>
	<?php echo CHtml::encode($data->stock_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costing_price')); ?>:</b>
	<?php echo CHtml::encode($data->costing_price); ?>
	<br />


</div>