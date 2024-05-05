<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stock-transfer-history-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from_store'); ?>
		<?php echo $form->textField($model,'from_store'); ?>
		<?php echo $form->error($model,'from_store'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to_store'); ?>
		<?php echo $form->textField($model,'to_store'); ?>
		<?php echo $form->error($model,'to_store'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_qty'); ?>
		<?php echo $form->textField($model,'send_qty'); ?>
		<?php echo $form->error($model,'send_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rcv_qty'); ?>
		<?php echo $form->textField($model,'rcv_qty'); ?>
		<?php echo $form->error($model,'rcv_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'send_date'); ?>
		<?php echo $form->textField($model,'send_date'); ?>
		<?php echo $form->error($model,'send_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rcv_date'); ?>
		<?php echo $form->textField($model,'rcv_date'); ?>
		<?php echo $form->error($model,'rcv_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
		<?php echo $form->error($model,'created_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
		<?php echo $form->error($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_time'); ?>
		<?php echo $form->textField($model,'updated_time'); ?>
		<?php echo $form->error($model,'updated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rcv_by'); ?>
		<?php echo $form->textField($model,'rcv_by'); ?>
		<?php echo $form->error($model,'rcv_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rcv_time'); ?>
		<?php echo $form->textField($model,'rcv_time'); ?>
		<?php echo $form->error($model,'rcv_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->