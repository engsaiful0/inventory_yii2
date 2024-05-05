<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'supplier-mr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Create Payment Receipt</legend>
        <table>
            <?php
            
            ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                <td>
                    <div class="receivedByDiv"><?php
                    $supplier_id=  PurchaseRcvRtn::model()->supplierOfThisPoId($po_id);
                    $model->supplier_id = $supplier_id;
                    $totalReceived = PurchaseRcvRtn::model()->totalRcvAmount($po_id, $date=null, $startDate=null, $endDate=null);
                    echo Suppliers::model()->supplierNameAddr($supplier_id); ?></div>
                    <?php echo $form->hiddenField($model, 'supplier_id'); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
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
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <?php
            $totalReceived = PurchaseRcvRtn::model()->totalRcvAmount($po_id, $date=null, $startDate=null, $endDate=null);
            $totalPaid = SupplierMr::model()->totalPaidAmountOfThisPoId($po_id);
            $totalDue = $totalReceived - $totalPaid;
            ?>
            <tr>
                <td><label>Total Received Amount</label></td>
                <td><div style="font-weight: bold; border: 1px solid #aaaaaa;"><?php echo number_format(floatval($totalReceived), 2); ?></div></td>
            </tr>
            <tr>
                <td><label>Total Paid Amount</label></td>
                <td><div style="font-weight: bold; border: 1px solid #aaaaaa;"><?php echo number_format(floatval($totalPaid), 2); ?></div></td>
            </tr>
            <tr>
                <td><label>Total Due</label></td>
                <td><div style="font-weight: bold; border: 1px solid #aaaaaa;"><?php echo number_format(floatval($totalDue), 2); ?></div></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'narration'); ?></td>
                <td><?php echo $form->textField($model, 'narration', array('maxlength' => 255)); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'narration'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'received_type'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'received_type', Lookup::items("received_type"), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'received_type'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'bank_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'bank_id', CHtml::listData(Banks::model()->findAll(array('order' => 'bank_name ASC')), 'id', 'bank_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'bank_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cheque_no'); ?></td>
                <td><?php echo $form->textField($model, 'cheque_no'); ?></td>               
            </tr>
          
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'cheque_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'cheque_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'cheque_date',
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
                <td><?php echo $form->error($model, 'cheque_date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'paid_amount'); ?></td>
                <td><?php echo $form->textField($model, 'paid_amount'); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'paid_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'discount'); ?></td>
                <td><?php echo $form->textField($model, 'discount'); ?></td>               
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'discount'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton('Create PR', array('class' => 'tanim')); ?>
    </fieldset>
</div>
<style>
    table.reportTab{
        float: left;
        width: 100%;
        border-collapse: collapse;
    }
    table.reportTab tr td, table.reportTab tr th{
        text-align: center;
        border: 1px solid #b8b8b8;
        padding: 4px;
        color: #000000;
    }
    table.reportTab tr th{
        background-color: #f4f4f4;
    }
</style>
<script type="text/javascript">
    $(".tanim").click(function(e){
        $("#ajaxLoaderMR").show();
    });
</script>
<?php $this->endWidget(); ?>
