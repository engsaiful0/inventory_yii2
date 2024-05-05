<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->max_sl_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sl_no')); ?>:</b>
	<?php echo CHtml::encode($data->sl_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_no')); ?>:</b>
	<?php echo CHtml::encode($data->bill_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_type')); ?>:</b>
	<?php echo CHtml::encode($data->received_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_name')); ?>:</b>
	<?php echo CHtml::encode($data->bank_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_no')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheque_date')); ?>:</b>
	<?php echo CHtml::encode($data->cheque_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_of_payment')); ?>:</b>
	<?php echo CHtml::encode($data->model_of_payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid_amount')); ?>:</b>
	<?php echo CHtml::encode($data->paid_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount')); ?>:</b>
	<?php echo CHtml::encode($data->discount); ?>
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