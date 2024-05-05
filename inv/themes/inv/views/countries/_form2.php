<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'countries-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Country' : 'Update Country'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'iso2'); ?></td>
                <td><?php echo $form->textField($model, 'iso2', array('maxlength'=>2)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'iso2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'iso3'); ?></td>
                <td><?php echo $form->textField($model, 'iso3', array('maxlength'=>3)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'iso3'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'country'); ?></td>
                <td><?php echo $form->textField($model, 'country', array('maxlength'=>64)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'country'); ?></td>
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
