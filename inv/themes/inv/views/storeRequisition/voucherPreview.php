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
    <div class="grid-view">
        <table class="headerTab">
            <tr>
                <th colspan="2" style="text-align: center; padding-bottom: 10px;"><?php echo YourCompany::model()->activeInfo(); ?></th>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center; text-decoration: underline; padding-bottom: 30px;">STORE REQUISITION FORM</th>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"><b>Requisition No: </b><?php echo end($data)->sl_no; ?></td>
                <td style="text-align: right; padding-bottom: 10px;"><b>Date: </b><?php echo end($data)->created_time; ?></td>
            </tr>
            <tr>
                <th colspan="2" style="text-align: left; padding-bottom: 10px;">Following items are required as shown against each for department: <i><?php echo Departments::model()->nameOfThis(end($data)->department); ?></i>, to store: <i><?php echo Stores::model()->storeName(end($data)->store); ?> from store: <i><?php echo Stores::model()->storeName(end($data)->from_store); ?></i></th>
            </tr>
            <tr>
                <th colspan="2" style="text-align: left; padding-bottom: 10px;"><?php if (end($data)->remarks != "")
    echo end($data)->remarks;
?></th>
            </tr>
        </table>
        <table class="reportTab">
            <tr>
                <th style="width: 32px;">SL</th>
                <th>Item</th>
                <th>No Of Sacks</th>
                <th>Weight/Sack</th>
                <th>Total Quantity</th>
            </tr>
            <?php
            $i = 1;
            $total = 0;
            ?>
            <?php foreach ($data as $d) { ?>
                <tr class="<?php
                    if ($i % 2 == 0)
                        echo 'odd';
                    else
                        echo 'even';
                    ?>">
                    <td><?php echo $i++; ?></td>
                    <td style="text-align: left;"><?php Items::model()->item($d->item); ?></td>
                    <td style="text-align: center;"><?php echo $d->noOfSack ?></td>
                    <td style="text-align: center;"><?php echo $d->weghtPerSack  ?></td>
                    <td><?php echo $d->qty; ?></td>
                </tr>
<?php } ?>
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
                    $approvedByInfo=  Employees::model()->findByPk(end($data)->approve_by);
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