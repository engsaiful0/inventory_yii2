<?php
echo "<div class='printBtn' style='width: unset;'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
        '.summary',
        '.search-form',
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div'         //id of the print link
));
echo "</div>";
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/supplierLedgerSpecificExcel',
    'startDate' => $startDate,
    'endDate' => $endDate, 'id' => $id,), array('title' => 'Export as xls'));
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/supplierLedgerSpecificPdf',
    'startDate' => $startDate,
    'endDate' => $endDate, 'id' => $id,), array('title' => 'Save as PDF'));
?>
<div class='printAllTableForThisReport'>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" type="text/css" />
    <div class="grid-view">
        <table class="headerTab">
            <tr>
                <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px;"><?php echo $message; ?></th>
            </tr>
        </table>
        <table class="items">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Received Amount</th>
                    <th>Paid Amount</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                $totalReceivedTotal = 0;
                $totalPaidTotal = 0;
                $totalDiscountTotal = 0;
                $totalMrTotal = 0;
                $totalDueTotal = 0;

                $date1 = new DateTime($startDate);
                $date2 = new DateTime($endDate);
                $diff = date_diff($date1, $date2);
                $timeInverval = $diff->format("%a") + 1;
                
                $date=$date1->format('Y-m-d');
                
                for ($i = 0; $i < $timeInverval; $i++) {
                    $totalReceived = PurchaseRcvRtn::model()->totalRcvAmount($supplier_id=$id, $date=$date, $startDate=null, $endDate=null);
                    $totalPaid = 0;
                    $totalDiscount = 0;
                    $criteria = new CDbCriteria();
                    $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
                    $criteria->addColumnCondition(array("supplier_id" => $id, "date"=>$date), "AND", "AND");
                    $data2 = SupplierMr::model()->findAll($criteria);
                    if ($data2) {
                        $totalPaid = end($data2)->sumOfPaidAmount;
                        $totalDiscount = end($data2)->sumOfDiscount;
                    }
                    $totalMr = ($totalPaid + $totalDiscount);
                    $totalDue = ($totalReceived - $totalMr);

                    $totalReceivedTotal = $totalReceived + $totalReceivedTotal;
                    $totalPaidTotal = $totalPaid + $totalPaidTotal;
                    $totalDiscountTotal = $totalDiscount + $totalDiscountTotal;
                    $totalMrTotal = $totalMr + $totalMrTotal;
                    $totalDueTotal = $totalDue + $totalDueTotal;
                    
                    if ($totalReceived > 0 || $totalMr > 0) {
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo $date; ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($totalReceived), 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($totalPaid), 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($totalDiscount), 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($totalMr), 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(floatval($totalDue), 2); ?></td>
                    </tr>
                    <?php
                    }
                    $date1->modify('+1 day');
                    $date = $date1->format('Y-m-d');
                }
                ?>
                <tr>
                    <td colspan="2" style="text-align: right; padding-right: 6px; font-weight: bold;">Total</td>
                    <td style="background-color: #bb5cf6; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalReceivedTotal), 2); ?></td>
                    <td style="background-color: #b8860b; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalPaidTotal), 2); ?></td>
                    <td style="background-color: #44c444; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalDiscountTotal), 2); ?></td>
                    <td style="background-color: #4169e1; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalMrTotal), 2); ?></td>
                    <td style="background-color: #d25757; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalDueTotal), 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>