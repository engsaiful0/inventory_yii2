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
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/xls.png"), array('/reportXsl/customerLedgerAllExcel',
    'startDate' => $startDate,
    'endDate' => $endDate,), array('title' => 'Export as xls'));
?>
<?php
echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl . "/images/pdf.png"), array('/reportPdf/customerLedgerAllPdf',
    'startDate' => $startDate,
    'endDate' => $endDate,), array('title' => 'Save as PDF'));
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>E-mail</th>
                    <th>Fax</th>
                    <th>Sold Amount</th>
                    <th>Not Billed</th>
                    <th>Billed Amount</th>
                    <th>Received Amount</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Due (Billed Amount)</th>
                    <th>Credit Memo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($data){
                        $sl=1;
                        $totalSoldTotal=0;
                        $totalNotBilledTotal=0;
                        $totalBilledTotal=0;
                        $totalPaidTotal=0;
                        $totalDiscountTotal=0;
                        $totalMrTotal=0;
                        $totalDueTotal=0;
                        $totalCreditMemoTotal=0;
                        foreach($data as $d){
                            
                            $totalSold=SellDelvRtn::model()->totalDelvAmount($bill=null, $sl_no=null, $customer_id=$d->id, $date=null, $startDate=$startDate, $endDate=$endDate);
                            $totalBilled=SellDelvRtn::model()->totalDelvAmount($bill=1, $sl_no=null, $customer_id=$d->id, $date=null, $startDate=$startDate, $endDate=$endDate);
                            $totalNotBilled=($totalSold-$totalBilled);

                            $totalPaid = 0;
                            $totalDiscount = 0;
                            $criteria = new CDbCriteria();
                            $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
                            $criteria->addBetweenCondition("date", $startDate, $endDate);
                            $criteria->addColumnCondition(array("customer_id" => $d->id), "AND", "AND");
                            $data2 = CustomerMr::model()->findAll($criteria);
                            if ($data2) {
                                $totalPaid = end($data2)->sumOfPaidAmount;
                                $totalDiscount = end($data2)->sumOfDiscount;
                            }
                            $totalMr=($totalPaid+$totalDiscount);
                            $totalDue=($totalBilled-$totalMr);
                            
                            $totalCreditMemo=CreditMemo::model()->totalCreditMemoThisRangeThisCustomer($d->id, $startDate, $endDate);
                            
                            $totalSoldTotal=$totalSold+$totalSoldTotal;
                            $totalNotBilledTotal=$totalNotBilled+$totalNotBilledTotal;
                            $totalBilledTotal=$totalBilled+$totalBilledTotal;
                            $totalPaidTotal=$totalPaid+$totalPaidTotal;
                            $totalDiscountTotal=$totalDiscount+$totalDiscountTotal;
                            $totalMrTotal=$totalMr+$totalMrTotal;
                            $totalDueTotal=$totalDue+$totalDueTotal;
                            $totalCreditMemoTotal=$totalCreditMemo+$totalCreditMemoTotal;
                            
                            if($totalSold>0 || $totalBilled>0 || $totalMr>0 || $totalCreditMemo>0){
                            ?>
                <tr>
                    <td><?php echo $sl++; ?></td>
                    <td style="text-align: left;"><?php echo $d->id_no; ?></td>
                    <td style="text-align: left;"><?php echo $d->company_name; ?></td>
                    <td style="text-align: left;"><?php echo $d->company_address; ?></td>
                    <td><?php echo $d->company_contact_no; ?></td>
                    <td><?php echo $d->company_email; ?></td>
                    <td><?php echo $d->company_fax; ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalSold),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalNotBilled),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalBilled),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalPaid),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalDiscount),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalMr),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalDue),2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(floatval($totalCreditMemo),2); ?></td>
                </tr>
                            <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: right; padding-right: 6px; font-weight: bold;">Total</td>
                            <td style="background-color: #bb5cf6; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalSoldTotal), 2); ?></td>
                            <td style="background-color: #b8860b; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalNotBilledTotal), 2); ?></td>
                            <td style="background-color: #44c444; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalBilledTotal), 2); ?></td>
                            <td style="background-color: #4169e1; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalPaidTotal), 2); ?></td>
                            <td style="background-color: #d25757; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalDiscountTotal), 2); ?></td>
                            <td style="background-color: #b4b4b4; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalMrTotal), 2); ?></td>
                            <td style="background-color: #ff0000; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalDueTotal), 2); ?></td>
                            <td style="background-color: #ffff00; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalCreditMemoTotal), 2); ?></td>
                        </tr>
                        <?php
                    }else{
                        ?>
                        <tr>
                            <td colspan="15"><div class="flash-error">No result found!</div></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>