<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'production-input-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'max_sl_no'); ?>
		<?php echo $form->textField($model,'max_sl_no'); ?>
		<?php echo $form->error($model,'max_sl_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sl_no'); ?>
		<?php echo $form->textField($model,'sl_no',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'sl_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store'); ?>
		<?php echo $form->textField($model,'store'); ?>
		<?php echo $form->error($model,'store'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'machine'); ?>
		<?php echo $form->textField($model,'machine'); ?>
		<?php echo $form->error($model,'machine'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
		<?php echo $form->error($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->