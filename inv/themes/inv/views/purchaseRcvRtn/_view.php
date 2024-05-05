<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('challan_no')); ?>:</b>
	<?php echo CHtml::encode($data->challan_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('po_id')); ?>:</b>
	<?php echo CHtml::encode($data->po_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_date')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rcv_qty')); ?>:</b>
	<?php echo CHtml::encode($data->rcv_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rtn_date')); ?>:</b>
	<?php echo CHtml::encode($data->rtn_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rtn_qty')); ?>:</b>
	<?php echo CHtml::encode($data->rtn_qty); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
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

	*/ ?>

</div>