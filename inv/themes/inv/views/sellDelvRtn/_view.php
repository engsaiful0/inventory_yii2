<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->sl_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->max_sl_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('so_id')); ?>:</b>
	<?php echo CHtml::encode($data->so_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('so_no')); ?>:</b>
	<?php echo CHtml::encode($data->so_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('d_date')); ?>:</b>
	<?php echo CHtml::encode($data->d_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('d_qty')); ?>:</b>
	<?php echo CHtml::encode($data->d_qty); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('r_qty')); ?>:</b>
	<?php echo CHtml::encode($data->r_qty); ?>
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