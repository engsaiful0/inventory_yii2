<table class="items">
    <thead>
        <tr>
            <td colspan="7" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
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

        $date1 = date_create($startDate);
        $date2 = date_create($endDate);
        $diff = date_diff($date1, $date2);
        $timeInverval = $diff->format("%a") + 1;
        for ($i = 0; $i < $timeInverval; $i++) {
            $date = date('Y-m-d', strtotime($startDate) + strtotime("+" . $i . " day", 0));

            $totalReceived = PurchaseRcvRtn::model()->totalReceivedAmountOfThisSupplierThisDate($id, $date);
            $totalPaid = 0;
            $totalDiscount = 0;
            $criteria = new CDbCriteria();
            $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
            $criteria->addColumnCondition(array("supplier_id" => $id, "date" => $date), "AND", "AND");
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
<style>
    table, table tr, table tr th, table tr td{
        border-collapse: collapse;
        border: 1px solid #000000;
        font-size: 8px;
        font-weight: normal;
    }
    table tr th, table tr td{
        padding: 4px;
    }
    table tr.even{
        background-color: #f9f9f9;
    }
</style>
