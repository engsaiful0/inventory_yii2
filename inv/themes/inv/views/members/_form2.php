<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'members-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Members Info' : 'Update Members Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'card_no'); ?></td>
                <td><?php echo $form->textField($model, 'card_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'card_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?php echo $form->textField($model, 'name', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
                <td><?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'address'); ?></td>
                <td><?php echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'address'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'dob'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                        'model' => $model,
                        'attribute' => 'dob',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'dateFormat' => 'yy-mm-dd',
                        ), 'htmlOptions' => array('class' => 'optionalInputsForPos','id'=>'Members_dob2'),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'dob'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'spouse'); ?></td>
                <td><?php echo $form->textField($model, 'spouse', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'spouse'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<style>
    
</style>
<script type="text/javascript">
    $('#Members_card_no').focus();
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
