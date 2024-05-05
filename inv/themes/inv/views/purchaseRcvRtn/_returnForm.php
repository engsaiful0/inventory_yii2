<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'purchase-rcv-rtn-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend>Return Form</legend>            
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'rtn_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'rtn_date',
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
                <td><?php echo $form->error($model, 'rtn_date'); ?></td>                   
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'weightPerSack'); ?></td>
                <td><?php echo $form->textField($model, 'weightPerSack'); ?></td>
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'noOfReceivedSack'); ?></td>
                <td><?php echo $form->textField($model, 'noOfReceivedSack'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model, 'rtn_qty'); ?></td>
                <td><?php echo $form->hiddenField($model, 'rcv_qty');
                    echo $form->textField($model, 'rtn_qty'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'rtn_qty'); ?></td>                   

            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'rtn_qty'); ?></td>                   
            </tr>
                <tr>
                <td><?php echo $form->labelEx($model, 'return_unit'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'return_unit', CHtml::listData(Units::model()->findAll(array('order' => 'name_of_unit ASC')), 'id', 'name_of_unit'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks'); ?></td>
                <td><?php echo $form->textField($model, 'remarks', array('maxlength' => '255')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'remarks'); ?></td>
            </tr>

        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
<?php echo CHtml::submitButton('Return', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
