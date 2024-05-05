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
        <legend>Update Form</legend>            
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'challan_no'); ?></td>
                <td><?php echo $form->textField($model, 'challan_no', array('maxlength' => '255')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'challan_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'rcv_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'rcv_date',
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
                <td><?php echo $form->error($model, 'rcv_date'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'rcv_qty'); ?></td>
                <td><?php echo $form->textField($model, 'rcv_qty'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'rcv_qty'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks_for_rcv'); ?></td>
                <td><?php echo $form->textField($model, 'remarks_for_rcv', array('maxlength'=>255)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'remarks_for_rcv'); ?></td>                   
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cost'); ?></td>
                <td><?php echo $form->textField($model, 'cost'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cost'); ?></td>                   
            </tr>
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
                <td><?php echo $form->labelEx($model, 'rtn_qty'); ?></td>
                <td><?php echo $form->textField($model, 'rtn_qty'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'rtn_qty'); ?></td>                   
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
