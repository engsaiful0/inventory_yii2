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
		<?php echo $form->label($model,'req_no'); ?>
		<?php echo $form->textField($model,'req_no',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'req_id'); ?>
		<?php echo $form->textField($model,'req_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'d_qty'); ?>
		<?php echo $form->textField($model,'d_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'d_date'); ?>
		<?php echo $form->textField($model,'d_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'r_qty'); ?>
		<?php echo $form->textField($model,'r_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'r_date'); ?>
		<?php echo $form->textField($model,'r_date'); ?>
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
		<?php echo $form->label($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->