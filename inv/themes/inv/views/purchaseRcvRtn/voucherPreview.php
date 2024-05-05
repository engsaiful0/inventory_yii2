<?php
echo "<div class='printBtn'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div'         //id of the print link
));
echo "</div>";
?>
<div class="printAllTableForThisReport">
    <table class="headerTab">
        <tr>
            <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 20px; font-size: 18px;">Receive Copy</th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">PURCHASE ORDER RECEIVE</th>
        </tr>
        <?php
        foreach ($dataPurchaseOrderInfo as $PurchaseOrderInfo) {
            $po_id = $PurchaseOrderInfo->id;
        }
        $condition = "po_id='" . $po_id . "'";
        $purChaseRcvInfo = PurchaseRcvRtn::model()->findAll(array('condition' => $condition,));
        foreach ($purChaseRcvInfo as $purChaseRcvInfoValue) {
            $challan_no = $purChaseRcvInfoValue->challan_no;
            $rcv_date = $purChaseRcvInfoValue->rcv_date;
        }
        ?>

        <tr>
            <td style="text-align: left; padding-bottom: 10px;"><b>Receive No: </b><?php echo $challan_no;  //echo $purChaseRcvInfo->challan_no;      ?></td>
            <td style="text-align: right; padding-bottom: 10px;"><b>Receive Issue Date: </b><?php echo $rcv_date; ?></td>
        </tr>

    </table> 
    <table class="reportTab">
        <tr>
            <th style="width: 32px;">SL</th>
            <th>PO No</th>
            <th>Supplier</th>
            <th>Local/Import</th>
            <th>Item</th>
            <th>Order Qty</th>
            <th>Unit</th>
            <th>Cost</th>  
            <th> Amount</th>
        </tr>
        <tr>
            <?php
            $totalOrderAmount = 0;
            $totalOrderQty = 0;
            $i = 1;
            foreach ($dataPurchaseOrderInfo as $dta) {
                $d = PurchaseProcurement::model()->findByPk($dta->procurement_id);
                ?>

                <td><?php echo $i++; ?></td>
                <td><?php echo $dta->id; ?></td>
                <td style="text-align: left;"><?php echo Suppliers::model()->supplierName($d->supplier_id); ?></td>
                <td style="text-align: left;"><?php echo Lookup::item('order_type', $d->order_type) . " (" . Lookup::item('order_sub_type', $d->order_sub_type) . ")"; ?></td>
                <td style="text-align: left;"><?php echo Items::model()->item($d->item); ?></td>
                <td><?php
                    echo $dta->order_qty;
                    $totalOrderQty+=$dta->order_qty;
                    ?></td>
                <td style="text-align: left;"><?php echo Units::model()->name_of_unitOfThis($dta->name_of_unit); ?></td>
                <td style="text-align: right;"><?php echo number_format(floatval($dta->cost), 2); ?></td>
                <?php
                $lineTotal = $dta->cost * $dta->order_qty;
                $totalOrderAmount = $totalOrderAmount + $lineTotal;
                ?>
                <td style="text-align: right;"><?php echo number_format(floatval($lineTotal), 2); ?></td>
            <?php } ?>

        </tr>
        <tr>
            <th colspan="6" style="text-align: right; padding-right: 6px;">Total</th>

            <th colspan="4" style="text-align: right;"><?php echo number_format(floatval($totalOrderAmount), 2); ?></th>
        </tr>
        <?php
        $amountInWord = new AmountInWord();
        ?>
        <tr>
            <th colspan="4" style="text-align: right;">In Word:</th>
            <th colspan="6" style="text-align: right;"><?php echo $amountInWord->convert(intval($totalOrderAmount)); ?></th>
        </tr>
    </table>
    <table class="reportTab" style="margin-top:20px;">
        <tr>
            <th style="width: 32px;">SL</th>
            <th>PO No</th>
            <th>Supplier</th>
            <th>Receive Date</th>
            <th>No of Received Sack</th>
            <th>Weight/Sack</th>
            <th>Receive Quantity</th>
            <th>Unit</th>
            <th>Remarks</th>     
            <th>Cost</th>  
            <th> Amount</th>
        </tr>
        <tr>
            <?php
            $totalRcvAmount = 0;
            $totalRcvQty = 0;
            $i = 1;
            foreach ($dataPurchaseOrderInfo as $dta) {
                $d = PurchaseProcurement::model()->findByPk($dta->procurement_id);
                $condition = "po_id='" . $dta->id . "'";
                $purChaseRcv = PurchaseRcvRtn::model()->findAll(array("condition" => $condition));
                foreach ($purChaseRcv as $purChaseRcvInfo) {
                    ?>
                <tr>

                    <td><?php echo $i++; ?></td>
                    <td><?php echo $dta->id; ?></td>
                    <td style="text-align: left;"><?php echo Suppliers::model()->supplierName($d->supplier_id); ?></td>
                    <td style="text-align: left;"><?php echo $purChaseRcvInfo->rcv_date; ?></td>
                    <td style="text-align: left;"><?php echo $purChaseRcvInfo->noOfReceivedSack; ?></td>
                    <td style="text-align: left;"><?php echo $purChaseRcvInfo->weightPerSack; ?></td>
                    <td style="text-align: left;"><?php
                        echo $purChaseRcvInfo->rcv_qty;
                        $totalRcvQty+=$purChaseRcvInfo->rcv_qty;
                        ?></td>

                    
                    <?php
                    $lineTotalRcv = $purChaseRcvInfo->cost * $purChaseRcvInfo->rcv_qty;
                    $totalRcvAmount = $totalRcvAmount + $lineTotalRcv;
                    ?>
                    <td style="text-align: right;"><?php echo Units::model()->name_of_unitOfThis($purChaseRcvInfo->name_of_unit); ?></td>
                    <td style="text-align: right;"><?php echo $purChaseRcvInfo->remarks_for_rcv; ?></td>
                    <td style="text-align: right;"><?php echo $purChaseRcvInfo->cost; ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($lineTotalRcv), 2); ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tr>
        <tr>
            <th colspan="8" style="text-align: right; padding-right: 6px;">Total</th>

            <th colspan="3" style="text-align: right;"><?php echo number_format(floatval($totalRcvAmount), 2); ?></th>
        </tr>
        <?php
        $amountInWord = new AmountInWord();
        ?>
        <tr>
            <th colspan="4" style="text-align: right;">In Word:</th>
            <th colspan="7" style="text-align: right;"><?php echo $amountInWord->convert(intval($totalRcvAmount)); ?></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: right;">Remaining Quantity:</th>
            <th colspan="2" style="text-align: right;"><?php echo $totalOrderQty - $totalRcvQty; ?></th>
            <th colspan="3" style="text-align: right;">Remaining Amount:</th>
            <th colspan="3" style="text-align: right;"><?php echo number_format(floatval($totalOrderAmount - $totalRcvAmount), 2) ?></th>

        </tr>
    </table>
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



</div>