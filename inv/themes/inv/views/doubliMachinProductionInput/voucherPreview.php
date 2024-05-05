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
            <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px; font-size: 18px;">Doubli Machin Production Input</th>
        </tr>
        <tr>
            <td style="text-align: left; padding-bottom: 10px;"><b>Doubli Machin Production Input No: </b><?php echo end($data)->sl_no; ?></td>
            <td style="text-align: right; padding-bottom: 10px;"><b>Input Date: </b><?php echo end($data)->input_date; ?></td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left; padding-bottom: 10px;">Following items are required</th>
        </tr>
    </table>
    <table class="reportTab">
        <tr>
            <th style="width: 32px;">SL</th>
            <th>Input No</th>
     
            <th>Item</th>
            <th>Length</th>
            <th>Width</th>
            <th>Thickness</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Kg/Qty</th>
        
        </tr>
        <?php
        $i = 1;
        $total = 0;
        $total2 = 0;
        ?>
        <?php foreach ($data as $dta) { ?>
                <tr class="<?php
                if ($i % 2 == 0)
                    echo 'odd';
                else
                    echo 'even';
                ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $dta->sl_no; ?></td>
                   
                    <td><?php Items::model()->item($dta->item); ?></td>
                    <td><?php echo $dta->length; ?></td>
                    <td><?php echo $dta->width; ?></td>
                    <td><?php echo $dta->thickness ?></td>
                 
                    <td><?php echo UnitDistance::model()->unit_of_distanceOfThis($dta->unit_of_distance);  ?></td>
                    <td><?php echo $dta->qty; ?></td>
                    <td><?php echo $dta->qty_kg ?></td>
             
                </tr>
<?php } ?>
    </table>
    <table class="headerTab">
        <tr>
            <th style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Doubli Machin Production Input By</th>
            <th></th>
            <th style="text-align: left; border-bottom: 1px solid #999999; padding-top: 20px;">Approved by</th>
        </tr>
        <?php
        $purchaseOrderByInfo = Employees::model()->findByPk(end($data)->doubli_producton_input_by);
        if ($purchaseOrderByInfo) {
            $purchaseOrderByName = $purchaseOrderByInfo->full_name;
            $purchaseOrderBydesignation = Designations::model()->infoOfThis($purchaseOrderByInfo->designation_id);
            $purchaseOrderBydepartment = Departments::model()->nameOfThis($purchaseOrderByInfo->department_id);
        } else {
            $purchaseOrderByName = "<font color='red'>Employee removed !</font>";
            $purchaseOrderBydesignation = "";
            $purchaseOrderBydepartment = "";
        }
        // print_r(end($data)->submitted_to);
        // exit;
        $approvedByInfo = Employees::model()->findByPk(end($data)->approved_by);
        if ($approvedByInfo) {

            $approveByName = $approvedByInfo->full_name;
            $approveBydesignation = Designations::model()->infoOfThis($approvedByInfo->designation_id);
            $approveBydepartment = Departments::model()->nameOfThis($approvedByInfo->department_id);
        } else {
            $approveByName = "<font color='red'>Employee removed !</font>";
            $approveBydesignation = "";
            $approveBydepartment = "";
        }
        ?>
        <tr>
            <td>Signature:</td>
            <td></td>
            <td>Signature:  </td>
        </tr>
        <tr>
            <td>Purchase Order By:<?php
       // echo $purchaseOrderByName;
////            //Users::model()->fullNameOfThis(end($data)->created_by); 
        ?></td>
            <td></td>
            <td>Approved By: <?php echo $approveByName; ?> </td>
        </tr>
        <tr>
            <td>Department:<?php //echo $purchaseOrderBydepartment; ?></td>
            <td></td>
            <td>Department:<?php echo $approveBydepartment; ?></td>
        </tr>
        <tr>
            <td>Designation:<?php// echo $purchaseOrderBydesignation; ?></td>
            <td></td>
            <td>Designation:<?php echo $approveBydesignation; ?></td>
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