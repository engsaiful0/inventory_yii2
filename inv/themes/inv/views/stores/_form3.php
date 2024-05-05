<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'stores-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Store Info' : 'Update Store Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'store_name'); ?></td>
                <td><?php echo $form->textField($model, 'store_name'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'store_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'location'); ?></td>
                <td><?php echo $form->textField($model, 'location', array('maxlength'=>255)); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'location'); ?></td>
            </tr>
        </table>
    </fieldset>

 <fieldset class="tblFooters">
       <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMR").show();
    }
</script>

<?php $this->endWidget(); ?>
