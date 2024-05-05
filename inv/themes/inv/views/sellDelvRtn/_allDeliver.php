<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'sell-delv-rtn-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Delivery Form</legend>
        <table class="checkoutTab">
            <tr>
                <td style="text-align: left; padding-bottom: 10px; vertical-align: top;">
                    SO No: <?php echo end($sellOrderInfo)->sl_no; ?><br/>
                    Local/Export: <?php echo Lookup::item('order_type2', end($sellOrderInfo)->order_type2); ?>, 
                    Store: <?php echo Stores::model()->storeName(end($sellOrderInfo)->store); ?>
                    <?php if (end($sellOrderInfo)->pi_no != "") { ?>
                        <br/>PI/PO No: <?php echo end($sellOrderInfo)->pi_no; ?>
                    <?php } ?>
                    <?php if (end($sellOrderInfo)->pi_date != "0000-00-00") { ?>
                        <br/>PI/PO Date: <?php echo end($sellOrderInfo)->pi_date; ?>
                    <?php } ?>
                </td>
                <td style="text-align: right; padding-bottom: 10px; vertical-align: top;">
                    Issue Date: <?php echo end($sellOrderInfo)->issue_date; ?><br/>
                    Expected D.Date: <?php echo end($sellOrderInfo)->expected_d_date; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; padding-bottom: 10px;">
                    Customer: <br/><?php echo Customers::model()->customerNameAndAddress(end($sellOrderInfo)->customer_id); ?>
                    <?php
                    $model->customer_id = end($sellOrderInfo)->customer_id;
                    echo $form->hiddenField($model, 'customer_id');
                    ?>
                    <?php if (end($sellOrderInfo)->contact_person != "") { ?>
                        Contact Person: <?php echo CustomerContactPersons::model()->allInfoOfThis(end($sellOrderInfo)->contact_person); ?><br/>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left; padding-bottom: 10px;">
                    <?php if (end($sellOrderInfo)->subj != "") { ?>
                        Subj/Remarks: <i><?php echo end($sellOrderInfo)->subj; ?></i>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;"><?php echo $form->labelEx($model, 'd_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'd_date',
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
            </tr>
            <tr>
                <td style="text-align: right;"><label>Vehicle Type</label></td>
                <td><?php echo $form->textField($model, 'vehicle_type', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Vehicle No</label></td>
                <td><?php echo $form->textField($model, 'vehicle_no', array('maxlength' => 255)); ?></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Remarks</label></td>
                <td><?php echo $form->textField($model, 'remarks1', array('maxlength' => 255)); ?></td>
            </tr>
        </table>
        <table class="checkoutTab">
            <th>Item</th>
            <th>Order Qty</th>
            <th>Converted Unit</th>
            <th>Remaining Deliverable Qty</th>
            <th>Stock Qty</th>
            <th>Delivery Qty</th>
            <th>Delivery Qty(KG)</th>
            </tr>
            <?php $i = 0;
            foreach ($sellOrderInfo as $soi): ?>
                <?php
                $totalDeliveryQty = SellDelvRtn::model()->availableQtyOfThisSellOrderId($soi->id);
                $remainingQty = $soi->qty - $totalDeliveryQty;
                $convertedText="";
                if ($remainingQty > 0) {
                    $qty = $soi->qty;
                    $conv_unit = $soi->conv_unit;

                    $itemInfo = Items::model()->findByPk($soi->item);
                    if ($itemInfo) {
                        $desc = $itemInfo->desc;
                        $unitConvertable = $itemInfo->unit_convertable;

                        $convertedUnit = Items::model()->convertedUnit($unitConvertable, $desc);
                        $sft = $convertedUnit[0];
                        $rft = $convertedUnit[1];
                        $cft = $convertedUnit[2];
                        $sqm = $convertedUnit[3];
                        
                        if ($conv_unit == Items::SFT) {
                            $qty = $sft;
                            $convertedText = $qty . " SFT";
                        } else if ($conv_unit == Items::RFT) {
                            $qty = $rft;
                            $convertedText = $qty . " RFT";
                        } else if ($conv_unit == Items::CFT) {
                            $qty = $cft * $qty;
                            $convertedText = $qty . " CFT";
                        } else if ($conv_unit == Items::SQM) {
                            $qty = $sqm;
                            $convertedText = $qty . " SQM";
                        } else {
                            $convertedText = "";
                        }
                    }
                    ?>
                    <?php
                    echo $form->hiddenField($model, 'so_id[]', array('value' => $soi->id));
                    $reqData = SaleOrder::model()->findByPk($soi->id);
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php Items::model()->item($reqData->item);
            ; ?></td>
                        <td style="text-align: center;"><?php echo $soi->qty; ?></td>
                        <td style="text-align: center;"><?php echo $convertedText; ?></td>
                        <td>
                            <?php
                            echo $form->textField($model, 'remainingDeliverableQty[]', array('value' => $remainingQty, 'id' => 'remainingDeliverableQty_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
                            <?php
                            $stockQtyMainInventory = Inventory::model()->presentStockOfThisItem($soi->item, $soi->store);
                            echo $form->textField($model, 'stockQty[]', array('value' => $stockQtyMainInventory, 'id' => 'stockQty_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
        <?php echo $form->textField($model, 'd_qty[]', array('class' => 'lineTotalInpt', 'id' => 'deliveryQty_' . $i, 'style' => 'text-align: center;')); ?>
                            <script type="text/javascript"> 
                                $(document).ready(function(){
                                                        
                                    $("#remainingDeliverableQty_<?php echo $i; ?>").css("background-color", "#eeeeee");
                                    $("#remainingDeliverableQty_<?php echo $i; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                                
                                    $("#stockQty_<?php echo $i; ?>").css("background-color", "#eeeeee");
                                    $("#stockQty_<?php echo $i; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                                        
                                    $('#deliveryQty_<?php echo $i; ?>').bind('keyup', function() {
                                        var remainingQuantity=parseFloat( ('0' + $('#remainingDeliverableQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        var stockQuantity=parseFloat( ('0' + $('#stockQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        var deliveryQuantity=parseFloat( ('0' + $('#deliveryQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        if(remainingQuantity < deliveryQuantity){
                                            alertify.alert("Warning! Remaining qty exceeds");
                                            $('#deliveryQty_<?php echo $i; ?>').val("");
                                        }else if(stockQuantity < deliveryQuantity){
                                            alertify.alert("Warning! Stock qty exceeds");
                                            $('#deliveryQty_<?php echo $i; ?>').val("");
                                        }else{
                                            $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );         
                                        }     
                                    });
                                });
                            </script>
                        </td>
                        <td><?php echo $form->textField($model, 'd_qty_kg[]', array('style' => 'text-align: center;')); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
<?php endforeach; ?>
        </table>
        <input type="hidden" id="cashTotal" value="0"/>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
<?php echo CHtml::submitButton('Deliver', array('id' => 'rcvBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $("#rcvBtn").click(function(e){
        if($("#forNoConflict").val()==''){
            alertify.alert("Warning! Delivery date can not be empty.");
            $("#forNoConflict").css("border-color", "#D50000");
            $("#forNoConflict").focus();
            e.preventDefault();
            return false;
        }else if($("#cashTotal").val()<=0){
            alertify.alert("Warning! Please check total delivery qty.");
            e.preventDefault();
            return false;
        }else{
            $("#forNoConflict").css("border-color", "#FFFFFF");
        }
           
        $("#ajaxLoaderMR").show();
    });
    $.fn.sumValues = function() {
        var sum = 0; 
        this.each(function() {
            if ( $(this).is(':input') ) {
                var val = $(this).val();
            } else {
                var val = $(this).text();
            }
            sum += parseFloat( ('0' + val).replace(/[^0-9-\.]/g, ''), 10 );
        });
        return sum;
    };
</script>
<?php $this->endWidget(); ?>
