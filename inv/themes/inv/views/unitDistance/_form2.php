<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'unitDistance-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Unit Of Distance' : 'Update Unit Of Distance'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'unit_of_distance'); ?></td>
                <td><?php echo $form->textField($model, 'unit_of_distance', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'unit_of_distance'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
       <span id="ajaxLoaderGrade" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderGrade").show();
    }
</script>
<?php $this->endWidget(); ?>
