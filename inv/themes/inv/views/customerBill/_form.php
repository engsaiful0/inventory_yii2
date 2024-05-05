<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-bill-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
$customerIds=explode(",", $customerIds);
$model->customer_id=$customerIds[0];
echo $form->hiddenField($model, 'customer_id');
?>
<div class="formDiv">
    <fieldset>
        <legend>Create Bill</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                <td><?php echo Customers::model()->customerNameAndAddress($model->customer_id); ?></td>               
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'bill_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'bill_date',
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
                <td><?php echo $form->labelEx($model, 'due_date'); ?></td>
                <td>
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'due_date',
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
                <td colspan="2" style="padding: 20px 0px;"> </td>
            </tr>
        </table>
        <?php
        echo "<div class='grid-view'>";
        echo "<table class='items'>";
        echo "<tr>";
        echo "<th style='width: 20px;'>SL</th>";
        echo "<th>Challan No</th>";
        echo "<th>Item</th>";
        echo "<th>Qty</th>";
        echo "<th>Converted Unit</th>";
        echo "<th>Rate</th>";
        echo "<th>Amount</th>";
        echo "<th>Total Bill</th>";
        echo "</tr>";
        $challanNumbersArray = explode(",", $challanNumbers);
        $sl = 1;
        $totalAmount=0;
        $totalCount = count($challanNumbersArray);
        
        for ($i = 0; $i < $totalCount; $i++) {
            $data=SellDelvRtn::model()->findAll(array('condition'=>'sl_no="'.$challanNumbersArray[$i].'"'));
            
            echo "<input type='hidden' name='CustomerBill[challan_no][]' value='" . $challanNumbersArray[$i] . "'>";
            $rowspan=count($data);
            $subtotalAmount=0;
            $rowCountPlus=1;
            foreach($data as $d){
                $actualDeliveryQty = ($d->d_qty - $d->r_qty);
                $soInfo=  SaleOrder::model()->findByPk($d->so_id);
                
                $qty = $soInfo->qty;
                $price = $soInfo->price;
                $conv_unit = $soInfo->conv_unit;
                $convertedText="";
                if ($conv_unit != "") {
                        $itemInfo = Items::model()->findByPk($soInfo->item);
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
                                $convertedText = $qty." SFT";
                            } else if ($conv_unit == Items::RFT) {
                                $qty = $rft;
                                $convertedText = $qty." RFT";
                            } else if ($conv_unit == Items::CFT) {
                                $qty = $cft * $actualDeliveryQty;
                                $convertedText = $qty." CFT";
                            } else if ($conv_unit == Items::SQM) {
                                $qty = $sqm;
                                $convertedText = $qty." SQM";
                            } else {
                                $qty = $qty;
                            }
                        }
                        $amount = $qty * $price;
                        $subtotalAmount = $amount + $subtotalAmount;
                        $totalAmount = $amount + $totalAmount;
                } else {
                    $amount = $actualDeliveryQty * $price;
                    $subtotalAmount = $amount + $subtotalAmount;
                    $totalAmount = $amount + $totalAmount;
                }
                echo "<tr>";
                if($rowCountPlus==1){
                    echo "<td rowspan='".$rowspan."'>" . $sl . "</td>";
                    echo "<td rowspan='".$rowspan."'>" . $challanNumbersArray[$i] . "</td>";
                }
               ?>
                    <td style='text-align: left;'><?php Items::model()->item($d->item); ?></td>
                    <?php
                echo "<td>".$actualDeliveryQty."</td>";
                echo "<td>".$convertedText."</td>";
                echo "<td>".number_format(floatval($price),2)."</td>";
                echo "<td>".number_format(floatval($amount),2)."</td>";
                if($rowCountPlus==1){
                    echo "<td rowspan='".$rowspan."'><span id='subtotalAmount_".$sl."'></span></td>";
                }
                echo "</tr>";
                $rowCountPlus++;
            }
            ?>
        <script>
            $("#subtotalAmount_<?php echo $sl; ?>").html('<?php echo number_format(floatval($subtotalAmount),2) ?>');
        </script>
            <?php
            $sl++;
        }
        echo "<tr><td colspan='7' style='text-align: right; font-weight: bold;'>Total</td><td style='font-weight: bold; color: green;'>".number_format(floatval($totalAmount),2)."</td></tr>";
        
        $amountInWord = new AmountInWord();
        ?>
        <tr>
            <th colspan="2" style="text-align: right;">In Word:</th>
            <th colspan="6" style="text-align: right;"><?php echo $amountInWord->convert(intval($totalAmount)); ?></th>
        </tr>
        <?php
        echo "</table>";
        echo "</div>";
        echo "<input type='hidden' id='totalPayable' value='".$totalAmount."'/>";
        ?>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php echo CHtml::submitButton('Create Bill', array('class' => 'billCreateBtn')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    
    $(".billCreateBtn").click(function(e){
        if($("#totalPayable").val() <= 0){
            alertify.alert("Please check total payable amount !");
            e.preventDefault();
        }else{
            if($("#CustomerBill_bill_date").val()==""){
                alertify.alert("Bill date can not be empty.");
                $("#CustomerBill_bill_date").css("border-color", "#D50000");
                e.preventDefault();
            }else{
                $("#CustomerBill_bill_date").css("border-color", "#AAAAAA");
            }
            if($("#CustomerBill_due_date").val()==""){
                alertify.alert("Due date can not be empty.");
                $("#CustomerBill_due_date").css("border-color", "#D50000");
                e.preventDefault();
            }else{
                $("#CustomerBill_due_date").css("border-color", "#AAAAAA");
            }
            $("#ajaxLoaderMR").show();
        }
    });
</script>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Bill Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
