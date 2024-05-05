<table class="items">
    <thead>
        <tr>
            <td colspan="13" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Item</th>
            <th>Code</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Input Qty</th>
            <th>Input Qty (Kg)</th>
            <th>Return Qty</th>
            <th>Return Qty (Kg)</th>
            <th>Used Qty</th>
            <th>Used Qty (Kg)</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data) { ?>
            <?php
            $itemArr = array();
            $qtyArr = array();
            $qtyKgArr = array();
            $rtnqtyArr = array();
            $rtnqtyKgArr = array();
            $sumTtlOfQty = 0;
            $sumTtlOfQtyKg = 0;
            $sumTtlOfRtnQty = 0;
            $sumTtlOfRtnQtyKg = 0;
            $arrPos = 0;
            $sl = 1;

            foreach ($data as $d):

                $sumOfQty = $d->sumOfQty;
                $sumOfQtyKg = $d->sumOfQtyKg;
                $sumOfRtnQty = $d->sumOfRtnQty;
                $sumOfRtnQtyKg = $d->sumOfRtnQtyKg;
                $itemId = $d->item;

                $itemArr[$arrPos] = $itemId;
                $qtyArr[$arrPos] = $sumOfQty;
                $qtyKgArr[$arrPos] = $sumOfQtyKg;
                $rtnqtyArr[$arrPos] = $sumOfRtnQty;
                $rtnqtyKgArr[$arrPos] = $sumOfRtnQtyKg;

                $sumTtlOfQty = $sumOfQty + $sumTtlOfQty;
                $sumTtlOfQtyKg = $sumOfQtyKg + $sumTtlOfQtyKg;

                $sumTtlOfRtnQty = $sumOfRtnQty + $sumTtlOfRtnQty;
                $sumTtlOfRtnQtyKg = $sumOfRtnQtyKg + $sumTtlOfRtnQtyKg;

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
                            <td colspan="13" style="color: blue; font-weight: bold; text-align: center;">
                                <?php echo $category->name; ?>
                            </td>
                        </tr>
                        <?php
                        $qtySubTtl = 0;
                        $qtyKgSubTtl = 0;
                        $rtnqtySubTtl = 0;
                        $rtnqtyKgSubTtl = 0;
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
                                    <td style="background-color: #8db4e2;"><?php echo number_format(floatval($qtyArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($qtyKgArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #8db4e2;"><?php echo number_format(floatval($rtnqtyArr[$indexOfArr]), 2); ?></td>
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($rtnqtyKgArr[$indexOfArr]), 2); ?></td>
                                    <?php
                                    $usedQty = $qtyArr[$indexOfArr] - $rtnqtyArr[$indexOfArr];
                                    $usedQtyKg = $qtyKgArr[$indexOfArr] - $rtnqtyKgArr[$indexOfArr];
                                    ?>
                                    <td style="background-color: #2fb5e4; font-weight: bold;"><?php echo number_format(floatval($usedQty), 2); ?></td>
                                    <td style="background-color: #fee35c; font-weight: bold;"><?php echo number_format(floatval($usedQtyKg), 2); ?></td>
                                </tr>
                                <?php
                            }
                            $qtySubTtl = $qtySubTtl + $qtyArr[$indexOfArr];
                            $qtyKgSubTtl = $qtyKgSubTtl + $qtyKgArr[$indexOfArr];
                            $rtnqtySubTtl = $rtnqtySubTtl + $rtnqtyArr[$indexOfArr];
                            $rtnqtyKgSubTtl = $rtnqtyKgSubTtl + $rtnqtyKgArr[$indexOfArr];
                        }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Sub Total</td>
                            <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($qtySubTtl), 2); ?></td>
                            <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($qtyKgSubTtl), 2); ?></td>
                            <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($rtnqtySubTtl), 2); ?></td>
                            <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($rtnqtyKgSubTtl), 2); ?></td>
                            <?php
                            $usedQtySubTotal = $qtySubTtl - $rtnqtySubTtl;
                            $usedQtyKgSubTotal = $qtyKgSubTtl - $rtnqtyKgSubTtl;
                            ?>
                            <td style="background-color: #2fb5e4; font-weight: bold;"><?php echo number_format(floatval($usedQtySubTotal), 2); ?></td>
                            <td style="background-color: #fee35c; font-weight: bold;"><?php echo number_format(floatval($usedQtyKgSubTotal), 2); ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
            <tr>
                <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumTtlOfQty), 2); ?></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumTtlOfQtyKg), 2); ?></td>
                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($sumTtlOfRtnQty), 2); ?></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($sumTtlOfRtnQtyKg), 2); ?></td>
                <?php
                $usedQtyTotal = $sumTtlOfQty - $sumTtlOfRtnQty;
                $usedQtyKgTotal = $sumTtlOfQtyKg - $sumTtlOfRtnQtyKg;
                ?>
                <td style="background-color: #2fb5e4; font-weight: bold;"><?php echo number_format(floatval($usedQtyTotal), 2); ?></td>
                <td style="background-color: #fee35c; font-weight: bold;"><?php echo number_format(floatval($usedQtyKgTotal), 2); ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="13"><div class="flash-error">No result found!</div></td>
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
