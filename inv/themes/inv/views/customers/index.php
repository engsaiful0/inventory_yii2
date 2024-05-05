<?php
$cirteriaSellItems = new CDbCriteria();
$cirteriaSellItems->select = 'so_no, sum(sell_qty*(sell_price-(sell_price*(discount/100)))) as grand_total';
$cirteriaSellItems->group = "so_no";
$cirteriaSellItems->condition = "customer_id=" . $customerId;
$sellData = SellItems::model()->findAll($cirteriaSellItems);
if ($sellData) {
    $totalDebit = 0;
    foreach ($sellData as $sd):
        $soNo = $sd->so_no;
        $dateOfSell = $sd->date_of_sell;
        $priceQty = $sd->grand_total;

        $discountOfThis = 0;
        $discountData = DiscountTab::model()->findByAttributes(array('no' => $soNo, 'no_type' => DiscountTab::SALE_ORDER));
        if ($discountData) {
            $discountOfThis = $discountData->discount;
        }
        $priceQtyWithOverallDisc = ($priceQty - ($priceQty * ($discountOfThis / 100)));

        $cirteriaOtherCosting = new CDbCriteria();
        $cirteriaOtherCosting->select = 'sum(costing_amount) as totalCostingAmount';
        $cirteriaOtherCosting->condition = "so_no='" . $soNo . "'";
        $otherCostingData = OtherCosting::model()->findAll($cirteriaOtherCosting);

        $cirteriaServices = new CDbCriteria();
        $cirteriaServices->select = 'sum(service_amount) as totalServiceAmount';
        $cirteriaServices->condition = "so_no='" . $soNo . "'";
        $serviceData = Services::model()->findAll($cirteriaServices);
        $otherCostingAmount = 0;
        $serviceAmount = 0;
        if ($otherCostingData) {
            foreach ($otherCostingData as $ocd):
                $otherCostingAmount = $ocd->totalCostingAmount;
            endforeach;
        }
        if ($serviceData) {
            foreach ($serviceData as $sd):
                $serviceAmount = $sd->totalServiceAmount;
            endforeach;
        }
        $totalBilledAmount = ($priceQtyWithOverallDisc + $otherCostingAmount + $serviceAmount);

        $totalDebit = ($totalBilledAmount + $totalDebit);

    endforeach;
}
?>