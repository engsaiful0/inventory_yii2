<table class="items">
    <thead>
        <tr>
            <td colspan="11" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="11" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Item</th>
            <th>Code</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Req. Qty</th>
            <th>Proc. Qty</th>
            <th>Order Qty</th>
            <th>Rcv. Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data) { ?>
            <?php
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
                if ($store != "")
                    $criteria->addColumnCondition(array("store" => $store, "item" => $itemId), "AND", "AND");
                else
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
            ?>
            <?php
            $categories = Cats::model()->findAll();
            if ($categories) {
                foreach ($categories as $category) {
                    $criteriaItms = new CDbCriteria();
                    $criteriaItms->addColumnCondition(array("cat" => $category->id), "AND", "AND");
                    $criteriaItms->addInCondition("id", $itemArr);
                    $items = Items::model()->findAll($criteriaItms);
                    if ($items) {
                        ?>
                        <tr>
                            <td colspan="11" style="color: blue; font-weight: bold; text-align: center;">
                                <?php echo $category->name; ?>
                            </td>
                        </tr>
                        <?php
                        $sumQtySubTotal = 0;
                        $sumProcQtySubTotal = 0;
                        $sumOrderQtySubTotal = 0;
                        $sumRcvQtySubTotal = 0;
                        $sl = 1;
                        foreach ($items as $item) {
                            if (in_array($item->id, $itemArr)) {
                                $indexOfArr = array_search($item->id, $itemArr);
                                ?>
                                <?php
                                $itemInfo = Items::model()->findByPk($itemArr[$indexOfArr]);
                                if ($itemInfo) {
                                    $itemName = $itemInfo->name;
                                    $itemUnit = $itemInfo->unit;
                                    $itemDesc = $itemInfo->desc;
                                    $itemCode = $itemInfo->code;
                                    $itemCat = Cats::model()->nameOfThis($itemInfo->cat);
                                    $itemCatSub = CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                                } else {
                                    $itemName = "<font color='red'>Removed!</font>";
                                    $itemUnit = "";
                                    $itemDesc = "";
                                    $itemCode = "";
                                    $itemCat = "";
                                    $itemCatSub = "";
                                }
                                ?>
                                <tr class="<?php
                        if ($sl % 2 == 0)
                            echo 'even'; else
                            'odd';
                                ?>">
                                    <td><?php echo $sl++; ?></td>
                                    <td style="text-align: left;"><?php echo $itemCat; ?></td>
                                    <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                                    <td style="text-align: left;"><?php echo $itemName; ?></td>
                                    <td style="text-align: left;"><?php echo $itemCode; ?></td>
                                    <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                                    <td><?php echo $itemUnit; ?></td>
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($sumQtyArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #8db4e2;"><?php echo number_format(floatval($sumProcQtyArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($sumOrderQtyArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #ffff00;"><?php echo number_format(floatval($sumRcvQtyArr[$indexOfArr]), 2); ?></td>
                                </tr>
                                <?php
                            }
                            $sumQtySubTotal = $sumQtySubTotal + $sumQtyArr[$indexOfArr];
                            $sumProcQtySubTotal = $sumProcQtySubTotal + $sumProcQtyArr[$indexOfArr];
                            $sumOrderQtySubTotal = $sumOrderQtySubTotal + $sumOrderQtyArr[$indexOfArr];
                            $sumRcvQtySubTotal = $sumRcvQtySubTotal + $sumRcvQtyArr[$indexOfArr];
                        }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Sub Total</td>
                            <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumQtySubTotal), 2); ?></td>
                            <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumProcQtySubTotal), 2); ?></td>
                            <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumOrderQtySubTotal), 2); ?></td>
                            <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($sumRcvQtySubTotal), 2); ?></td>
                        </tr>

                        <?php
                    }
                }
            }
            ?>
            <tr>
                <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($sumQtyTotal), 2); ?></td>
                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($procQtyTotal), 2); ?></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotal), 2); ?></td>
                <td style="background-color: #ffff00; font-weight: bold;"><?php echo number_format(floatval($rcvQtyTotal), 2); ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="11"><div class="flash-error">No result found!</div></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<style>
    table, table tr, table tr th, table tr td{
        border-collapse: collapse;
        border: 1px solid #000000;
        font-size: 5px;
        font-weight: normal;
    }
    table tr th, table tr td{
        padding: 2px;
    }
    table tr.even{
        background-color: #f9f9f9;
    }
</style>
