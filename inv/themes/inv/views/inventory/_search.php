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
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'store'); ?>
		<?php echo $form->textField($model,'store'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item'); ?>
		<?php echo $form->textField($model,'item'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stock_in'); ?>
		<?php echo $form->textField($model,'stock_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stock_out'); ?>
		<?php echo $form->textField($model,'stock_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'costing_price'); ?>
		<?php echo $form->textField($model,'costing_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sell_price'); ?>
		<?php echo $form->textField($model,'sell_price'); ?>
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