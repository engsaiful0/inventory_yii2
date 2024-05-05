<table class="items">
    <thead>
        <tr>
            <td colspan="15" style="text-align: center;"><?php echo YourCompany::model()->activeInfoForPdf(); ?></td>
        </tr>
        <tr>
            <td colspan="15" style="text-align: center;"><?php echo $message; ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>Req No</th>
            <th>Req Date</th>
            <th>Department</th>
            <th>Store</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Item</th>
            <th>Code</th>
            <th>Specification</th>
            <th>Unit</th>
            <th>Req. Qty</th>
            <th>Req. By</th>
            <th>Delv. Qty</th>
            <th>Approved By</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($data) { ?>
            <?php
            $totalQty = 0;
            $totalDelvQty = 0;
            $sl = 1;
            ?>
            <?php foreach ($data as $d) { ?>
                <?php
                $itemInfo = Items::model()->findByPk($d->item);
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
            echo 'odd';
        ?>">
                    <td><?php echo $sl++; ?></td>
                    <td><?php echo $d->sl_no; ?></td>
                    <td><?php echo $d->req_date; ?></td>
                    <td><?php echo Departments::model()->nameOfThis($d->department); ?></td>
                    <td><?php echo Stores::model()->storeName($d->store); ?></td>
                    <td style="text-align: left;"><?php echo $itemCat; ?></td>
                    <td style="text-align: left;"><?php echo $itemCatSub; ?></td>
                    <td style="text-align: left;"><?php echo $itemName; ?></td>
                    <td style="text-align: left;"><?php echo $itemCode; ?></td>
                    <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                    <td><?php echo $itemUnit; ?></td>
                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($d->qty), 2); ?></td>
                    <td style="text-align: left;"><?php echo Employees::model()->fullNameWithDesigDepart($d->req_by); ?></td>
                    <?php
                    $deliveryQty = StoreReqDR::model()->availableQtyOfThisReqId($d->id);
                    $approvedBy = StoreReqDR::model()->approvedByOfThisReqId($d->id);
                    ?>
                    <td style="background-color: #e6b8b7;"><?php echo number_format(floatval($deliveryQty), 2); ?></td>
                    <td style="text-align: left;"><?php echo Users::model()->fullNameOfThis($approvedBy); ?></td>
                </tr>
                <?php
                $totalQty = $d->qty + $totalQty;
                $totalDelvQty = $deliveryQty + $totalDelvQty;
                ?>
    <?php } ?>
            <tr>
                <td colspan="11" style="text-align: right; padding-right: 6px; background-color: #d6963f; font-weight: bold;">Total</td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalQty), 2); ?></td>
                <td style="background-color: #d6963f; font-weight: bold;"></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($totalDelvQty), 2); ?></td>
                <td style="background-color: #d6963f; font-weight: bold;"></td>
            </tr>
<?php } else { ?>
            <tr>
                <td colspan="15"><div class="flash-error">No result found!</div></td>
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
