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
if ($data) {
    $condition = "sl_no='" . end($data)->so_no . "'";
    $sellOrderInfo = SaleOrder::model()->findAll(array('condition' => $condition,));
    ?>
    <div class='printAllTableForThisReport'>
        <table class="headerTab">
            <tr>
                <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 20px; font-size: 18px;">DELIVERY CHALLAN</th>
            </tr>
            <tr>
                <td style="vertical-align: top;">Customer</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;"><?php echo Customers::model()->customerNameAndAddress(end($data)->customer_id); ?></td>
                <td style="vertical-align: top;">Challan No<br/>Challan Date<br/>Vehicle Type<br/>Vehicle No</td>
                <td style="vertical-align: top;">:<br/>:<br/>:<br/>:</td>
                <td style="vertical-align: top;">
                    <?php echo end($data)->sl_no; ?><br/>
                    <?php echo end($data)->d_date; ?><br/>
                    <?php echo end($data)->vehicle_type; ?><br/>
                    <?php echo end($data)->vehicle_no; ?>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Contact Person</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top;"><?php echo CustomerContactPersons::model()->allInfoOfThis(end($sellOrderInfo)->contact_person); ?></td>
                <td style="vertical-align: top;">SO No<br/>Issue Date<br/>Expected D.Date</td>
                <td style="vertical-align: top;">:<br/>:<br/>:</td>
                <td style="vertical-align: top;">
                    <?php echo end($sellOrderInfo)->sl_no; ?><br/>
                    <?php echo end($sellOrderInfo)->issue_date; ?><br/>
                    <?php echo end($sellOrderInfo)->expected_d_date; ?>
                </td>
            </tr>
            <tr>
                <td>Local/Export</td>
                <td>:</td>
                <td><?php echo Lookup::item('order_type2', end($sellOrderInfo)->order_type2); ?></td>
                <td>PI/PO No</td>
                <td>:</td>
                <td><?php echo end($sellOrderInfo)->pi_no; ?></td>
            </tr>
            <tr>
                <td>Store</td>
                <td>:</td>
                <td><?php echo Stores::model()->storeName(end($sellOrderInfo)->store); ?></td>
                <td>PI/PO Date</td>
                <td>:</td>
                <td><?php echo end($sellOrderInfo)->pi_date; ?></td>
            </tr>
            <tr>
                <td style="padding-bottom: 20px;">Remarks</td>
                <td style="padding-bottom: 20px;">:</td>
                <td colspan="4" style="padding-bottom: 20px;"><?php echo end($data)->remarks1; ?></td>
            </tr>
        </table>
        <table class="reportTab">
            <tr>
                <th style="width: 32px;">SL</th>
                <th>Item</th>
                <th>Order Qty</th>
                <th>Converted Unit</th>
                <th>Delivery Qty</th>
                <th>Delivery Qty(KG)</th>
            </tr>
            <?php
            $i = 1;
            ?>
            <?php foreach ($data as $d) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <?php
                    $reqData = SaleOrder::model()->findByPk($d->so_id);
                    $qty = $reqData->qty;
                    $conv_unit = $reqData->conv_unit;

                    $itemInfo = Items::model()->findByPk($reqData->item);
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
                            $qty = $cft * $qty;
                            $convertedText = $qty . " CFT";
                        } else if ($conv_unit == Items::SQM) {
                            $qty = $sqm;
                            $convertedText = $qty . " SQM";
                        } else {
                            $convertedText = "";
                        }
                    }
                    ?>
                    <td style="text-align: left;"><?php Items::model()->item($reqData->item); ?></td>
                    <td><?php echo $reqData->qty; ?></td>
                    <td><?php echo $convertedText; ?></td>
                    <td><?php echo $d->d_qty; ?></td>
                    <td><?php echo $d->d_qty_kg; ?></td>
                </tr>
            <?php } ?>
        </table>
        <table class="headerTab">
            <tr>
                <td style="padding-top: 40px; text-align: left;"><?php Employees::model()->fullNameWithDesigDepart(end($sellOrderInfo)->sales_by); ?></td>
                <td style="padding-top: 40px; text-align: right;"></td>
                <td style="padding-top: 40px; text-align: right;"></td>
                <td style="padding-top: 40px; text-align: right;"></td>
                <td style="padding-top: 40px; text-align: center;"></td>
            </tr>
            <tr>
                <th style="text-decoration: overline; text-align: left;">Sales Person</th>
                <th style="text-decoration: overline;text-align: center;">Received By</th>
                <th style="text-decoration: overline;text-align: center;">Checked By</th>
                <th style="text-decoration: overline;text-align: center;">Passed By</th>
                <th style="text-decoration: overline; text-align: right;">Authorized Signature</th>
            </tr>
            <tr>
                <td colspan="5" style="padding-top: 20px; text-align: right; font-style: italic;">
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
                padding: 2px;
                color: #000000;
            }
            table.reportTab tr th{
                background-color: #f4f4f4;
            }
        </style>
    </div>
<?php } else { ?>
    <div class="flash-error">No result found !</div>
<?php } ?>

