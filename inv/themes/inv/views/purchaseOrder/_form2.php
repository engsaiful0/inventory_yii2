<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sale-order-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update Information</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'ref_no'); ?></td>
                <td><?php echo $form->textField($model, 'ref_no', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'ref_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'subj'); ?></td>
                <td><?php echo $form->textField($model, 'subj', array('maxlength' => 255)); ?></td>            
            </tr>

            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'subj'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'issue_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model,
                        'attribute' => 'issue_date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'issue_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'order_qty'); ?></td>
                <td><?php echo $form->textField($model, 'order_qty'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'order_qty'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'name_of_unit'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'name_of_unit', CHtml::listData(Units::model()->findAll(array('order' => 'name_of_unit ASC')), 'id', 'name_of_unit'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'order_qty'); ?></td>
            </tr>
            <tr>
                <td ><?php echo $form->labelEx($model, 'approved_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'approved_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'purchase_order_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'purchase_order_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay() {
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
