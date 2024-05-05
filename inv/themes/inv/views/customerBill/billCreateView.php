<div class="grid-view">
    <table class="items" id="challanListTab">
        <thead>
            <tr>
                <td>
                    <div class="ajaxLoaderFormLoadPurchReq" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                </td>
                <td colspan="8" style="padding: 10px;">
                    <?php
                    echo CHtml::link('Create bill for the selected challan numbers', "", // the link for open the dialog
                            array(
                        'class' => 'additionalBtn',
                        'onclick' => "{transferAll();}"));
                    ?>
                </td>
            </tr>
            <tr>
                <th style="width: 10px;">
                    <input id="selectall" type="checkbox"/>
                </th>
                <th>Challan Number</th>
                <th>Challan Date</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Converted Unit</th>
                <th>Rate</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data) {
                $totalAmount = 0;
                $sl = 1;
                foreach ($data as $d) {
                    $condition = "sl_no='" . $d->sl_no . "'";
                    $data2 = SellDelvRtn::model()->findAll(array("condition" => $condition));
                    $rowspan = count($data2);
                    $rowCount = 1;
                    $subtotalAmount = 0;
                    foreach ($data2 as $d2) {
                        $actualDeliveryQty = ($d2->d_qty - $d2->r_qty);
                        $soInfo = SaleOrder::model()->findByPk($d2->so_id);

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
                        ?>
                        <tr class="challanInfoRow_<?php echo $d->sl_no; ?>">
                            <?php if ($rowCount == 1) { ?>
                                <td rowspan="<?php echo $rowspan; ?>">
                                    <input 
                                        id="<?php echo $d->sl_no; ?>" 
                                        attrChallanNo="<?php echo $d->sl_no; ?>" 
                                        attrCustomerId="<?php echo $customer_id; ?>" 
                                        class="chckbxitms" type="checkbox"/>
                                </td>
                                <td rowspan="<?php echo $rowspan; ?>" style="padding: 0px; text-align: left;"><label style="float: left; width: 100%; text-align: center;" for="<?php echo $d->sl_no; ?>"><?php echo $d->sl_no; ?></label></td>
                                <td rowspan="<?php echo $rowspan; ?>"><?php echo $d->d_date; ?></td>
                            <?php } ?>
                            <td style="text-align: left;"><?php Items::model()->item($d2->item); ?></td>
                            <td style="text-align: right;"><?php echo $actualDeliveryQty; ?></td>
                            <td><?php echo $convertedText; ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($price), 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($amount), 2); ?></td>
                            <?php if ($rowCount == 1) { ?>
                                <td rowspan="<?php echo $rowspan; ?>" style="text-align: right;"><span id="amountSubTotal_<?php echo $sl; ?>"></span></td>
                        <?php } ?>
                        </tr>
                        <?php
                        $rowCount++;
                    }
                    ?>
                <script>
                    $("#amountSubTotal_<?php echo $sl; ?>").html('<?php echo number_format(floatval($subtotalAmount), 2); ?>');
                </script>
                <?php
                $sl++;
            }
            ?>
            <tr>
                <td colspan="8" style="text-align: right; font-weight: bold; padding-right: 6px;"></td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalAmount), 2); ?></td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="9">
                    <div class="flash-error">No pending challan found !</div>
                </td>
            </tr>
<?php } ?>
        </tbody>
    </table>
</div>
<div id="jsPart"></div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTransferSelected',
    'options' => array(
        'title' => 'Create Bill',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>
<style>
    label.labelForCheckBox{
        float: left; 
        width: 100%;
        color: #000000;
        height: 100%;
    }
    label.labelForCheckBox:hover{
        color: red;
    }
</style>
<script type="text/javascript">
    $('#selectall').click(function () {
        $('.chckbxitms').prop('checked', this.checked);
        $('.chckbxitms').each(function() { //loop through each checkbox
            if(this.checked){
                var thisId=$(this).attr("id");
                $("#labelForCheckBox_"+thisId).css("color","red");
            }else{
                var thisId=$(this).attr("id");
                $("#labelForCheckBox_"+thisId).css("color","#000000");
            }
        });
    });

    $('.chckbxitms').change(function () {
        if(this.checked){
            var thisId=$(this).attr("id");
            $("#labelForCheckBox_"+thisId).css("color","red");
        }else{
            var thisId=$(this).attr("id");
            $("#labelForCheckBox_"+thisId).css("color","#000000");
        }
        var check = ($('.chckbxitms').filter(":checked").length == $('.chckbxitms').length);
        $('#selectall').prop("checked", check);
    });
    function transferAll(){
        if(jQuery('input[type=checkbox]:checked').length==0){
            alertify.alert("Please select at least one challan number !");
        }else{
            var attrChallanNoArr = new Array();
            var attrCustomerIdArr = new Array();
                
            $('.chckbxitms').each(function() { //loop through each checkbox
                if(this.checked){
                    attrChallanNoArr.push($(this).attr("attrChallanNo"));
                    attrCustomerIdArr.push($(this).attr("attrCustomerId"));
                }
            });
                
            $('#dialogTransferSelected').dialog('destroy'); 
            $('#dialogTransferSelected').dialog({ autoOpen: false, resizable: false, title: 'Create Bill', width: 'auto', modal: true }); 
            $('#dialogTransferSelected').dialog('open');
<?php
echo CHtml::ajax(array(
    'url' => array('customerBill/create'),
    'data' => "js:{'attrChallanNoArr':''+attrChallanNoArr+'', 'attrCustomerIdArr':''+attrCustomerIdArr+''}",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $('#jsPart').html(data.jsPart);
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                }",
));
?>;
        }
                
        
        return false; 
    } 
    
    function transferAllAgain(){
        if(jQuery('input[type=checkbox]:checked').length==0){
            alertify.alert("Please select at least one challan number !");
        }else{
            var dataString = '';
                            
<?php
echo CHtml::ajax(array(
    'url' => array('customerBill/create'),
    'data' => "js:dataString+$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $('#jsPart').html(data.jsPart);
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                                                    }",
));
?>;
        } 
        return false; 
    } 
           
</script> 