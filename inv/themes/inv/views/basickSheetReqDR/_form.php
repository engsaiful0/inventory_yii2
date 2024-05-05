<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'store-req-dr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend>Update Form</legend>            
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'd_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'd_date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                        ),
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'd_date'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'd_qty'); ?></td>
                <td><?php echo $form->textField($model, 'd_qty'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'd_qty'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'r_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'r_date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                        ),
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'r_date'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'r_qty'); ?></td>
                <td><?php echo $form->textField($model, 'r_qty'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'r_qty'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks'); ?></td>
                <td><?php echo $form->textField($model, 'remarks', array('maxlength'=>255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'remarks'); ?></td>                   
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
