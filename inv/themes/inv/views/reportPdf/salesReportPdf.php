<table class="items">
    <thead>
        <tr>
            <td colspan="22" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="22" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>SO No</th>
            <th>Issue Date</th>
            <th>Expected D.Date</th>
            <th>Local/Export</th>
            <th>PI No</th>
            <th>PI Date</th>
            <th>Store</th>
            <th>Customer</th>
            <th>Contact Person</th>
            <th>Sales By</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Item</th>
            <th>Spec</th>
            <th>Code</th>
            <th>Unit</th>
            <th>Order Qty</th>
            <th>Converted Unit</th>
            <th>Rate</th>
            <th>Amount</th>
            <th>Delv. Qty</th>
        </tr>
    </thead>
    <tbody>
                <?php
                if ($data) {
                    $sl = 1;
                    $orderQtyTotalTotal = 0;
                    $amountTotalTotal = 0;
                    $delvQtyTotalTotal = 0;
                    foreach ($data as $d) {
                        $criteria = new CDbCriteria();
                        $criteria->select = "id, item, price, qty, conv_unit";
                        $criteria->addColumnCondition(array("sl_no" => $d->sl_no), "AND", "AND");

                        if ($category != "" || $supplier_id != "") {
                            if($category != "" && $supplier_id == ""){
                                $condition="cat=".$category;
                            }else if($category == "" && $supplier_id != ""){
                                $condition="supplier_id=".$supplier_id;
                            }else if ($category != "" && $supplier_id != ""){
                                $condition="cat=".$category." AND supplier_id=".$supplier_id;
                            }else{
                                $condition="";
                            }
                            $itemsData = Items::model()->findAll(array("condition" => $condition));
                            $itemsArray = array();
                            if ($itemsData) {
                                foreach ($itemsData as $itmsd) {
                                    $itemsArray[] = $itmsd->id;
                                }
                            }
                            $criteria->addInCondition("item", $itemsArray, "AND");
                        }
                        
                        if ($item != "") {
                            $criteria->addColumnCondition(array("item" => $item), "AND", "AND");
                        }
                        $data2 = SaleOrder::model()->findAll($criteria);
                        $rowspan = count($data2);
                        $rowspancount = 1;
                        
                        $orderQtyTotal = 0;
                        $amountTotal = 0;
                        $delvQtyTotal = 0;
                        $delvAmountTotal = 0;
                        
                        foreach ($data2 as $d2) {
                            ?>
                            <tr>
                                <?php if ($rowspancount == 1) { ?>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $sl++; ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $d->sl_no; ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $d->issue_date; ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $d->expected_d_date; ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo Lookup::item("order_type2", $d->order_type2); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo str_replace(",", "<br>", $d->pi_no); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo $d->pi_date; ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>">
                                        <?php echo Stores::model()->storeName($d->store); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>" style="text-align: left;">
                                        <?php echo Customers::model()->customerName($d->customer_id); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>" style="text-align: left;">
                                        <?php echo CustomerContactPersons::model()->allInfoOfThis($d->contact_person); ?>
                                    </td>
                                    <td rowspan="<?php echo $rowspan; ?>" style="text-align: left;">
                                        <?php echo Employees::model()->fullName($d->sales_by); ?>
                                    </td>
                                <?php } ?>
                                <?php
                                $itemInfo = Items::model()->findByPk($d2->item);
                                if ($itemInfo) {
                                    $itemName = $itemInfo->name;
                                    $itemUnit = $itemInfo->unit;
                                    $itemDesc = $itemInfo->desc;
                                    $itemCode=$itemInfo->code;
                                    $itemCat = Cats::model()->nameOfThis($itemInfo->cat);
                                    $itemCatSub = CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                                    $unitConvertable = $itemInfo->unit_convertable;
                                } else {
                                    $itemName = "<font color='red'>Removed!</font>";
                                    $itemUnit = "";
                                    $itemDesc = "";
                                    $itemCode="";
                                    $itemCat = "";
                                    $itemCatSub="";
                                    $unitConvertable="";
                                }
                                ?>
                                <td style="text-align: left;"><?php echo $itemCat; ?></td>
                                <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                                <td style="text-align: left;"><?php echo $itemName; ?></td>
                                <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                                <td style="text-align: left;"><?php echo $itemCode; ?></td>
                                <td><?php echo $itemUnit; ?></td>
                                <td>
                                    <?php 
                                    $orderQty = $d2->qty;
                                    echo number_format(floatval($orderQty), 2);
                                    $orderQtyTotal = $orderQty + $orderQtyTotal;
                                    ?>
                                </td>
                                <?php
                                    $conv_unit=$d2->conv_unit;
                                    $convertedUnit = Items::model()->convertedUnit($unitConvertable, $itemDesc);
                                    $sft = $convertedUnit[0];
                                    $rft = $convertedUnit[1];
                                    $cft = $convertedUnit[2];
                                    $sqm = $convertedUnit[3];
                                    $convertedText="";
                                    if ($conv_unit == Items::SFT) {
                                        $qty = $sft;
                                        $convertedText=number_format(floatval($qty),2)."SFT";
                                    } else if ($conv_unit == Items::RFT) {
                                        $qty = $rft;
                                        $convertedText=number_format(floatval($qty),2)."RFT";
                                    } else if ($conv_unit == Items::CFT) {
                                        $qty = $cft * $orderQty;
                                        $convertedText=number_format(floatval($qty),2)."CFT";
                                    } else if ($conv_unit == Items::SQM) {
                                        $qty = $sqm;
                                        $convertedText=number_format(floatval($qty),2)."SQM";
                                    } else {
                                        $qty = $orderQty;
                                        $convertedText="";
                                    }
                                ?>
                                <td>
                                    <?php echo $convertedText; ?>
                                </td>
                                <td><?php echo number_format(floatval($d2->price), 2); ?></td>
                                <td>
                                    <?php
                                    $amount = $qty * $d2->price;
                                    echo number_format(floatval($amount), 2);
                                    $amountTotal = $amount + $amountTotal;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $delvQty = SellDelvRtn::model()->availableQtyOfThisSellOrderId($d2->id);
                                    echo number_format(floatval($delvQty), 2);
                                    $delvQtyTotal = $delvQty + $delvQtyTotal;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $rowspancount++;
                        }
                        $orderQtyTotalTotal = $orderQtyTotal+$orderQtyTotalTotal;
                        $amountTotalTotal = $amountTotal+$amountTotalTotal;
                        $delvQtyTotalTotal = $delvQtyTotal+$delvQtyTotalTotal;
                        ?>
                            <tr>
                                <td colspan="17" style="text-align: right; padding-right: 6px; font-weight: bold;">Sub Total</td>
                                <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotal), 2); ?></td>
                                <td></td>
                                <td></td>
                                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($amountTotal), 2); ?></td>
                                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($delvQtyTotal), 2); ?></td>
                            </tr>
                        <?php
                    }
                    ?>
                            <tr>
                                <td colspan="22"></td>
                            </tr>
                            <tr>
                                <td colspan="17" style="text-align: right; padding-right: 6px; font-weight: bold;">Total</td>
                                <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotalTotal), 2); ?></td>
                                <td></td>
                                <td></td>
                                <td style="background-color: #8db4e2; font-weight: bold;"><?php echo number_format(floatval($amountTotalTotal), 2); ?></td>
                                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($delvQtyTotalTotal), 2); ?></td>
                            </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td colspan="22"><div class="flash-error">No result found!</div></td>
                    </tr>
                    <?php
                }
                ?>
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
