<style>
    table.poReportTab{
        float: left;
        border-collapse: collapse;
        font-family: serif;
        font-size: 12px;
    }
    table.poReportTab th{
        padding: 10px 0px;
        text-align: center;
        color: #000000;
    }
    table.poReportTab td{
        padding: 4px 2px;
        text-align: center;
    }
</style>
<?php
if ($model) {
    $yourCompanyInfo = YourCompany::model()->findByAttributes(array('is_active' => YourCompany::ACTIVE,));
    if ($yourCompanyInfo) {
        $yourCompanyName = $yourCompanyInfo->company_name;
        $yourCompanyVatRegNo = $yourCompanyInfo->vat_regi_no;
        $yourCompanyLocation = $yourCompanyInfo->location;
        $yourCompanyRoad = $yourCompanyInfo->road;
        $yourCompanyHouse = $yourCompanyInfo->house;
        $yourCompanyContact = $yourCompanyInfo->contact;
        $yourCompanyEmail = $yourCompanyInfo->email;
        $yourCompanyWeb = $yourCompanyInfo->web;
    } else {
        $yourCompanyName = '';
        $yourCompanyVatRegNo = '';
        $yourCompanyLocation = '';
        $yourCompanyRoad = '';
        $yourCompanyHouse = '';
        $yourCompanyContact = '';
        $yourCompanyEmail = '';
        $yourCompanyWeb = '';
    }
    ?>

    <?php
    echo "<div class='printBtn'>";
    $this->widget('ext.mPrint.mPrint', array(
        'title' => ' ', //the title of the document. Defaults to the HTML title
        'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
        'text' => '', //text which will appear beside the print icon. Defaults to NULL
        'element' => '.printAllTableForThisReport', //the element to be printed.
        'exceptions' => array(//the element/s which will be ignored
            '.summary',
            '.search-form',
        ),
        'publishCss' => TRUE, //publish the CSS for the whole page?
        'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
        'alt' => 'print', //text which will appear if image can't be loaded
        'debug' => FALSE, //enable the debugger to see what you will get
        'id' => 'print-div'         //id of the print link
    ));
    echo "</div>";
    ?>
    <div class='printAllTableForThisReport' style="float: left;">
        <table class="poReportTab" id="customerCopy">
            <tr>
                <td colspan="3"><span id="invTitle">Points Used Voucher</span></td>
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold;"><?php if (!empty($yourCompanyName))
        echo $yourCompanyName; ?></td>
            </tr>
            <tr>
                <td colspan="3"><?php if (!empty($yourCompanyHouse))
                    echo $yourCompanyHouse; ?><?php if (!empty($yourCompanyRoad))
                    echo ', ' . $yourCompanyRoad; ?><?php if (!empty($yourCompanyLocation))
                    echo ', ' . $yourCompanyLocation; ?>
                    <?php if (!empty($yourCompanyContact))
                        echo '<br><b> Phone: ' . $yourCompanyContact . "</b>"; ?>
                    <?php if (!empty($yourCompanyEmail))
                        echo '<br>' . $yourCompanyEmail; ?>
                    <?php if (!empty($yourCompanyWeb))
                        echo ' ' . $yourCompanyWeb; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php if (!empty($yourCompanyVatRegNo))
                        echo '<b>VAT REG.NO: ' . $yourCompanyVatRegNo; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left; font-weight: bold; border-top: 1px dotted #000000;">
                    <span style="float: left;">
                        Invoice No: <?php echo $model->inv_no; ?>
                    </span>
                    <span style="float: right;">Date: <?php echo $model->date; ?></span>
                </td>
            </tr>
            <tr>
                <td style="text-align: left; border-bottom: 1px dotted #000000;">Member's Information</td>
                <td style="border-bottom: 1px dotted #000000;">Points</td>
                <td style="text-align: right; border-bottom: 1px dotted #000000;">Amount</td>
            </tr>
            <tr>
                <td style="text-align: left;"><?php Members::model()->nameOfThis($model->member_id); ?></td>
                <td><?php echo $model->used_point; ?></td>
                <td style="text-align: right;">
                    <?php
                    $pointAdd = 0;
                    $overAmount = 0;
                    $eachPointAmount = 0;
                    $activePointConf = MemberPointsConf::model()->findByAttributes(array('is_active' => MemberPointsConf::ACTIVE));
                    if ($activePointConf) {
                        $pointAdd = $activePointConf->point_add;
                        $overAmount = $activePointConf->over_amount;
                        $eachPointAmount = $activePointConf->each_point_amount;
                    }
                    $totalPayable = ($model->used_point * $eachPointAmount);
                    echo number_format(floatval($totalPayable), 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right; border-bottom: 1px dotted #000000; font-weight: bold;">Net Payable: </td>
                <td style="text-align: right; border-bottom: 1px dotted #000000; font-weight: bold;"><?php echo number_format(floatval($totalPayable), 2); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; border-bottom: 1px dotted #000000; font-weight: bold;">In Words: 
                    <?php
                    $amountInWord = new AmountInWord();
                    echo "BDT " . $amountInWord->convert(intval($totalPayable)) . " Only";
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-top: 1px dotted #000000; padding-bottom: 15px;">Thanks for visiting <?php echo $yourCompanyName; ?></td>
            </tr>
        </table>
        <?php
    } else {
        
    }
    ?>
</div>