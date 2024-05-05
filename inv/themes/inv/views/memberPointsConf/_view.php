<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('point_add')); ?>:</b>
	<?php echo CHtml::encode($data->point_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('over_amount')); ?>:</b>
	<?php echo CHtml::encode($data->over_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('each_point_amount')); ?>:</b>
	<?php echo CHtml::encode($data->each_point_amount); ?>
	<br />


</div>