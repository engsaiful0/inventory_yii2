<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'credit-memo-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));

$model->customer_id=end($billInfo)->customer_id;
echo $form->hiddenField($model, 'customer_id');
$model->bill_no=end($billInfo)->sl_no;
echo $form->hiddenField($model, 'bill_no');
?>
<div class="formDiv">
    <fieldset>
        <legend>Create Credit Memo for Bill Number: <b><?php end($billInfo)->sl_no; ?></b></legend>
        <table style="width: 60%;">
            <tr>
                <td><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                <td><?php echo Customers::model()->customerNameAndAddress($model->customer_id); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model,'customer_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'showOn' => 'button',
                            'buttonText' => 'Date',
                            'buttonImageOnly' => true,
                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'style' => 'float: left;
                                        margin-top: 6px;
                                        width: 61%;'
                        ),
                    ));
                    ?>
                </td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model,'date'); ?></td>
            </tr>
            <tr>
                <td><label>Total Billed Amount (Paid)</label></td>
                <td><div style="font-weight: bold; border: 1px solid #aaaaaa;"><?php echo number_format(floatval(CustomerMr::model()->totalMrAmountOfThisBill(end($billInfo)->sl_no)),2); ?></div></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'discount'); ?></td>
                <td><?php echo $form->textField($model,'discount'); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model,'discount'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Create', array('class' => 'billCreateBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $(".billCreateBtn").click(function(e){
        $("#ajaxLoaderMR").show(); 
    });
</script>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Credit Memo Voucher Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
