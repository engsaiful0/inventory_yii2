<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('req_no')); ?>:</b>
	<?php echo CHtml::encode($data->req_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('req_id')); ?>:</b>
	<?php echo CHtml::encode($data->req_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('d_qty')); ?>:</b>
	<?php echo CHtml::encode($data->d_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('d_date')); ?>:</b>
	<?php echo CHtml::encode($data->d_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('r_qty')); ?>:</b>
	<?php echo CHtml::encode($data->r_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('r_date')); ?>:</b>
	<?php echo CHtml::encode($data->r_date); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>