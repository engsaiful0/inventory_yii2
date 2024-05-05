<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'member-points-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Reduce Member Points</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'member_id'); ?></td>
                <td>
                    <div class="receivedByDiv">
                        <?php
                            $model->member_id=$memberInfo->id;
                            echo $form->hiddenField($model, 'member_id');
                            echo "Card Number: ".$memberInfo->card_no.", Contact Number: ".$memberInfo->contact_no;
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'member_id'); ?></td>
            </tr>
            <tr>
                <td><label>Available Points</label></td>
                <td><div class="receivedByDiv"><?php echo $memberInfo->available_point; ?></div></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'inv_no'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'inv_no', array('maxlength' => 255, 'class'=>'optionalInputsForPos')); ?>
                    <span style="font-style: italic; color: red; float: left;"><b>Suggestion:</b> If you reduce points against Invoice No while you are giving
                        the customer discount, it is recommended that you update that invoice and give the discount using points from POS</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'inv_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $startDate = array(
                        'model' => $model,
                        'attribute' => 'date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $startDate);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'used_point'); ?></td>
                <td><?php echo $form->textField($model, 'used_point', array('class'=>'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'used_point'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'remarks'); ?></td>
                <td><?php echo $form->textField($model, 'remarks', array('maxlength' => 255, 'class'=>'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'remarks'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Save', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
