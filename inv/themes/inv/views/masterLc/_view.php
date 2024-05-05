<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_no')); ?>:</b>
	<?php echo CHtml::encode($data->lc_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_amount')); ?>:</b>
	<?php echo CHtml::encode($data->lc_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipment_date')); ?>:</b>
	<?php echo CHtml::encode($data->shipment_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expire_date')); ?>:</b>
	<?php echo CHtml::encode($data->expire_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_date')); ?>:</b>
	<?php echo CHtml::encode($data->lc_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('lc_tenor_id')); ?>:</b>
	<?php echo CHtml::encode($data->lc_tenor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('export_lc_no')); ?>:</b>
	<?php echo CHtml::encode($data->export_lc_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_id')); ?>:</b>
	<?php echo CHtml::encode($data->bank_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('po_no')); ?>:</b>
	<?php echo CHtml::encode($data->po_no); ?>
	<br />

	*/ ?>

</div>