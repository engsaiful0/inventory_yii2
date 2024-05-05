<div id="salesSec" class="sec">
    <div class="title">SALES</div>
    <div class="remove"><input title="remove" type="button" class="rdelete" onclick="$('#salesSec').hide();"/></div>
    <table class="dashBoardTab">
        <tr>
            <th>Order Qty</th>
            <th>Delivery Qty</th>
        </tr>
        <?php
        $orderQtyTotal = 0;
        $delvQtyTotal = 0;
        $criteria = new CDbCriteria();
        $criteria->select = "id, qty";
        if ($startDate != "" && $endDate != "")
            $criteria->addBetweenCondition('issue_date', $startDate, $endDate, 'AND');
        $data = SaleOrder::model()->findAll($criteria);
        if ($data) {
            foreach ($data as $d):
                $orderQtyTotal = $d->qty + $orderQtyTotal;
                $delvQtyTotal = SellDelvRtn::model()->availableQtyOfThisSellOrderId($d->id) + $delvQtyTotal;
            endforeach;
            ?>
            <tr>
                <td style="background-color: #d6963f; font-weight: bold;"><?php echo number_format(floatval($orderQtyTotal), 2); ?></td>
                <td style="background-color: #e6b8b7; font-weight: bold;"><?php echo number_format(floatval($delvQtyTotal), 2); ?></td>
            </tr>
            <?php
        }else {
            ?>
            <tr>
                <td colspan="2"><div class="flash-error" style="width: 97%;">No result found!</div></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>