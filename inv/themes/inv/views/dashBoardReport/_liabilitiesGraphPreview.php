<?php

$year = date('Y');
$startDate = $year . "-01-01";
$totalPrArr = array();
$totalMrArr = array();
$totalPrTotal=0;
$totalMrTotal=0;
for ($month = 1; $month <= 12; $month++) {
    $startDate = $year . "-" . $month . "-01";
    $endDate = $year . "-" . $month . "-31";

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
    $totalPrArr[]=$totalPr;
    $totalPrTotal=$totalPr+$totalPrTotal;
    
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
    $totalMrArr[]=$totalMr;
    $totalMrTotal=$totalMr+$totalMrTotal;
}
$diff=($totalMrTotal-$totalPrTotal);

$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => array('text' => 'PR/MR CHART- ' . $year),
        'xAxis' => array(
            'categories' => array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC')
        ),
        'yAxis' => array(
            'title' => array('text' => 'AMOUNT'),
        ),
        'series' => array(
            array('name' => 'Paid', 'data' => $totalPrArr),
            array('name' => 'Received', 'data' => $totalMrArr),
        ),
        'tooltip' => array(
            'valueSuffix' => ' TK'
        ),
    ),
    'htmlOptions' => array(
    ),
    // register additional scripts
    'scripts' => array('highcharts-more', 'modules/exporting', 'adapters/mootools-adapter'),
    // register themes
    'themes' => array('dark-green'),
));

echo "<hr>";  
if($diff>0)
    echo "<div style='float: left; width: 99%; border: 1px solid; background-color: green; padding: 4px; color: #FFFFFF;'>Profit: ".number_format(floatval($diff),2)." TK</div>";
else
    echo "<div style='float: left; width: 99%; border: 1px solid; background-color: red; padding: 4px; color: yellow'>Loss: ".number_format(floatval($diff),2)." TK</div>";

?>
