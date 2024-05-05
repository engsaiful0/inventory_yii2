<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_id')); ?>:</b>
	<?php echo CHtml::encode($data->lc_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pi_no')); ?>:</b>
	<?php echo CHtml::encode($data->pi_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pi_date')); ?>:</b>
	<?php echo CHtml::encode($data->pi_date); ?>
	<br />


</div>