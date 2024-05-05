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
            <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">BILL</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">Customer</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?php echo Customers::model()->customerNameAndAddress(end($mainData)->customer_id); ?></td>
            <td style="vertical-align: top;">
                Bill No<br/>Bill Date<br/>Due Date
            </td>
            <td style="vertical-align: top;">:<br/>:<br/>:</td>
            <td style="vertical-align: top;">
                <?php echo end($mainData)->sl_no; ?><br/>
                <?php echo end($mainData)->bill_date; ?><br/>
                <?php echo end($mainData)->due_date; ?>
            </td>
        </tr>
    </table>
    <table class="reportTab">
        <?php
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
        if ($mainData) {
            $challanNumbersArray = array();
            foreach ($mainData as $md) {
                $challanNumbersArray[] = $md->challan_no;
            }
            $sl = 1;
            $totalAmount = 0;
            $totalCount = count($challanNumbersArray);

            for ($i = 0; $i < $totalCount; $i++) {
                $data = SellDelvRtn::model()->findAll(array('condition' => 'sl_no="' . $challanNumbersArray[$i] . '"'));
                $rowspan = count($data);
                $subtotalAmount = 0;
                $rowCountPlus = 1;
                foreach ($data as $d) {
                    $actualDeliveryQty = ($d->d_qty - $d->r_qty);
                    $soInfo = SaleOrder::model()->findByPk($d->so_id);

                    $qty = $soInfo->qty;
                    $price = $soInfo->price;
                    $conv_unit = $soInfo->conv_unit;
                    $convertedText = "";
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
                                    $convertedText = $qty . " SFT";
                                } else if ($conv_unit == Items::RFT) {
                                    $qty = $rft;
                                    $convertedText = $qty . " RFT";
                                } else if ($conv_unit == Items::CFT) {
                                    $qty = $cft * $actualDeliveryQty;
                                    $convertedText = $qty . " CFT";
                                } else if ($conv_unit == Items::SQM) {
                                    $qty = $sqm;
                                    $convertedText = $qty . " SQM";
                                } else {
                                    $qty = $actualDeliveryQty;
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
                    if ($rowCountPlus == 1) {
                        echo "<td rowspan='" . $rowspan . "'>" . $sl . "</td>";
                        echo "<td rowspan='" . $rowspan . "'>" . $challanNumbersArray[$i] . "</td>";
                    }
                    ?>
                    <td style='text-align: left;'><?php Items::model()->item($d->item); ?></td>
                    <?php
                    echo "<td>" . $actualDeliveryQty . "</td>";
                    echo "<td>".$convertedText."</td>";
                    echo "<td>" . number_format(floatval($price), 2) . "</td>";
                    echo "<td>" . number_format(floatval($amount), 2) . "</td>";
                    if ($rowCountPlus == 1) {
                        echo "<td rowspan='" . $rowspan . "'><span id='subtotalAmount_" . $sl . "'></span></td>";
                    }
                    echo "</tr>";
                    $rowCountPlus++;
                }
                ?>
                <script>
                    $("#subtotalAmount_<?php echo $sl; ?>").html('<?php echo number_format(floatval($subtotalAmount), 2) ?>');
                </script>
                <?php
                $sl++;
            }
            echo "<tr><td colspan='7' style='text-align: right; font-weight: bold;'>Total</td><td style='font-weight: bold; color: green;'>" . number_format(floatval($totalAmount), 2) . "</td></tr>";
            $totalSold = SellDelvRtn::model()->totalDelvAmount($bill = null, $sl_no = null, $customer_id = end($mainData)->customer_id, $date = null, $startDate = null, $endDate = null);
            $totalMr = CustomerMr::model()->totalPaidAmountOfThisCustomer(end($mainData)->customer_id);
            ?>
            <?php
            $amountInWord = new AmountInWord();
            ?>
            <tr>
                <th colspan="2" style="text-align: right;">In Word:</th>
                <th colspan="6" style="text-align: right;"><?php echo $amountInWord->convert(intval($totalAmount)); ?></th>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="8"><div class="errorMessage">No result found !</div></td>
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
            <th style="text-decoration: overline;text-align: center;">Bill Supervisor</th>
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
