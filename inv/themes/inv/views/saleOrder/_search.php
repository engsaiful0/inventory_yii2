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
		<?php echo $form->label($model,'sl_no'); ?>
		<?php echo $form->textField($model,'sl_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_sl_no'); ?>
		<?php echo $form->textField($model,'max_sl_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'issue_date'); ?>
		<?php echo $form->textField($model,'issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expected_d_date'); ?>
		<?php echo $form->textField($model,'expected_d_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subj'); ?>
		<?php echo $form->textField($model,'subj',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_type2'); ?>
		<?php echo $form->textField($model,'order_type2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pi_no'); ?>
		<?php echo $form->textField($model,'pi_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pi_date'); ?>
		<?php echo $form->textField($model,'pi_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store'); ?>
		<?php echo $form->textField($model,'store'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->