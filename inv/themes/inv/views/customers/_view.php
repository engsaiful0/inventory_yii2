<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_name')); ?>:</b>
	<?php echo CHtml::encode($data->company_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_address')); ?>:</b>
	<?php echo CHtml::encode($data->company_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_contact_no')); ?>:</b>
	<?php echo CHtml::encode($data->company_contact_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_fax')); ?>:</b>
	<?php echo CHtml::encode($data->company_fax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_email')); ?>:</b>
	<?php echo CHtml::encode($data->company_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_web')); ?>:</b>
	<?php echo CHtml::encode($data->company_web); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_person')); ?>:</b>
	<?php echo CHtml::encode($data->contact_person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('designation_id')); ?>:</b>
	<?php echo CHtml::encode($data->designation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_no')); ?>:</b>
	<?php echo CHtml::encode($data->contact_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_email')); ?>:</b>
	<?php echo CHtml::encode($data->contact_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contact_address')); ?>:</b>
	<?php echo CHtml::encode($data->contact_address); ?>
	<br />

	*/ ?>

</div>