<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'member-points-conf-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Points Configuration' : 'Update Informations'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'point_add_after_amount'); ?></td>
                <td><?php echo $form->textField($model, 'point_add_after_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'point_add_after_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'point_add'); ?></td>
                <td><?php echo $form->textField($model, 'point_add'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'point_add'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'over_amount'); ?></td>
                <td><?php echo $form->textField($model, 'over_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'over_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'each_point_amount'); ?></td>
                <td><?php echo $form->textField($model, 'each_point_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'each_point_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'usable_after_point'); ?></td>
                <td><?php echo $form->textField($model, 'usable_after_point'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'usable_after_point'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'start_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $startDate2 = array(
                        'model' => $model,
                        'attribute' => 'start_date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'id' => 'startDate',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $startDate2);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'start_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'end_date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $endDate2 = array(
                        'model' => $model,
                        'attribute' => 'end_date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'id' => 'endDate',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $endDate2);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'end_date'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
