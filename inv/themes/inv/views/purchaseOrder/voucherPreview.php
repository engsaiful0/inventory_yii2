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
<div class='printAllTableForThisReport'>
    <table class="headerTab">
        <tr>
            <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">PURCHASE ORDER</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-bottom: 10px;"><b>Order No: </b><?php echo end($data)->sl_no; ?></td>
            <td style="text-align: right; padding-bottom: 10px;"><b>Order Issue Date: </b><?php echo end($data)->issue_date; ?></td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left; padding-bottom: 10px;">Following items are required</th>
        </tr>
    </table>
    <table class="reportTab">
        <tr>
            <th style="width: 32px;">SL</th>
            <th>Procurement No</th>
            <th>Supplier</th>
            <th>Local/Import</th>
            <th>Item</th>
            <th>Department</th>
            <th>Present Stock</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Cost/Unit</th>
            <th>Approx Amount</th>
            <th>Remarks</th>
            <th>Order Qty</th>
            <th>Unit</th>
            <th>Cost/Unit In </br>Purchase Order</th>
            <th>Approx Amount</th>
        </tr>
        <?php
        $i = 1;
        $total = 0;
        $total2 = 0;
        ?>
        <?php foreach ($data as $dta) { ?>
            <?php $d = PurchaseProcurement::model()->findByPk($dta->procurement_id); ?>
            <?php if ($d) { ?>
                <tr class="<?php
                if ($i % 2 == 0)
                    echo 'odd';
                else
                    echo 'even';
                ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $d->sl_no; ?></td>
                    <td style="text-align: left;"><?php echo Suppliers::model()->supplierName($d->supplier_id); ?></td>
                    <td style="text-align: left;"><?php echo Lookup::item('order_type', $d->order_type) . " (" . Lookup::item('order_sub_type', $d->order_sub_type) . ")"; ?></td>
                    <td style="text-align: left;"><?php Items::model()->item($d->item); ?></td>
                    <td><?php echo $d->department; ?></td>
                    <td><?php echo number_format(floatval(Inventory::model()->presentStockOfThisItem($d->item, $d->store)), 2); ?></td>
                    <td><?php echo $d->qty; ?></td>
                    <td><?php echo Units::model()->name_of_unitOfThis($d->name_of_unit); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($d->cost), 2); ?></td>
                    <?php
                    $lineTotal = $d->cost * $d->qty;
                    $total = $total + $lineTotal;
                    ?>
                    <td style="text-align: right;"><?php echo number_format(floatval($lineTotal), 2); ?></td>
                    <td style="text-align: right;"><?php echo $d->remarks; ?></td>
                    <td><?php echo $dta->order_qty; ?></td>
                    <td><?php echo Units::model()->name_of_unitOfThis($dta->name_of_unit); ?></td>
                    <td><?php echo $dta->cost; ?></td>
                    <?php
                    $lineTotal2 = $dta->cost * $dta->order_qty;
                    $total2 = $total2 + $lineTotal2;
                    ?>
                    <td style="text-align: right;"><?php echo number_format(floatval($lineTotal2), 2); ?></td>
                </tr>
    <?php } ?>
<?php } ?>
        <tr>
            <th colspan="10" style="text-align: right; padding-right: 6px;">Total</th>
            <th style="text-align: right;"><?php echo number_format(floatval($total), 2); ?></th>
            <th></th>
            <th></th><th></th><th></th>
            <th style="text-align: right;"><?php echo number_format(floatval($total2), 2); ?></th>
        </tr>
<?php
$amountInWord = new AmountInWord();
?>
        <tr>
            <th colspan="5" style="text-align: right;">In Word:</th>
            <th colspan="13" style="text-align: right;"><?php echo $amountInWord->convert(intval($total2)); ?></th>
        </tr>
    </table>
    <table class="headerTab">
        <tr>
            <th style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Purchase Order By</th>
            <th></th>
            <th style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Approved by</th>
        </tr>
        <?php
        $purchaseOrderByInfo = Employees::model()->findByPk(end($data)->purchase_order_by);
        if ($purchaseOrderByInfo) {
            $purchaseOrderByName = $purchaseOrderByInfo->full_name;
            $purchaseOrderBydesignation = Designations::model()->infoOfThis($purchaseOrderByInfo->designation_id);
            $purchaseOrderBydepartment = Departments::model()->nameOfThis($purchaseOrderByInfo->department_id);
        } else {
            $purchaseOrderByName = "<font color='red'>Employee removed !</font>";
            $purchaseOrderBydesignation = "";
            $purchaseOrderBydepartment = "";
        }
        // print_r(end($data)->submitted_to);
        // exit;
        $approvedByInfo = Employees::model()->findByPk(end($data)->approved_by);
        if ($approvedByInfo) {

            $approveByName = $approvedByInfo->full_name;
            $approveBydesignation = Designations::model()->infoOfThis($approvedByInfo->designation_id);
            $approveBydepartment = Departments::model()->nameOfThis($approvedByInfo->department_id);
        } else {
            $approveByName = "<font color='red'>Employee removed !</font>";
            $approveBydesignation = "";
            $approveBydepartment = "";
        }
        ?>
        <tr>
            <td>Signature:</td>
            <td></td>
            <td>Signature:  </td>
        </tr>
        <tr>
            <td>Purchase Order By:<?php
        echo $purchaseOrderByName;
////            //Users::model()->fullNameOfThis(end($data)->created_by); 
        ?></td>
            <td></td>
            <td>Approved By: <?php echo $approveByName; ?> </td>
        </tr>
        <tr>
            <td>Department:<?php echo $purchaseOrderBydepartment; ?></td>
            <td></td>
            <td>Department:<?php echo $approveBydepartment; ?></td>
        </tr>
        <tr>
            <td>Designation:<?php echo $purchaseOrderBydesignation; ?></td>
            <td></td>
            <td>Designation:<?php echo $approveBydesignation; ?></td>
        </tr>
        <tr>
            <td>Grow Biz Industries Ltd</td>
            <td></td>
            <td>Grow Biz Industries Ltd</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: center; text-decoration: underline; padding: 20px 0px;">To be filled by Purchase Department</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left; text-decoration: underline; padding-bottom: 20px;">Remarks:</th>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <th style="text-align: left; text-decoration: underline; padding-top: 60px;">Date</th>
            <th style="text-align: center; text-decoration: underline; padding-top: 60px;">Concerned Officer</th>
            <th style="text-align: right; text-decoration: underline; padding-top: 60px;">Authorized Signature</th>
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