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
            <th colspan="6" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">Money Receipt</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">Customer</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?php echo Customers::model()->customerNameAndAddress(end($mainData)->customer_id); ?></td>
            <td style="vertical-align: top;">
                MR No<br/>MR Date
            </td>
            <td style="vertical-align: top;">:<br/>:</td>
            <td style="vertical-align: top;">
                <?php echo end($mainData)->sl_no; ?><br/>
                <?php echo end($mainData)->date; ?>
            </td>
        </tr>
    </table>
    <table class="reportTab">
        <tr>
            <td style="width: 20px;">SL</td>
            <td>Bill No</td>
            <td style="text-align: right;">Billed Amount</td>
            <td style="text-align: right;">Previous Received Amount</td>
            <td style="text-align: right;">Due Amount</td>
            <td>Receive Type</td>
            <td>Bank Name</td>
            <td>Cheque No</td>
            <td>Cheque Date</td>
            <td style="text-align: right;">Current Receive Amount</td>
            <td style="text-align: right;">Discount</td>
        </tr>
        <?php
        if ($mainData) {
            $sl = 1;
            $totalSoldAmount = 0;
            $totalPrevRcvAmount = 0;
            $totalReceivableAmount = 0;
            $totalPaidAmount = 0;
            $totalDiscount = 0;
            foreach ($mainData as $d) {
                $mrAmount = CustomerMr::model()->totalMrAmountOfThisBill($d->bill_no);
                $criteria = new CDbCriteria();
                $criteria->select = "sl_no, challan_no";
                $criteria->addColumnCondition(array("sl_no" => $d->bill_no), "AND", "AND");
                $billInfo = CustomerBill::model()->findAll($criteria);
                $soldAmount = 0;
                if ($billInfo) {
                    foreach ($billInfo as $bi) {
                        $soldAmount = SellDelvRtn::model()->totalDelvAmount($bill=null, $sl_no=$bi->challan_no, $customer_id=null, $date=null, $startDate=null, $endDate=null) + $soldAmount;
                    }
                }
                $currentPaidAmount = $d->paid_amount + $d->discount;
                $prevMrAmount = $mrAmount - $currentPaidAmount;
                $receivableAmount = $soldAmount - $mrAmount;
                ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo $d->bill_no; ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($soldAmount), 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($prevMrAmount), 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($receivableAmount), 2); ?></td>
                    <td><?php echo Lookup::item("received_type", $d->received_type); ?></td>
                    <td><?php echo $d->bank_name; ?></td>
                    <td><?php echo $d->cheque_no; ?></td>
                    <td><?php echo $d->cheque_date; ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($d->paid_amount), 2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($d->discount), 2); ?></td>
                </tr>
                <?php
                $totalSoldAmount = $soldAmount + $totalSoldAmount;
                $totalPrevRcvAmount = $prevMrAmount + $totalPrevRcvAmount;
                $totalReceivableAmount = $receivableAmount + $totalReceivableAmount;
                $totalPaidAmount = $d->paid_amount + $totalPaidAmount;
                $totalDiscount = $d->discount + $totalDiscount;
            }
            ?>
            <tr>
                <td colspan="2" style="text-align: right; padding-right: 6px; font-weight: bold;">Total</td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalSoldAmount), 2); ?></td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalPrevRcvAmount), 2); ?></td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalReceivableAmount), 2); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalPaidAmount), 2); ?></td>
                <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalDiscount), 2); ?></td>
            </tr>
            <?php
            $amountInWord = new AmountInWord();
            ?>
            <tr>
                <th colspan="2" style="text-align: right;">In Word:</th>
                <th colspan="9" style="text-align: right;"><?php echo $amountInWord->convert(intval($totalPaidAmount)); ?></th>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="11"><div class="errorMessage">No result found !</div></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <table class="headerTab">
        <tr>
            <td style="padding-top: 40px; text-align: left;"></td>
            <td style="padding-top: 40px; text-align: right;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
        </tr>
        <tr>
            <th style="text-decoration: overline; text-align: left;">Received By</th>
            <th style="text-decoration: overline;text-align: center;">MR Supervisor</th>
            <th style="text-decoration: overline; text-align: right;">Authorized Signature</th>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 20px; text-align: right; font-style: italic;">
                Prepared By: <?php echo Users::model()->fullNameOfThis(end($mainData)->created_by); ?>
            </td>
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
