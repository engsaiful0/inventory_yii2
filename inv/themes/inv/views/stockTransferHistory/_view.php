<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_store')); ?>:</b>
	<?php echo CHtml::encode($data->from_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_store')); ?>:</b>
	<?php echo CHtml::encode($data->to_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item')); ?>:</b>
	<?php echo CHtml::encode($data->item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_qty')); ?>:</b>
	<?php echo CHtml::encode($data->send_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_qty')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('send_date')); ?>:</b>
	<?php echo CHtml::encode($data->send_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_date')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_time')); ?>:</b>
	<?php echo CHtml::encode($data->updated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_by')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_time')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_time); ?>
	<br />

	*/ ?>

</div>