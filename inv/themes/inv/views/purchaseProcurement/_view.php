<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('req_id')); ?>:</b>
	<?php echo CHtml::encode($data->req_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->sl_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->max_sl_no); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

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

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_po_created')); ?>:</b>
	<?php echo CHtml::encode($data->is_po_created); ?>
	<br />

	*/ ?>

</div>