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
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_no'); ?>
		<?php echo $form->textField($model,'lc_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_amount'); ?>
		<?php echo $form->textField($model,'lc_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shipment_date'); ?>
		<?php echo $form->textField($model,'shipment_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expire_date'); ?>
		<?php echo $form->textField($model,'expire_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_date'); ?>
		<?php echo $form->textField($model,'lc_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lc_tenor_id'); ?>
		<?php echo $form->textField($model,'lc_tenor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'export_lc_no'); ?>
		<?php echo $form->textField($model,'export_lc_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bank_id'); ?>
		<?php echo $form->textField($model,'bank_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'remarks'); ?>
		<?php echo $form->textField($model,'remarks',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'po_no'); ?>
		<?php echo $form->textField($model,'po_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->