<div id="liabilitiesSec" class="sec">
    <div class="title">LIABILITIES</div>
    <div class="remove"><input title="remove" type="button" class="rdelete" onclick="$('#liabilitiesSec').hide();"/></div>
    <table class="dashBoardTab">
        <?php
        $totalReceivedAmount = 0;
        $criteria = new CDbCriteria();
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition("rcv_date", $startDate, $endDate);
        $data = PurchaseRcvRtn::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $poInfo = PurchaseOrder::model()->findByPk($d->po_id);
                if ($poInfo) {
                    $ppInfo = PurchaseProcurement::model()->findByPk($poInfo->procurement_id);
                    if ($ppInfo) {
                        $price = $ppInfo->cost;
                        $actualReceivedQty = ($d->rcv_qty - $d->rtn_qty);
                        $amount = $actualReceivedQty * $price;
                        $totalReceivedAmount = $amount + $totalReceivedAmount;
                    }
                }
            endforeach;
        }

        $totalPaid = 0;
        $totalDiscount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition("date", $startDate, $endDate);
        $data = SupplierMr::model()->findAll($criteria);
        if ($data) {
            $totalPaid = end($data)->sumOfPaidAmount;
            $totalDiscount = end($data)->sumOfDiscount;
        }
        $totalPr = ($totalPaid + $totalDiscount);
        $totalDue = ($totalReceivedAmount - $totalPr);
        ?>
        <tr>
            <th colspan="7" class="titleTh">Purchase</th>
        </tr>
        <tr>
            <th rowspan="2">Total Purchased[Received] Amount</th>
            <th rowspan="2">-</th>
            <th rowspan="2">-</th>
            <th colspan="3">Total Paid Amount</th>
            <th rowspan="2">Total Payable Amount</th>
        </tr>
        <tr>
            <th>Paid</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>
        <tr>
            <td><?php echo number_format(floatval($totalReceivedAmount)); ?></td>
            <td>-</td>
            <td>-</td>
            <td><?php echo number_format(floatval($totalPaid)); ?></td>
            <td><?php echo number_format(floatval($totalDiscount)); ?></td>
            <td><?php echo number_format(floatval($totalPr)); ?></td>
            <td><?php echo number_format(floatval($totalDue)); ?></td>
        </tr>
        <?php
        $totalBilledAmount = 0;
        $totalNotBilledAmount = 0;
        $criteria = new CDbCriteria();
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition("d_date", $startDate, $endDate);
        $data = SellDelvRtn::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $soInfo = SaleOrder::model()->findByPk($d->so_id);
                $actualDeliveryQty = ($d->d_qty - $d->r_qty);
                $qty = $soInfo->qty;
                $price = $soInfo->price;
                $conv_unit = $soInfo->conv_unit;
                
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
                        } else if ($conv_unit == Items::RFT) {
                            $qty = $rft;
                        } else if ($conv_unit == Items::CFT) {
                            $qty = $cft * $actualDeliveryQty;
                        } else if ($conv_unit == Items::SQM) {
                            $qty = $sqm;
                        } else {
                            $qty = $qty;
                        }
                    }
                    
                    $amount = $qty * $price;
                    
                    if ($d->bill == 1) {
                        $totalBilledAmount = $amount + $totalBilledAmount;
                    } else {
                        $totalNotBilledAmount = $amount + $totalNotBilledAmount;
                    }
                } else {
                    $amount = $actualDeliveryQty * $price;
                    
                    if ($d->bill == 1) {
                        $totalBilledAmount = $amount + $totalBilledAmount;
                    } else {
                        $totalNotBilledAmount = $amount + $totalNotBilledAmount;
                    }
                    
                }
            endforeach;
        }
        $totalSoldAmount = ($totalBilledAmount + $totalNotBilledAmount);
        $totalPaid = 0;
        $totalDiscount = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "sum(paid_amount) as sumOfPaidAmount, sum(discount) as sumOfDiscount";
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition("date", $startDate, $endDate);
        $data = CustomerMr::model()->findAll($criteria);
        if ($data) {
            $totalPaid = end($data)->sumOfPaidAmount;
            $totalDiscount = end($data)->sumOfDiscount;
        }
        $totalMr = ($totalPaid + $totalDiscount);
        $totalDue = ($totalBilledAmount - $totalMr);
        ?>
        <tr>
            <th colspan="7" class="titleTh">Sales</th>
        </tr>
        <tr>
            <th rowspan="2">Total Sold[Delivered] Amount</th>
            <th rowspan="2">Total Billed Amount</th>
            <th rowspan="2">Total Not-Billed Amount</th>
            <th colspan="3">Total Received Amount</th>
            <th rowspan="2">Total Receivable Amount [Billed But Not Received]</th>
        </tr>
        <tr>
            <th>Received</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>
        <tr>
            <td><?php echo number_format(floatval($totalSoldAmount)); ?></td>
            <td><?php echo number_format(floatval($totalBilledAmount)); ?></td>
            <td><?php echo number_format(floatval($totalNotBilledAmount)); ?></td>
            <td><?php echo number_format(floatval($totalPaid)); ?></td>
            <td><?php echo number_format(floatval($totalDiscount)); ?></td>
            <td><?php echo number_format(floatval($totalMr)); ?></td>
            <td><?php echo number_format(floatval($totalDue)); ?></td>
        </tr>
    </table>
</div>