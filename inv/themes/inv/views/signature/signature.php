<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
   
);
?>
<h1>Contact Us</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php 
        echo Yii::app()->getBaseUrl();
        echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>



<div class="form">

<?php
echo Yii::app()->getBaseUrl();
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
     'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
	
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php
        echo $form->errorSummary($model); ?>	
        <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	<?php // endif; ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>