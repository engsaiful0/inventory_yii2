<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-mr-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Create Money Receipt</legend>
        <table>
            <?php
            $model->customer_id = $customerId;
            ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                <td>
                    <div class="receivedByDiv"><?php echo Customers::model()->customerNameAndAddress($model->customer_id); ?></div>
                    <?php echo $form->hiddenField($model, 'customer_id'); ?>
                </td>
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
        </table>
        <table class="reportTab">
            <tr>
                <td style="width: 20px;"><label>SL</label></td>
                <td><?php echo $form->labelEx($model, 'bill_no'); ?></td>
                <td><label>Bill Date</label></td>
                <td><label>Due Date</label></td>
                <td style="text-align: right;"><label>Billed Amount</label></td>
                <td style="text-align: right;"><label>Previous Received Amount</label></td>
                <td style="text-align: right;"><label>Due Amount</label></td>
                <td><?php echo $form->labelEx($model, 'received_type'); ?></td>
                <td><?php echo $form->labelEx($model, 'bank_name'); ?></td>
                <td><?php echo $form->labelEx($model, 'cheque_no'); ?></td>
                <td><?php echo $form->labelEx($model, 'cheque_date'); ?></td>
                <td style="text-align: right;"><?php echo $form->labelEx($model, 'paid_amount'); ?></td>
                <td style="text-align: right;"><?php echo $form->labelEx($model, 'discount'); ?></td>
                <td><label>Total</label></td>
                <td><label>Remaining</label></td>
            </tr>
            <script>
                var receivedTypeCash='<?php echo CustomerMr::CASH; ?>';
                var receivedTypeCheque='<?php echo CustomerMr::CHEQUE; ?>';
            </script>
            <?php
            $criteria = new CDbCriteria();
            $criteria->select = "sl_no, bill_date, due_date";
            $criteria->addColumnCondition(array("customer_id" => $model->customer_id), "AND", "AND");
            $criteria->group = "sl_no";
            $billInfoGroup = CustomerBill::model()->findAll($criteria);
            $sl = 1;
            $totalbilledAmount = 0;
            $totalMrAmount = 0;
            $totalReceivableAmount = 0;
            
            if ($billInfoGroup) {
                foreach ($billInfoGroup as $big) {
                    $mrAmount = CustomerMr::model()->totalMrAmountOfThisBill($big->sl_no);
                    $billedAmount = 0;
                    $billInfo = CustomerBill::model()->findAll(array('condition' => 'sl_no="' . $big->sl_no . '"'));
                    foreach ($billInfo as $sdi) {
                        $billedAmount = SellDelvRtn::model()->totalDelvAmount($bill=1, $sl_no=$sdi->challan_no, $customer_id=null, $date=null, $startDate=null, $endDate=null) + $billedAmount;
                    }
                    $receivableAmount = ($billedAmount - $mrAmount);
                    if (number_format(floatval($receivableAmount),2) > 0) {
                        echo $form->hiddenField($model, 'bill_no[]', array('value' => $big->sl_no));
                        $totalbilledAmount = $billedAmount + $totalbilledAmount;
                        $totalMrAmount = $mrAmount + $totalMrAmount;
                        $totalReceivableAmount = $receivableAmount + $totalReceivableAmount;
                        ?>
                        <tr>
                            <td><?php echo $sl; ?></td>
                            <td><?php echo $big->sl_no; ?></td>
                            <td><?php echo $big->bill_date; ?></td>
                            <td><?php echo $big->due_date; ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($billedAmount), 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($mrAmount), 2); ?></td>
                            <td style="text-align: right;">
                                <span id="receivableAmount_<?php echo $sl; ?>"><?php echo number_format(floatval($receivableAmount), 2); ?></span>
                            </td>
                            <td>
                                <?php
                                echo $form->dropDownList(
                                        $model, 'received_type[]', Lookup::items("received_type"), array(
                                    'prompt' => 'Select',
                                    'id' => 'received_type_' . $sl,
                                ));
                                ?>
                            </td>
                            <td><?php echo $form->textField($model, 'bank_name[]', array('id' => 'bank_name_' . $sl)); ?></td>
                            <td><?php echo $form->textField($model, 'cheque_no[]', array('id' => 'cheque_no_' . $sl)); ?></td>
                            <td>
                            <?php //echo $form->textField($model, 'cheque_date[]', array('id' => 'cheque_date_' . $sl)); ?>
                                <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'cheque_date[]',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'showOn' => 'button',
                                            'buttonText' => 'Date',
                                            'buttonImageOnly' => true,
                                            'buttonImage' => Yii::app()->theme->baseUrl . '/images/calendar.png',
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'id' => 'cheque_date_' . $sl,
                                            'style' => 'float: left;
                                                        margin-top: 6px;
                                                        width: 55%;'
                                        ),
                                    ));
                                    ?>
                            </td>
                            <td><?php echo $form->textField($model, 'paid_amount[]', array('id' => 'paid_amount_' . $sl, 'class' => 'paidAmount', 'style' => 'text-align: right;')); ?></td>
                            <td><?php echo $form->textField($model, 'discount[]', array('id' => 'discount_' . $sl, 'class' => 'discountAmount', 'style' => 'text-align: right;')); ?></td>
                            <td><input style="text-align: right;" type="text" id="lineTtlInpt_<?php echo $sl; ?>" class="lineTtlInpt"/></td>
                            <td><input style="text-align: right;" type="text" id="lineTtlRemainingInpt_<?php echo $sl; ?>" class="lineTtlRemainingInpt"/></td>
                        </tr>
                        <script>
                            $("#lineTtlInpt_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                            $("#lineTtlInpt_<?php echo $sl; ?>").focus(function(){
                                $(this).blur();         
                            });
                            
                            $("#lineTtlRemainingInpt_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                            $("#lineTtlRemainingInpt_<?php echo $sl; ?>").focus(function(){
                                $(this).blur();         
                            });
                                                        
                            $('#paid_amount_<?php echo $sl; ?>').bind('keyup', function() {
                                var paidAmount=parseFloat( ('0' + $('#paid_amount_<?php echo $sl; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var discount=parseFloat( ('0' + $('#discount_<?php echo $sl; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var receivableAmount=parseFloat( ('0' + $('#receivableAmount_<?php echo $sl; ?>').html()).replace(/[^0-9-\.]/g, ''), 10 );
                                var lineTotal=paidAmount+discount;
                                var remainingAmount=(receivableAmount-lineTotal);
                                $('#subTotalPaidAmount').val( $('input.paidAmount').sumValues().toFixed(2) );
                                $('#lineTtlInpt_<?php echo $sl; ?>').val(lineTotal.toFixed(2));
                                $('#lineTtlRemainingInpt_<?php echo $sl; ?>').val(remainingAmount.toFixed(2));
                                $('#lineTotalAmount').val( $('input.lineTtlInpt').sumValues().toFixed(2) );
                                
                                var receivableAmountTotal=parseFloat( ('0' + $('#receivableAmountTotal').html()).replace(/[^0-9-\.]/g, ''), 10 );
                                var receivedAmountTotal=receivableAmountTotal-$('input.lineTtlInpt').sumValues();
                                $('#lineTotalRemainingAmount').val(receivedAmountTotal.toFixed(2) );
                            });
                                                        
                            $('#discount_<?php echo $sl; ?>').bind('keyup', function() {
                                var paidAmount=parseFloat( ('0' + $('#paid_amount_<?php echo $sl; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var discount=parseFloat( ('0' + $('#discount_<?php echo $sl; ?>').val()).replace(/[^0-9-\.]/g, ''), 10 );
                                var receivableAmount=parseFloat( ('0' + $('#receivableAmount_<?php echo $sl; ?>').html()).replace(/[^0-9-\.]/g, ''), 10 );
                                var lineTotal=paidAmount+discount;
                                var remainingAmount=(receivableAmount-lineTotal);
                                $('#totalDiscount').val( $('input.discountAmount').sumValues().toFixed(2) );
                                $('#lineTtlInpt_<?php echo $sl; ?>').val(lineTotal.toFixed(2));
                                $('#lineTtlRemainingInpt_<?php echo $sl; ?>').val(remainingAmount.toFixed(2));
                                $('#lineTotalAmount').val( $('input.lineTtlInpt').sumValues().toFixed(2) );
                                
                                var receivableAmountTotal=parseFloat( ('0' + $('#receivableAmountTotal').html()).replace(/[^0-9-\.]/g, ''), 10 );
                                var receivedAmountTotal=receivableAmountTotal-$('input.lineTtlInpt').sumValues();
                                $('#lineTotalRemainingAmount').val(receivedAmountTotal.toFixed(2) );
                            });
                                                        
                            $("#bank_name_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                            $("#bank_name_<?php echo $sl; ?>").focus(function(){
                                $(this).blur();         
                            });
                            $("#bank_name_<?php echo $sl; ?>").val("");
                            $("#cheque_no_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                            $("#cheque_no_<?php echo $sl; ?>").focus(function(){
                                $(this).blur();         
                            });
                            $("#cheque_no_<?php echo $sl; ?>").val("");
                            $("#cheque_date_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                            $("#cheque_date_<?php echo $sl; ?>").focus(function(){
                                $(this).blur();         
                            });
                            $("#cheque_date_<?php echo $sl; ?>").val("");
                            $("#received_type_<?php echo $sl; ?>").change(function(){
                                if(this.value==receivedTypeCash){
                                    $("#bank_name_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#bank_name_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#bank_name_<?php echo $sl; ?>").val("");
                                    $("#cheque_no_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#cheque_no_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#cheque_no_<?php echo $sl; ?>").val("");
                                    $("#cheque_date_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#cheque_date_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#cheque_date_<?php echo $sl; ?>").val("");
                                }else if(this.value==receivedTypeCheque){
                                    $("#bank_name_<?php echo $sl; ?>").css("background-color","#ffffff");
                                    $("#bank_name_<?php echo $sl; ?>").unbind();
                                    $("#cheque_no_<?php echo $sl; ?>").css("background-color","#ffffff");
                                    $("#cheque_no_<?php echo $sl; ?>").unbind();
                                    $("#cheque_date_<?php echo $sl; ?>").css("background-color","#ffffff");
                                    $("#cheque_date_<?php echo $sl; ?>").unbind();
                                }else{
                                    $("#bank_name_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#bank_name_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#bank_name_<?php echo $sl; ?>").val("");
                                    $("#cheque_no_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#cheque_no_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#cheque_no_<?php echo $sl; ?>").val("");
                                    $("#cheque_date_<?php echo $sl; ?>").css("background-color","#d7d7d7");
                                    $("#cheque_date_<?php echo $sl; ?>").focus(function(){
                                        $(this).blur();         
                                    });
                                    $("#cheque_date_<?php echo $sl; ?>").val("");
                                }
                            })
                        </script>
                        <?php
                        $sl++;
                    }
                }
                ?>
                <tr>
                    <td colspan="4" style="font-weight: bold; tex-align: right;"><label>Total</label></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><?php echo number_format(floatval($totalbilledAmount), 2); ?></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><?php echo number_format(floatval($totalMrAmount), 2); ?></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;">
                        <span id="receivableAmountTotal"><?php echo number_format(floatval($totalReceivableAmount), 2); ?></span>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><input type="text" value="0.00" id="subTotalPaidAmount" style="text-align: right; color: #000000; font-weight: bold; border: none;"/></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><input type="text" value="0.00" id="totalDiscount" style="text-align: right; color: #000000; font-weight: bold; border: none;"/></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><input type="text" value="0.00" id="lineTotalAmount" style="text-align: right; color: #000000; font-weight: bold; border: none;"/></td>
                    <td style="font-weight: bold; text-align: right; background-color: #d7d7d7;"><input type="text" value="0.00" id="lineTotalRemainingAmount" style="text-align: right; color: #000000; font-weight: bold; border: none;"/></td>
                </tr>
                <?php
            }
            $totalCount = ($sl - 1);
            ?>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton('Create MR', array('class' => 'tanim')); ?>
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
    var totalCount='<?php echo $totalCount; ?>';
    var errCount=new Array();
    $(".tanim").click(function(e){
                if($("#CustomerMr_date").val()==""){
                   alertify.alert("MR Date can not be blank.");
                     e.preventDefault();
                     return false;
              }else if($("#subTotalPaidAmount").val()=="0.00"){
                  alertify.alert("Please check total receive amount !");
                  e.preventDefault();
                  return false;
              }else{
                  for(var j=1; j<=totalCount; j++){
                      if($("#paid_amount_"+j).val()>0){
                          if($("#received_type_"+j).val()==""){
                              $("#received_type_"+j).css("border-color","red");
                              errCount[j]="err_exist";
                          }else{
                              $("#received_type_"+j).css("border-color","#aaaaaa");
                              errCount[j]="";
                          }
                      }
                  }
                  if($.inArray("err_exist", errCount)>-1){
                      alertify.alert("Please set receive type !");
                      e.preventDefault();
                      return false;
                  }else{
                      $("#ajaxLoaderMR").show();
                  }
              }
    });
    $("#subTotalPaidAmount").css("background-color","#d7d7d7");
    $("#subTotalPaidAmount").focus(function(){
        $(this).blur();         
    });
    $("#totalDiscount").css("background-color","#d7d7d7");
    $("#totalDiscount").focus(function(){
        $(this).blur();         
    });
    $("#lineTotalAmount").css("background-color","#d7d7d7");
    $("#lineTotalAmount").focus(function(){
        $(this).blur();         
    });
    $("#lineTotalRemainingAmount").css("background-color","#d7d7d7");
    $("#lineTotalRemainingAmount").focus(function(){
        $(this).blur();         
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
