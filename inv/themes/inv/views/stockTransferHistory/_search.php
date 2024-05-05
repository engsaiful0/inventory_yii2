<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'from_store'); ?>
		<?php echo $form->textField($model,'from_store'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'to_store'); ?>
		<?php echo $form->textField($model,'to_store'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'send_qty'); ?>
		<?php echo $form->textField($model,'send_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_qty'); ?>
		<?php echo $form->textField($model,'rcv_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'send_date'); ?>
		<?php echo $form->textField($model,'send_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_date'); ?>
		<?php echo $form->textField($model,'rcv_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_time'); ?>
		<?php echo $form->textField($model,'updated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_by'); ?>
		<?php echo $form->textField($model,'rcv_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_time'); ?>
		<?php echo $form->textField($model,'rcv_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->