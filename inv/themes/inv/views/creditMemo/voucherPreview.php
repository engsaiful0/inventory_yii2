<?php
echo "<div class='printBtn'>";
$this->widget('ext.mPrint.mPrint', array(
    'title' => ' ', //the title of the document. Defaults to the HTML title
    'tooltip' => 'Print', //tooltip message of the print icon. Defaults to 'print'
    'text' => '', //text which will appear beside the print icon. Defaults to NULL
    'element' => '.printAllTableForThisReport', //the element to be printed.
    'exceptions' => array(//the element/s which will be ignored
    ),
    'publishCss' => FALSE, //publish the CSS for the whole page?
    'visible' => !Yii::app()->user->isGuest, //should this be visible to the current user?
    'alt' => 'print', //text which will appear if image can't be loaded
    'debug' => FALSE, //enable the debugger to see what you will get
    'id' => 'print-div'         //id of the print link
));
echo "</div>";
?>
<div class='printAllTableForThisReport'>
    <table class="headerTab">
        <tr>
            <th colspan="6" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">Credit Memo</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">Customer</td>
            <td style="vertical-align: top;">:</td>
            <td style="vertical-align: top;"><?php echo Customers::model()->customerNameAndAddress(end($data)->customer_id); ?></td>
            <td style="vertical-align: top;">
                Voucher No<br/>Date<br/>Bill No<br/>Total Billed Amount (Paid)<br/>Promotional Discount
            </td>
            <td style="vertical-align: top;">:<br/>:<br/>:<br/>:<br/>:</td>
            <td style="vertical-align: top;">
                <?php echo end($data)->sl_no; ?><br/>
                <?php echo end($data)->date; ?><br/>
                <?php echo end($data)->bill_no; ?><br/>
                <?php echo number_format(floatval(CustomerMr::model()->totalMrAmountOfThisBill(end($data)->bill_no)),2); ?><br/>
                <?php echo number_format(floatval(end($data)->discount),2); ?>
            </td>
        </tr>
    </table>
    <table class="headerTab">
        <tr>
            <td style="padding-top: 40px; text-align: left;"></td>
            <td style="padding-top: 40px; text-align: right;"></td>
            <td style="padding-top: 40px; text-align: center;"></td>
        </tr>
        <tr>
            <th style="text-decoration: overline; text-align: left;">Received By</th>
            <th style="text-decoration: overline;text-align: center;">Bill Supervisor</th>
            <th style="text-decoration: overline; text-align: right;">Authorized Signature</th>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 20px; text-align: right; font-style: italic;">
                Prepared By: <?php echo Users::model()->fullNameOfThis(end($data)->created_by); ?>
            </td>
        </tr>
    </table>
    <style>
        table.reportTab{
            float: left;
            width: 100%;
            border-collapse: collapse;
        }
        table.reportTab tr td, table.reportTab tr th{
            text-align: center;
            border: 1px solid #b8b8b8;
            padding: 4px;
            color: #000000;
        }
        table.reportTab tr th{
            background-color: #f4f4f4;
        }
    </style>
</div>
