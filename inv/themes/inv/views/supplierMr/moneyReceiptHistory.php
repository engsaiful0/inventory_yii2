<fieldset>
    <legend><?php echo Suppliers::model()->supplierNameAddr($supplier_id); ?></legend>

    <table class="reportTab">
        <thead>
            <tr>
                <td style="width: 20px;">SL</td>
                <td>PR No</td>
                <td>PR Date</td>
                <td>Payment Type</td>
                <td>Bank Name</td>
                <td>Cheque No</td>
                <td>Cheque Date</td>
                <td style="text-align: right;">Receive Amount</td>
                <td style="text-align: right;">Discount</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($groupData) {
                $sl = 1;
                $totalPaidAmount = 0;
                $totalDiscount = 0;
                foreach ($groupData as $grpdta) {
                    $condition = 'sl_no="' . $grpdta->sl_no . '"';
                    $mainData = SupplierMr::model()->findAll(array('condition' => $condition,));
                    $rowSpan = count($mainData);
                    $rowCount = 1;
                    foreach ($mainData as $d) {
                        ?>
                        <tr>
                            <?php if ($rowCount == 1) { ?>
                                <td rowspan="<?php echo $rowSpan; ?>"><?php echo $sl++; ?></td>
                                <td rowspan="<?php echo $rowSpan; ?>"><?php echo $grpdta->sl_no; ?></td>
                                <td rowspan="<?php echo $rowSpan; ?>"><?php echo $grpdta->date; ?></td>
                            <?php } ?>
                            <td><?php echo Lookup::item("received_type", $d->received_type); ?></td>
                            <td><?php echo Banks::model()->nameOfThis($d->bank_id); ?></td>
                            <td><?php echo $d->cheque_no; ?></td>
                            <td><?php echo $d->cheque_date; ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($d->paid_amount), 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format(floatval($d->discount), 2); ?></td>
                        </tr>
                        <?php
                        $totalPaidAmount = $d->paid_amount + $totalPaidAmount;
                        $totalDiscount = $d->discount + $totalDiscount;
                        $rowCount++;
                    }
                }
                ?>
                <tr>
                    <td colspan="7" style="text-align: right; padding-right: 6px; font-weight: bold;">Total</td>
                    <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalPaidAmount), 2); ?></td>
                    <td style="text-align: right; font-weight: bold;"><?php echo number_format(floatval($totalDiscount), 2); ?></td>
                </tr>
                <?php
                $merge = $totalPaidAmount + $totalDiscount;
                $received = PurchaseRcvRtn::model()->totalRcvAmount($supplier_id=$supplier_id, $date=null, $startDate=null, $endDate=null);
                $due = ($received - $merge);
                ?>
                <tr>
                    <td colspan="7" style="text-align: right; padding-right: 6px; font-weight: bold;">Merge</td>
                    <td colspan="2" style="font-weight: bold; color: blue;"><?php echo number_format(floatval($merge), 2); ?></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right; padding-right: 6px; font-weight: bold;">Total Received Amount</td>
                    <td colspan="2" style="font-weight: bold; color: green;"><?php echo number_format(floatval($received), 2); ?></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right; padding-right: 6px; font-weight: bold;">Total Due</td>
                    <td colspan="2" style="font-weight: bold; color: red;"><?php echo number_format(floatval($due), 2); ?></td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="9"><div class="errorMessage">No result found !</div></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</fieldset>
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
