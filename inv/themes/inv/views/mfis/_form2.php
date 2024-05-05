<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'mfis-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New MFI' : 'Update MFI'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'name'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
       <span id="ajaxLoaderMfi" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMfi").show();
    }
</script>
<?php $this->endWidget(); ?>
