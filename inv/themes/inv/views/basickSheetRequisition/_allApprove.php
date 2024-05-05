<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'store-requisition-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Approve Form</legend>
        <table class="checkoutTab">
            <tr>
                <td style="text-align: right;"><label>Req No</label></td>
                <td><div class="receivedByDiv"><?php echo $reqInfo->sl_no; ?></div></td>
                <td style="text-align: right;"><label>Req Date</label></td>
                <td><div class="receivedByDiv"><?php echo $reqInfo->date; ?></div></td>
            </tr>
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
                <td><div class="receivedByDiv"><?php echo Suppliers::model()->supplierName(end($purchaseOrderInfo)->supplier_id); ?></div></td>
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
                <th>Item</th>
                <th>Order Qty</th>
                <th>Remaining Receivable Qty</th>
                <th>Receive Qty</th>
                <th>Cost</th>
            </tr>
            <?php $i = 0;
            foreach ($purchaseOrderInfo as $soi): ?>
                <?php
                echo $form->hiddenField($model, 'po_id[]', array('value' => $soi->id));
                $reqData = PurchaseRequisition::model()->findByPk($soi->requisition_id);
                $itemInfo = Items::model()->findByPk($reqData->item);
                if ($itemInfo) {
                    $itemName = $itemInfo->name;
                    $itemDesc = $itemInfo->desc;
                    $itemUnit = $itemInfo->unit;
                    $itemCat=  Cats::model()->nameOfThis($itemInfo->cat);
                    $itemSubCat=CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                } else {
                    $itemName = "";
                    $itemDesc = "";
                    $itemUnit = "";
                    $itemCat="";
                    $itemSubCat="";
                }
                ?>
                <tr>
                    <td><?php echo $itemName."<br>".$itemCat." - ".$itemSubCat . "<br>(" . $itemUnit . ")- " . $itemDesc; ?></td>
                    <td style="text-align: center;"><?php echo $soi->order_qty; ?></td>
                    <td>
                        <?php
                        $totalReceivedQty = PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($soi->id);
                        $remaining_receive_qty = ($soi->order_qty - $totalReceivedQty);
                        echo $form->textField($model, 'remainingReceivableQty[]', array('value' => $remaining_receive_qty, 'id' => 'remainingReceivableQty_' . $i, 'style' => 'text-align: center;'));
                        ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'rcv_qty[]', array('id' => 'receivedQty_' . $i, 'style' => 'text-align: center;')); ?>
                        <script type="text/javascript"> 
                            $(document).ready(function(){
                                        
                                $("#remainingReceivableQty_<?php echo $i; ?>").css("background-color", "#eeeeee");
                                $("#remainingReceivableQty_<?php echo $i; ?>").focus(function(){
                                    $(this).blur();         
                                });
                                        
                                $('#receivedQty_<?php echo $i; ?>').bind('keyup', function() {
                                    var remainingQuantity=parseFloat( ('0' + $('#remainingReceivableQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                    var receiveQuantity=parseFloat( ('0' + $('#receivedQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                    if(remainingQuantity<receiveQuantity){
                                        alertify.alert("Warning! Remaining qty exceeds");
                                        $('#receivedQty_<?php echo $i; ?>').val("");
                                    }else{
                                                    
                                    }     
                                });
                            });
                        </script>
                    </td>
                    <td><?php echo $form->textField($model, 'cost[]', array('id' => 'costQty_' . $i, 'style' => 'text-align: center;', 'value'=>$reqData->cost)); ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Receive', array('id' => 'rcvBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#rcvBtn").click(function(){
           if($("#forNoConflict").val()==''){
                alertify.alert("Warning! Receive date can not be empty.");
                $("#forNoConflict").css("border-color", "#D50000");
                $("#forNoConflict").focus();
                return false;
            }else{
                $("#forNoConflict").css("border-color", "#FFFFFF");
            }
            <?php for ($j = 0; $j < $i; $j++): ?>
                if($('#receivedQty_<?php echo $j; ?>').val()=='' || $('#receivedQty_<?php echo $j; ?>').val()==0){
                    alertify.alert("Warning! Receive qty can not be empty OR zero.");
                    $("#receivedQty_<?php echo $j; ?>").css("border-color", "#D50000");
                    $("#receivedQty_<?php echo $j; ?>").focus();
                    return false;
                }else if($('#costQty_<?php echo $j; ?>').val()==''){
                    alertify.alert("Warning! Receive qty can not be empty.");
                    $("#costQty_<?php echo $j; ?>").css("border-color", "#D50000");
                    $("#costQty_<?php echo $j; ?>").focus();
                    return false;
                }else{
                    $("#costQty_<?php echo $j; ?>").css("border-color", "#FFFFFF");
                }
            <?php endfor; ?>
            $("#ajaxLoaderMR").show();
        });
    })
</script>
<?php $this->endWidget(); ?>
