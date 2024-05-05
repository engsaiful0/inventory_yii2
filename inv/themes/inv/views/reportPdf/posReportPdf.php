<table class="items">
    <thead>
        <tr>
            <td colspan="12" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Item</th>
            <th>Code</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Rate (-VAT)</th>
            <th>Amount (-VAT)</th>
            <th>VAT</th>
            <th>Amount (+VAT)</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data) { ?>
            <?php
            $itemArr = array();
            $qtyArr = array();
            $priceArr = array();
            $amountArr = array();
            $vatablePriceArr = array();
            $vatableAmountArr = array();
            $vaArr = array();

            $arrPos = 0;

            foreach ($data as $d):

                $itemId = $d->item_id;
                $qty = $d->sumOfQty;
                $price = $d->price;
                $amount = $d->sumOfSaleAmount;
                $vatablePrice = $d->vatable_price;
                $vatableAmount = $d->sumOfSaleAmountVatable;
                $vat = ($vatableAmount - $amount);

                $itemArr[$arrPos] = $itemId;
                $qtyArr[$arrPos] = $qty;
                $priceArr[$arrPos] = $price;
                $amountArr[$arrPos] = $amount;
                $vatablePriceArr[$arrPos] = $vatablePrice;
                $vatableAmountArr[$arrPos] = $vatableAmount;
                $vaArr[$arrPos] = $vat;

                $arrPos++;
            endforeach;
            ?>
            <?php
            $totalQty = 0;
            $totalPrice = 0;
            $totalAmount = 0;
            $totalVatablePrice = 0;
            $totalVatableAmount = 0;
            $totalVat = 0;

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
                            <td colspan="12" style="color: blue; font-weight: bold; text-align: center;">
                                <?php echo $category->name; ?>
                            </td>
                        </tr>
                        <?php
                        $subTotalQty = 0;
                        $subTotalPrice = 0;
                        $subTotalAmount = 0;
                        $subTotalVatablePrice = 0;
                        $subTotalVatableAmount = 0;
                        $subTotalVat = 0;
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
                                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($qtyArr[$indexOfArr]), 3); ?></td>
                                    <td style="background-color: #72dff5;"><?php echo number_format(floatval($priceArr[$indexOfArr]), 3); ?></td>
                                    <td style="background-color: #a4cbf7; text-align: right;"><?php echo number_format(floatval($amountArr[$indexOfArr]), 3); ?></td>
                                    <td style="background-color: #c1f09d; text-align: right;"><?php echo number_format(floatval($vaArr[$indexOfArr]), 3); ?></td>
                                    <td style="background-color: #a4cbf7; text-align: right;"><?php echo number_format(floatval($vatableAmountArr[$indexOfArr]), 3); ?></td>
                                </tr>
                                <?php
                            }
                            $subTotalQty = $subTotalQty + $qtyArr[$indexOfArr];
                            $subTotalPrice = $subTotalPrice + $priceArr[$indexOfArr];
                            $subTotalAmount = $subTotalAmount + $amountArr[$indexOfArr];
                            $subTotalVatablePrice = $subTotalVatablePrice + $vatablePriceArr[$indexOfArr];
                            $subTotalVatableAmount = $subTotalVatableAmount + $vatableAmountArr[$indexOfArr];
                            $subTotalVat = $subTotalVat + $vaArr[$indexOfArr];
                        }
                        ?>
                        <tr>
                            <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #f7f7f7; font-weight: bold;">Total</td>
                            <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($subTotalQty), 3); ?></td>
                            <td style="background-color: #72dff5; font-weight: bold;"><?php echo number_format(floatval($subTotalPrice), 3); ?></td>
                            <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($subTotalAmount), 3); ?></td>
                            <td style="background-color: #c1f09d; font-weight: bold; text-align: right;"><?php echo number_format(floatval($subTotalVat), 3); ?></td>
                            <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($subTotalVatableAmount), 3); ?></td>
                        </tr>
                        <?php
                        $totalQty = $subTotalQty + $totalQty;
                        $totalPrice = $subTotalPrice + $totalPrice;
                        $totalAmount = $subTotalAmount + $totalAmount;
                        $totalVatablePrice = $subTotalVatablePrice + $totalVatablePrice;
                        $totalVatableAmount = $subTotalVatableAmount + $totalVatableAmount;
                        $totalVat = $subTotalVat + $totalVat;
                    }
                }
            }
            ?>
            <tr>
                <td colspan="12" style="padding: 10px 0px;"></td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Net</td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalQty), 3); ?></td>
                <td style="background-color: #72dff5; font-weight: bold;"><?php echo number_format(floatval($totalPrice), 3); ?></td>
                <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalAmount), 3); ?></td>
                <td style="background-color: #c1f09d; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalVat), 3); ?></td>
                <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalVatableAmount), 3); ?></td>
            </tr>
            <?php
            $totalOverallDiscount = 0;
            $totalCash = 0;
            $totalVisa = 0;
            $totalMaster = 0;
            $totalAmex = 0;
            $totalGiftCard = 0;
            $totalReturn = 0;
            $ticketCount = 0;
            if ($data2) {
                foreach ($data2 as $d2) {
                    $ticketCount++;
                    if ($d2->discount_type == 0) {
                        $totalOverallDiscount = $totalOverallDiscount + $d2->overall_discount;
                    } else {
                        $totalOverallDiscount = $totalOverallDiscount + ($d2->sumOfSaleAmountVatable * ($d2->overall_discount / 100));
                    }

                    $totalCash = $d2->cash_payment + $totalCash;
                    $totalVisa = $d2->visa_payment + $totalVisa;
                    $totalMaster = $d2->master_payment + $totalMaster;
                    $totalAmex = $d2->amex_payment + $totalAmex;
                    $totalGiftCard = $d2->gift_card_payment + $totalGiftCard;
                    $totalReturn = $d2->cash_return + $totalReturn;
                }
            }
            $totalCash = $totalCash - $totalReturn;
            $subTotalPayment = ($totalCash + $totalVisa + $totalMaster + $totalAmex + $totalGiftCard);
            ?>
            <tr>
                <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Discount</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($totalOverallDiscount), 3); ?></td>
            </tr>
            <?php
            $grossTotal = ($totalVatableAmount - $totalOverallDiscount);
            ?>
            <tr>
                <td colspan="7" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Gross</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="background-color: #a4cbf7; font-weight: bold; text-align: right;"><?php echo number_format(floatval($grossTotal), 3); ?></td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: right; font-weight: bold;">Total Collection</td>
                <td colspan="4" style="text-align: right; font-weight: bold;">
                    <?php
                    echo "<font color='green'>TOTAL INVOICE COUNT:</font><hr>";
                    echo "NET CASH:<br>";
                    echo "VISA:<br>";
                    echo "MASTER:<br>";
                    echo "AMEX:<br>";
                    echo "GIFT CARD:<hr>";
                    echo "Total:";
                    ?>
                </td>
                <td style="text-align: right; font-weight: bold;">
                    <?php
                    echo "<font color='green'>" . $ticketCount . "</font><hr>";
                    echo number_format(floatval($totalCash), 3) . "<br>";
                    echo number_format(floatval($totalVisa), 3) . "<br>";
                    echo number_format(floatval($totalMaster), 3) . "<br>";
                    echo number_format(floatval($totalAmex), 3) . "<br>";
                    echo number_format(floatval($totalGiftCard), 3) . "<hr>";
                    echo number_format(floatval($subTotalPayment), 3);
                    ?>
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="12"><div class="flash-error">No result found!</div></td>
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
