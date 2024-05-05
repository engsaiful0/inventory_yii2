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
		<?php echo $form->label($model,'ref_no'); ?>
		<?php echo $form->textField($model,'ref_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'issue_date'); ?>
		<?php echo $form->textField($model,'issue_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisition_id'); ?>
		<?php echo $form->textField($model,'requisition_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_qty'); ?>
		<?php echo $form->textField($model,'order_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subj'); ?>
		<?php echo $form->textField($model,'subj',array('size'=>60,'maxlength'=>255)); ?>
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