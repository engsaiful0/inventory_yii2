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
            <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">SALE ORDER</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">Customer</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?php echo Customers::model()->customerNameAndAddress(end($data)->customer_id); ?></td>
            <td style="vertical-align: top;" rowspan="2">
                SO No<br/>Issue Date<br/>Expected D.Date<br/>Local/Export<br/>PI/PO No<br/>PI/PO Date
            </td>
            <td style="vertical-align: top;" rowspan="2">:<br/>:<br/>:<br/>:<br/>:<br/>:</td>
            <td style="vertical-align: top;" rowspan="2">
                <?php echo end($data)->sl_no; ?><br/>
                <?php echo end($data)->issue_date; ?><br/>
                <?php echo end($data)->expected_d_date; ?><br/>
                <?php echo Lookup::item('order_type2', end($data)->order_type2); ?><br/>
                <?php echo end($data)->pi_no; ?><br/>
                <?php echo end($data)->pi_date; ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Contact Person</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?php echo CustomerContactPersons::model()->allInfoOfThis(end($data)->contact_person); ?></td>
        </tr>
        <tr>
            <td>Store</td>
            <td>:</td>
            <td colspan="4"><?php echo Stores::model()->storeName(end($data)->store); ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 20px;">Remarks</td>
            <td style="padding-bottom: 20px;">:</td>
            <td colspan="4" style="padding-bottom: 20px;"><?php echo end($data)->subj; ?></td>
        </tr>
    </table>
    <table class="reportTab">
        <tr>
            <th style="width: 32px;">Sl</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Converted Unit</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        <?php
        $i = 1;
        $amountTotal=0;
        ?>
        <?php foreach ($data as $d) { ?>
            <?php
            $amount = 0;
            $qty=$d->qty;
            $price = $d->price;
            $conv_unit = $d->conv_unit;

            $itemInfo = Items::model()->findByPk($d->item);
            if ($itemInfo) {
                $desc = $itemInfo->desc;
                $unitConvertable = $itemInfo->unit_convertable;

                $convertedUnit=Items::model()->convertedUnit($unitConvertable, $desc);
                $sft=$convertedUnit[0];
                $rft=$convertedUnit[1];
                $cft=$convertedUnit[2];
                $sqm=$convertedUnit[3];
                
                if ($conv_unit == Items::SFT) {
                    $qty = $sft;
                    $convertedText = $qty." SFT";
                } else if ($conv_unit == Items::RFT) {
                    $qty = $rft;
                    $convertedText = $qty." RFT";
                } else if ($conv_unit == Items::CFT) {
                    $qty = $cft*$qty;
                    $convertedText = $qty." CFT";
                } else if ($conv_unit == Items::SQM) {
                    $qty = $sqm;
                    $convertedText = $qty." SQM";
                }  else {
                    $convertedText = "";
                }
            }
            $amount = $qty * $price;
            $amountTotal=$amount+$amountTotal;
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td style="text-align: left;"><?php Items::model()->item($d->item); ?></td>
                <td><?php echo $d->qty; ?></td>
                <td><?php echo $convertedText; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo number_format(floatval($amount), 2); ?></td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="5" style="font-weight: bold; text-align: right; padding-right: 6px;">Total</td>
                <td><?php echo number_format(floatval($amountTotal), 2); ?></td>
            </tr>
            <?php
            $amountInWord = new AmountInWord();
            ?>
            <tr>
                <th colspan="2" style="text-align: right;">In Word:</th>
                <th colspan="4" style="text-align: right;"><?php echo $amountInWord->convert(intval($amountTotal)); ?></th>
            </tr>
    </table>
    <table class="headerTab">
        <tr>
            <td style="padding-top: 40px; text-align: left;"><?php Employees::model()->fullNameWithDesigDepart(end($data)->sales_by); ?></td>
            <td style="padding-top: 40px; text-align: right;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
        </tr>
        <tr>
            <th style="text-decoration: overline; text-align: left;">Sales Person</th>
            <th style="text-decoration: overline;text-align: center;">Sales Supervisor</th>
            <th style="text-decoration: overline; text-align: right;">Authorized Signature</th>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 20px; text-align: right; font-style: italic;">
                Prepared By: <?php echo Users::model()->fullNameOfThis(end($data)->created_by); ?>
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
