<div id="purchaseSec" class="sec">
    <div class="title">PURCHASE</div>
    <div class="remove"><input title="remove" type="button" class="rdelete" onclick="$('#purchaseSec').hide();"/></div>
    <table class="dashBoardTab">
        <tr>
            <th>Requisition Qty</th>
            <th>Procurement Qty</th>
            <th>Order Qty</th>
            <th>Receive Qty</th>
        </tr>
        <?php
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(qty) as sumQty, item';
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition('date', $startDate, $endDate, 'AND');

        $criteria->group = "item";
        $data = PurchaseRequisition::model()->findAll($criteria);
        if ($data) {
            $itemArr = array();
            $sumQtyArr = array();
            $sumProcQtyArr = array();
            $sumOrderQtyArr = array();
            $sumRcvQtyArr = array();

            $arrPos = 0;

            $sumQtyTotal = 0;
            $procQtyTotal = 0;
            $orderQtyTotal = 0;
            $rcvQtyTotal = 0;

            foreach ($data as $d):

                $sumQty = $d->sumQty;
                $itemId = $d->item;

                $sumQtyTotal = $sumQty + $sumQtyTotal;

                $criteria = new CDbCriteria();
                $criteria->addBetweenCondition("date", $startDate, $endDate);
                $criteria->addColumnCondition(array("item" => $itemId), "AND", "AND");
                $procdata = PurchaseProcurement::model()->findAll($criteria);

                $procQty = 0;
                $orderQty = 0;
                $rcvQty = 0;

                if ($procdata) {
                    foreach ($procdata as $prcd) {
                        $procQty = $prcd->qty + $procQty;
                        $poData = PurchaseOrder::model()->findAll(array("condition" => "procurement_id=" . $prcd->id));
                        if ($poData) {
                            foreach ($poData as $pod) {
                                $orderQty = $pod->order_qty + $orderQty;
                                $rcvQty = PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($pod->id) + $rcvQty;
                            }
                        }
                    }
                }

                $procQtyTotal = $procQty + $procQtyTotal;
                $orderQtyTotal = $orderQty + $orderQtyTotal;
                $rcvQtyTotal = $rcvQty + $rcvQtyTotal;

                $itemArr[$arrPos] = $itemId;
                $sumQtyArr[$arrPos] = $sumQty;
                $sumProcQtyArr[$arrPos] = $procQty;
                $sumOrderQtyArr[$arrPos] = $orderQty;
                $sumRcvQtyArr[$arrPos] = $rcvQty;
                $arrPos++;
            endforeach;
            $categories = Cats::model()->findAll();
            if ($categories) {
                foreach ($categories as $category) {
                    $criteriaItms = new CDbCriteria();
                    $criteriaItms->addColumnCondition(array("cat" => $category->id), "AND", "AND");
                    $criteriaItms->addInCondition("id", $itemArr);
                    $items = Items::model()->findAll($criteriaItms);
                    if ($items) {
                        $sumQtySubTotal = 0;
                        $sumProcQtySubTotal = 0;
                        $sumOrderQtySubTotal = 0;
                        $sumRcvQtySubTotal = 0;
                        $sl = 1;
                        foreach ($items as $item) {
                            if (in_array($item->id, $itemArr)) {
                                $indexOfArr = array_search($item->id, $itemArr);
                            }
                            $sumQtySubTotal = $sumQtySubTotal + $sumQtyArr[$indexOfArr];
                            $sumProcQtySubTotal = $sumProcQtySubTotal + $sumProcQtyArr[$indexOfArr];
                            $sumOrderQtySubTotal = $sumOrderQtySubTotal + $sumOrderQtyArr[$indexOfArr];
                            $sumRcvQtySubTotal = $sumRcvQtySubTotal + $sumRcvQtyArr[$indexOfArr];
                        }
                    }
                }
            }
            ?>
            <tr>
                <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($sumQtyTotal), 2); ?></td>
                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($procQtyTotal), 2); ?></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotal), 2); ?></td>
                <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($rcvQtyTotal), 2); ?></td>
            </tr>
<?php } else { ?>
            <tr>
                <td colspan="4"><div class="flash-error" style="width: 97%;">No result found!</div></td>
            </tr>
<?php } ?>
    </table>
</div>