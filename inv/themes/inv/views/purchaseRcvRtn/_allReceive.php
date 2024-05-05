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
        <legend>Receive Form</legend>
        <table class="checkoutTab">
            <tr>
                <td style="text-align: right;"><label>PO No</label></td>
                <td><div class="receivedByDiv"><?php echo end($purchaseOrderInfo)->sl_no; ?></div></td>
                <td style="text-align: right;"><label>PO Issue Date</label></td>
                <td><div class="receivedByDiv"><?php echo end($purchaseOrderInfo)->issue_date; ?></div></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Ref No</label></td>
                <td><div class="receivedByDiv"><?php echo end($purchaseOrderInfo)->ref_no; ?></div></td>
                <td style="text-align: right;"><label>Supplier</label></td>
                <?php
                $dataPP = PurchaseProcurement::model()->findByPk(end($purchaseOrderInfo)->procurement_id);
                ?>
                <td><div class="receivedByDiv"><?php echo Suppliers::model()->supplierName($dataPP->supplier_id); ?></div></td>
            </tr>
            <tr>
                <td style="text-align: right;"><?php echo $form->labelEx($model, 'rcv_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'rcv_date',
                        'options' => array(
                            'showAnim' => 'fold',
                            'showOn' => 'button',
                            'buttonText' => 'Date',
                            'buttonImageOnly' => true,
                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => 'true',
                            'changeYear' => 'true',
                        ),
                        'htmlOptions' => array(
                            'id' => 'forNoConflict',
                            'style' => 'float: left;
                                        margin-top: 6px;
                                        width: 75%;',
                        ),
                    ));
                    ?>
                </td>
                <td style="text-align: right;"><?php echo $form->labelEx($model, 'challan_no'); ?></td>
                <td><?php echo $form->textField($model, 'challan_no', array('maxlength' => 255)); ?></td>
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
                <td><?php echo $form->labelEx($model, 'received_by'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'received_by', CHtml::listData(Employees::model()->findAll(array('order' => 'full_name ASC')), 'id', 'nameWithDesignation'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'store'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                        'prompt' => 'Select',
                        'style' => 'width: 100%; padding: 10px 0px;',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th>Item</th>
                <th>Order Qty</th>
                <th>Unit</th>
                <th>Remaining Receivable Qty</th>
                <th>No Of Sack</th>
                <th>Weight/Sack</th>
                <th>Receive Qty</th>
                <th style="width:70px;">Unit</th>
                <th>Remarks</th>
                <th>Cost</th>
            </tr>
            <?php
            $i = 0;
            foreach ($purchaseOrderInfo as $soi):
                ?>
                <?php
                $totalReceivedQty = PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($soi->id);
                $remainingQty = $soi->order_qty - $totalReceivedQty;
                if ($remainingQty > 0) {
                    ?>
                    <?php
                    echo $form->hiddenField($model, 'po_id[]', array('value' => $soi->id));
                    $reqData = PurchaseProcurement::model()->findByPk($soi->procurement_id);
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php Items::model()->item($reqData->item); ?></td>
                        <td style="text-align: center;"><?php echo $soi->order_qty; ?></td>
                        <td style="text-align: center;"><?php echo Units::model()->name_of_unitOfThis($soi->name_of_unit); ?></td>
                        <td>
                            <?php
                            echo $form->textField($model, 'remainingReceivableQty[]', array('value' => $remainingQty, 'id' => 'remainingReceivableQty_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $form->textField($model, 'noOfReceivedSack[]', array('id' => 'noOfReceivedSack_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $form->textField($model, 'weightPerSack[]', array('id' => 'weightPerSack_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>

                        <td>
        <?php echo $form->textField($model, 'rcv_qty[]', array('id' => 'receivedQty_' . $i, 'style' => 'text-align: center;')); ?>
                            <script type="text/javascript">
                                $(document).ready(function () {

                                    $("#remainingReceivableQty_<?php echo $i; ?>").css("background-color", "#eeeeee");
                                    $("#remainingReceivableQty_<?php echo $i; ?>").focus(function () {
                                        $(this).blur();
                                    });

                                    $("#receivedQty_<?php echo $i; ?>").css("background-color", "#eeeeee");
                                    $("#receivedQty_<?php echo $i; ?>").focus(function () {
                                        $(this).blur();
                                    });

                                    $('#weightPerSack_<?php echo $i; ?>').bind('keyup', function () {
                                        var remainingQuantity = parseFloat(('0' + $('#remainingReceivableQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        // var receiveQuantity=parseFloat( ('0' + $('#receivedQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        var noOfReceivedSack = parseFloat(('0' + $('#noOfReceivedSack_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        var weightPerSack = parseFloat(('0' + $('#weightPerSack_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        var receiveQuantity = weightPerSack * noOfReceivedSack;

                                        if (remainingQuantity < receiveQuantity) {
                                            alertify.alert("Warning! Remaining qty exceeds");
                                            $('#receivedQty_<?php echo $i; ?>').val(<?php echo $remainingQty; ?>);
                                        } else {
                                            $('#receivedQty_<?php echo $i; ?>').val(weightPerSack * noOfReceivedSack);
                                        }
                                    });

                                    $('#noOfReceivedSack_<?php echo $i; ?>').bind('keyup', function () {
                                        var remainingQuantity = parseFloat(('0' + $('#remainingReceivableQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        var noOfReceivedSack = parseFloat(('0' + $('#noOfReceivedSack_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        var weightPerSack = parseFloat(('0' + $('#weightPerSack_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10);
                                        var receiveQuantity = weightPerSack * noOfReceivedSack;

                                        if (remainingQuantity < receiveQuantity) {
                                            alertify.alert("Warning! Remaining qty exceeds");
                                            $('#receivedQty_<?php echo $i; ?>').val(<?php echo $remainingQty; ?>);
                                        } else {
                                            $('#receivedQty_<?php echo $i; ?>').val(weightPerSack * noOfReceivedSack);
                                        }
                                    });
                                });
                            </script>
                        </td>
                        <td>
                            <?php
                            echo $form->dropDownList(
                                    $model, 'name_of_unit[]', CHtml::listData(Units::model()->findAll(array('order' => 'name_of_unit ASC')), 'id', 'name_of_unit'), array(
                                'prompt' => 'Select',
                                'style' => 'width: 100%;',
                            ));
                            ?>
                        </td>            
                        <td><?php echo $form->textField($model, 'remarks_for_rcv[]', array('style' => 'text-align: center;')); ?></td>
                        <td><?php echo $form->textField($model, 'cost[]', array('id' => 'costQty_' . $i, 'style' => 'text-align: center;', 'value' => $reqData->cost)); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
<?php endforeach; ?>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
<?php echo CHtml::submitButton('Receive', array('id' => 'rcvBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#rcvBtn").click(function () {
            if ($("#forNoConflict").val() == '') {
                alertify.alert("Warning! Receive date can not be empty.");
                $("#forNoConflict").css("border-color", "#D50000");
                $("#forNoConflict").focus();
                return false;
            } else {
                $("#forNoConflict").css("border-color", "#FFFFFF");
            }
<?php for ($j = 0; $j < $i; $j++): ?>
                if ($('#receivedQty_<?php echo $j; ?>').val() == '' || $('#receivedQty_<?php echo $j; ?>').val() == 0) {
                    alertify.alert("Warning! Receive qty can not be empty OR zero.");
                    $("#receivedQty_<?php echo $j; ?>").css("border-color", "#D50000");
                    $("#receivedQty_<?php echo $j; ?>").focus();
                    return false;
                } else {
                    $("#receivedQty_<?php echo $j; ?>").css("border-color", "#FFFFFF");
                }
<?php endfor; ?>
            $("#ajaxLoaderMR").show();
        });
    })
</script>
<?php $this->endWidget(); ?>
