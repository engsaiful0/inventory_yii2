<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'supplier-contact-persons-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Contact Person Info' : 'Update Contact Person Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'company_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'company_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'id DESC')), 'id', 'company_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'company_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_person_name'); ?></td>
                <td><?php echo $form->textField($model, 'contact_person_name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_person_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'designation_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'designation_id', CHtml::listData(Designations::model()->allInfos(), 'id', 'designation'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'designation_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number1'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number1', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number1'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number2'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number2', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number3'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number3', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number3'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 50)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
