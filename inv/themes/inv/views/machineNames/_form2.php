<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'machine-names-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add Machine' : 'Update Machine'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'ip_address'); ?></td>
                <td><?php echo $form->textField($model, 'ip_address', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ip_address'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'machine_name'); ?></td>
                <td><?php echo $form->textField($model, 'machine_name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'machine_name'); ?></td>
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