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
		<?php echo $form->label($model,'challan_no'); ?>
		<?php echo $form->textField($model,'challan_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'po_id'); ?>
		<?php echo $form->textField($model,'po_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_date'); ?>
		<?php echo $form->textField($model,'rcv_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rcv_qty'); ?>
		<?php echo $form->textField($model,'rcv_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rtn_date'); ?>
		<?php echo $form->textField($model,'rtn_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rtn_qty'); ?>
		<?php echo $form->textField($model,'rtn_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remarks'); ?>
		<?php echo $form->textField($model,'remarks',array('size'=>60,'maxlength'=>255)); ?>
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