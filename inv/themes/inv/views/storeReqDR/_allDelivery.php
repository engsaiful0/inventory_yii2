<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'store-req-dr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Send Stock Form</legend>
        <table class="checkoutTab">
            <tr>
                <td style="text-align: right;"><label>Req No</label></td>
                <td><div class="receivedByDiv"><?php echo end($reqInfo)->sl_no; ?></div></td>
                <td style="text-align: right;"><label>Req Date</label></td>
                <td><div class="receivedByDiv"><?php echo end($reqInfo)->req_date; ?></div></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Req. from</label></td>
                <td><div class="receivedByDiv"><?php echo Stores::model()->storeNameAndAddr(end($reqInfo)->from_store); ?></div></td>
                <td style="text-align: right;"><label>Req. to</label></td>
                <td><div class="receivedByDiv"><?php echo Stores::model()->storeNameAndAddr(end($reqInfo)->store); ?></div></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: right;"><label>Department</label></td>
                <td><div class="receivedByDiv"><?php echo Departments::model()->nameOfThis(end($reqInfo)->department); ?></div></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td style="text-align: right;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Item</th>
                <th>Stock Qty (Main Inventory)</th>
                <th>Stock Qty (Temporary Inventory)</th>
                <th>Requisition Qty</th>
                <th>Remaining Sendable Qty</th>
                <th>Sending Qty</th>
            </tr>
            <?php $i = 0;
            foreach ($reqInfo as $soi): ?>
                <?php
                $totalReceivedQty = StoreReqDR::model()->availableQtyOfThisReqId($soi->id);
                $remaining_receive_qty = ($soi->qty - $totalReceivedQty);
                if ($remaining_receive_qty > 0) {
                    ?>
                    <?php
                    echo $form->hiddenField($model, 'req_id[]', array('value' => $soi->id));
                    $itemInfo = Items::model()->findByPk($soi->item);
                    if ($itemInfo) {
                        $itemName = $itemInfo->name;
                        $itemUnit = $itemInfo->unit;
                        $itemDesc = $itemInfo->desc;
                        $itemCode=$itemInfo->code;
                    } else {
                        $itemName = "<font color='red'>Removed!</font>";
                        $itemUnit = "";
                        $itemDesc = "";
                        $itemCode="";
                    }
                    ?>
                    <tr>
                        <td style="text-align: left;"><?php echo $itemName . " (" . $itemUnit . ")- " . $itemDesc."<br>".$itemCode; ?></td>
                        <td>
                            <?php
                            $stockQtyMainInventory=Inventory::model()->presentStockOfThisItem($soi->item, $soi->store);
                            $stockQtyStoreInventory=  StoreInventory::model()->presentStockOfThisItem($soi->item, $soi->store);
                            echo $form->textField($model, 'stockQty[]', array('value' => $stockQtyMainInventory, 'id' => 'stockQty_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
                            <?php echo $stockQtyStoreInventory; ?>
                        </td>
                        <td style="text-align: center;"><?php echo $soi->qty; ?></td>
                        <td>
                            <?php
                            echo $form->textField($model, 'remainingDeliverableQty[]', array('value' => $remaining_receive_qty, 'id' => 'remainingDeliverableQty_' . $i, 'style' => 'text-align: center;'));
                            ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'd_qty[]', array('id' => 'deliveredQty_' . $i, 'class'=>'lineTotalInpt', 'style' => 'text-align: center;')); ?>
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
                                                
                                    $('#deliveredQty_<?php echo $i; ?>').bind('keyup', function() {
                                        var remainingQuantity=parseFloat( ('0' + $('#remainingDeliverableQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        var stockQuantity=parseFloat( ('0' + $('#stockQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        var deliveryQuantity=parseFloat( ('0' + $('#deliveredQty_<?php echo $i; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                        if(remainingQuantity < deliveryQuantity){
                                            alertify.alert("Warning! Remaining qty exceeds");
                                            $('#deliveredQty_<?php echo $i; ?>').val("");
                                        }else if(stockQuantity < deliveryQuantity){
                                            alertify.alert("Warning! Stock qty exceeds");
                                            $('#deliveredQty_<?php echo $i; ?>').val("");
                                        }else{
                                             $('#cashTotal').val( $('input.lineTotalInpt').sumValues() );           
                                        }     
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Send', array('id' => 'rcvBtn')); ?>
    </fieldset>
</div>
<input type="hidden" id="cashTotal"/>
<script type="text/javascript">
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
    $(document).ready(function(){
        $("#rcvBtn").click(function(){
            if($("#forNoConflict").val()==''){
                alertify.alert("Warning! Sending date can not be empty.");
                $("#forNoConflict").css("border-color", "#D50000");
                $("#forNoConflict").focus();
                return false;
            }else{
                $("#forNoConflict").css("border-color", "#FFFFFF");
            }
            if($("#cashTotal").val()>0){
                $("#ajaxLoaderMR").show();
            }else{
                <?php for ($j = 0; $j < $i; $j++): ?>
                            if($('#deliveredQty_<?php echo $j; ?>').val()==''){
                                alertify.alert("Warning! Sending qty can not be empty.");
                                $("#deliveredQty_<?php echo $j; ?>").css("border-color", "#D50000");
                                $("#deliveredQty_<?php echo $j; ?>").focus();
                                return false;
                            }else{
                                $("#deliveredQty_<?php echo $j; ?>").css("border-color", "#FFFFFF");
                            }
                <?php endfor; ?>
            }    
                    });
                })
</script>
<?php $this->endWidget(); ?>
