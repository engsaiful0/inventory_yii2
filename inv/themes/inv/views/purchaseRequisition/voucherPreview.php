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
            <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">PURCHASE REQUISITION</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-bottom: 10px;"><b>Requisition No: </b><?php echo end($data)->sl_no; ?></td>
            <td style="text-align: right; padding-bottom: 10px;"><b>Requisition Date: </b><?php echo end($data)->date; ?></td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left; padding-bottom: 10px;">Following items are required as shown against each for department: <i><?php echo Departments::model()->nameOfThis(end($data)->department); ?></i>, to store: <i><?php echo Stores::model()->storeName(end($data)->store); ?></i></th>
        </tr>
    </table>
    <table class="reportTab">
        <tr>
            <th style="width: 32px;">SL</th>
            <th>Item</th>
            <th>Specification</th>
            <th>Present Stock</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Cost/Unit</th>
            <th>Approx Amount</th>
            <th>Remarks</th>
        </tr>
        <?php
        $i = 1;
        $total = 0;
        ?>
        <?php foreach ($data as $d) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <?php
                $itemInfo = Items::model()->findByPk($d->item);
                if ($itemInfo) {
                    $itemName = $itemInfo->name;
                    $itemUnit = $itemInfo->unit;
                    $itemDesc = $itemInfo->desc;
                } else {
                    $itemName = "<font color='red'>Removed!</font>";
                    $itemUnit = "";
                    $itemDesc = "";
                }
                ?>
                <td style="text-align: left;"><?php echo $itemName; ?></td>
                <td style="text-align: left;"><?php echo $itemDesc; ?></td>
                <td><?php echo number_format(floatval(Inventory::model()->presentStockOfThisItem($d->item, $d->store)), 2); ?></td>
                <td><?php echo $d->qty; ?></td>
                <td><?php echo Units::model()->name_of_unitOfThis($d->name_of_unit)?></td>
                <td style="text-align: right;"><?php echo number_format(floatval($d->cost), 2); ?></td>
                <?php
                $lineTotal = $d->cost * $d->qty;
                $total = $total + $lineTotal;
                ?>
                <td style="text-align: right;"><?php echo number_format(floatval($lineTotal), 2); ?></td>
                <td style="text-align: right;"><?php echo $d->remarks; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="7" style="text-align: right; padding-right: 6px;">Total</th>
            <th style="text-align: right;"><?php echo number_format(floatval($total), 2); ?></th>
            <th></th>
        </tr>
        <?php
        $amountInWord = new AmountInWord();
        ?>
        <tr>
            <th colspan="8" style="text-align: right;">In Word: <?php echo $amountInWord->convert(intval($total)); ?></th>
            <th></th>
        </tr>
    </table>
    <table class="headerTab">
          <tr>
            <th style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Submitted for approval and order</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <td style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Requisition By</td>
            <td></td>
            <td style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Approved by</td>
        </tr>
        <tr>
            <td style="padding-top: 20px;">Signature:</td>
            <td style="padding-top: 20px;"></td>
            <td style="padding-top: 20px;">Signature:</td>
        </tr>
         <?php
            $reqByInfo = Employees::model()->findByPk(end($data)->req_by);
            if ($reqByInfo) {
                $reqByName = $reqByInfo->full_name;
                $reqBydesignation = Designations::model()->infoOfThis($reqByInfo->designation_id);
                $reqBydepartment = Departments::model()->nameOfThis($reqByInfo->department_id);
            } else {
                $reqByName = "<font color='red'>Employee removed !</font>";
                $reqBydesignation = "";
                $reqBydepartment = "";
            }
           // print_r(end($data)->submitted_to);
           // exit;
                    $approvedByInfo=  Employees::model()->findByPk(end($data)->approve_to);
                    if($approvedByInfo){
//                        $approvedByInfo=Employees::model()->findByPk($userInfo->employee_id);
//                        if($approvedByInfo){
                            $approveByName=$approvedByInfo->full_name;
                            $approveBydesignation=Designations::model()->infoOfThis($approvedByInfo->designation_id);
                            $approveBydepartment=  Departments::model()->nameOfThis($approvedByInfo->department_id);
                        }else{
                            $approveByName="<font color='red'>Employee removed !</font>";
                            $approveBydesignation="";
                            $approveBydepartment="";
                        }
                
            ?>
        <tr>
            <td>Requisition By:<?php  echo $reqByName;
            //Users::model()->fullNameOfThis(end($data)->created_by); ?></td>
            <td></td>
            <td>Approved By: <?php echo $approveByName;?> </td>
        </tr>
        <tr>
            <td>Department:<?php echo $reqBydepartment;?></td>
            <td></td>
            <td>Department:<?php echo $approveBydepartment;?></td>
        </tr>
        <tr>
            <td>Designation:<?php echo $reqBydesignation;?></td>
            <td></td>
            <td>Designation:<?php echo $approveBydesignation;?></td>
        </tr>
        <tr>
            <td>Grow Biz Industries Ltd</td>
            <td></td>
            <td>Grow Biz Industries Ltd</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: center; text-decoration: underline; padding: 20px 0px;">To be filled by Purchase Department</th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left; text-decoration: underline; padding-bottom: 20px;">Remarks:</th>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px dotted #999999;">&nbsp;</td>
        </tr>
        <tr>
            <th style="text-align: left; text-decoration: underline; padding-top: 60px;">Date</th>
            <th style="text-align: center; text-decoration: underline; padding-top: 60px;">Concerned Officer</th>
            <th style="text-align: right; text-decoration: underline; padding-top: 60px;">Authorized Signature</th>
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
