<style>
    @font-face {
        font-family: AGENCYR;
        src: url(<?php echo Yii::app()->theme->baseUrl; ?>/pos/font/AGENCYR.ttf);
    }
    table.poReportTab{
        float: left;
        border-collapse: collapse;
        font-family: AGENCYR;
        font-size: 14px;
        color: #000000;
    }
    table.poReportTab th{
        padding: 10px 0px;
        text-align: center;
    }
    table.poReportTab td{
        padding: 4px 2px;
        text-align: center;
    }
</style>
<?php
if ($data) {
    $yourCompanyInfo = YourCompany::model()->findByAttributes(array('is_active' => YourCompany::ACTIVE,));
    if ($yourCompanyInfo) {
        $yourCompanyName = $yourCompanyInfo->company_name;
        $yourCompanyVatRegNo = $yourCompanyInfo->vat_regi_no;
        $yourCompanyLocation = $yourCompanyInfo->location;
        $yourCompanyContact = $yourCompanyInfo->contact;
        $yourCompanyEmail = $yourCompanyInfo->email;
        $yourCompanyWeb = $yourCompanyInfo->web;
        $yourCompanyVat=$yourCompanyInfo->vat_amount;
    } else {
        $yourCompanyName = '';
        $yourCompanyVatRegNo = '';
        $yourCompanyLocation = '';
        $yourCompanyContact = '';
        $yourCompanyEmail = '';
        $yourCompanyWeb = '';
        $yourCompanyVat='';
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
    <script>
        var printCount=1;
        $("#print-div").click(function(){
            if(printCount%2==0){
                $("#invTitle").html("Marchent Copy");
            }else{
                $("#invTitle").html("Customer Copy");
            }
            printCount++;
        })
    </script>
    <div class='printAllTableForThisReport' style="float: left;">
        <table class="poReportTab" id="customerCopy">
            <tr>
                <td colspan="5"><span id="invTitle">Customer Copy</span></td>
            </tr>
            <tr>
                <td colspan="5" style="padding-bottom: 10px;">
                    <?php
                    if (!empty($yourCompanyName))
                        echo "<font style='font-size: 18px;'>" . $yourCompanyName . "</font><br>";
                    echo Stores::model()->storeNameAndAddr(end($data)->store_id);
//                    if (!empty($yourCompanyLocation))
//                        echo $yourCompanyLocation;
//                    if (!empty($yourCompanyContact))
//                        echo '<br>Phone: ' . $yourCompanyContact;
                    if (!empty($yourCompanyEmail))
                        echo '<br>' . $yourCompanyEmail;
                    if (!empty($yourCompanyWeb))
                        echo ' ' . $yourCompanyWeb;
                    if (!empty($yourCompanyVatRegNo))
                        echo '<br>VAT REG.NO: ' . $yourCompanyVatRegNo;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; border-top: 1px dotted #000000;">
                    Cashier: <?php echo Users::model()->fullNameOfThisOnlyName(end($data)->initiated_by); ?>
                </td>
                <td style="text-align: right; border-top: 1px dotted #000000;">
                    Terminal: <?php echo MachineNames::model()->onlyNameOfThis(end($data)->machine_id); ?>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left; border-bottom: 1px dotted #000000;">
                    <span style="float: left;">
                        <?php
                        echo "Invoice No:" . end($data)->inv_no;
                        if (end($data)->is_void == Pos::YES) {
                            echo " <font style='color: red; font-weight: bold;'>VOID</font>";
                        }
                        ?>
                    </span>
                    <span style="float: right;">Date: <?php echo end($data)->date . " " . end($data)->time; ?></span>
                </td>
            </tr>
            <tr>
                <td style="border-bottom: 1px dotted #000000;">SL</td>
                <td style="border-bottom: 1px dotted #000000; text-align: left;">Item Description</td>
                <td style="border-bottom: 1px dotted #000000;">MRP</td>
                <td style="border-bottom: 1px dotted #000000;">Qty</td>
                <td style="text-align: right; border-bottom: 1px dotted #000000;">Total</td>
            </tr>
            <?php
            $i = 1;
            $grossTotalVat = 0;
            $grandTotal = 0;
            $grandTotalWithoutVat = 0;
            ?>
            <?php foreach ($data as $d): ?>
                <tr class="<?php
        if ($i % 2 == 0) {
            echo 'even';
        } else {
            echo 'odd';
        }
                ?>">
                    <td><?php echo $i++; ?>.</td>
                    <?php
                    $itemInfo = Items::model()->findByPk($d->item_id);
                    $itemName = "<font color='red'>Removed!</font>";
                    $isVatableItem = 0;
                    if ($itemInfo) {
                        $itemName = $itemInfo->name;
                        $itemDesc = $itemInfo->desc;
                        $isVatableItem = $itemInfo->vatable;
                        $itemCat = Cats::model()->nameOfThis($itemInfo->cat);
                        $itemCatSub = CatsSub::model()->nameOfThis($itemInfo->cat_sub);
                    } else {
                        $itemName = "";
                        $itemDesc = "";
                        $isVatableItem = "";
                        $itemCat = "";
                        $itemCatSub = "";
                    }
                    ?>
                    <td style="text-align: left;">
                        <?php
                        echo $itemName;
                        if ($itemDesc != "")
                            echo "<br>" . $itemDesc;
                        //echo "<br>".$itemCatSub." - ".$itemCat;
                        ?>
                    </td>
                    <?php
                    $price = ($d->price);
                    ?>
                    <td><?php echo number_format(floatval($price), 2); ?></td>
                    <td><?php echo number_format(floatval($d->qty), 3); ?></td>
                    <td style="text-align: right;">
                        <?php
                        $lineTotal = ($d->qty * $price);
                        $lineTotalWithoutVat = ($d->qty * $price);

                        $lineTotalVat = 0;
                        if ($isVatableItem == 1) {
                            $vat = ($yourCompanyVat/100);
                            $lineTotalVat = ($lineTotal * $vat);
                            $lineTotal = $lineTotal + ($lineTotal * $vat);
                        }
                        $grossTotalVat = $grossTotalVat + $lineTotalVat;

                        echo number_format(floatval($lineTotalWithoutVat), 2);
                        $grandTotal = $lineTotal + $grandTotal;
                        $grandTotalWithoutVat = $lineTotalWithoutVat + $grandTotalWithoutVat;
                        ?>
                    </td>
                </tr>
    <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align: right; border-top: 1px dotted #000000;">Sub Total: </td>
                <td style="text-align: right; border-top: 1px dotted #000000;"><?php echo number_format(floatval($grandTotalWithoutVat), 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;">(+) VAT: </td>
                <td style="text-align: right;"><?php echo number_format(floatval($grossTotalVat), 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;"><?php echo number_format(floatval($grossTotalVat), 2); ?> Taxable Sales: </td>
                <td style="text-align: right;"><?php echo number_format(floatval($grandTotal), 2); ?></td>
            </tr>
            <?php
            if (end($data)->overall_discount)
                $overallDiscount = end($data)->overall_discount;
            else
                $overallDiscount=0;

            $discountType = "";
             if (end($data)->discount_type == 0) {
                $discountType = "(Amount)";
                $grandTotal = $grandTotal - $overallDiscount;
                $grandTotalWithoutVat = $grandTotalWithoutVat - $overallDiscount;
            } else {
                $discountType = "(%)";
                $overallDiscountPerc = $overallDiscount / 100;
                $grandTotal = ($grandTotal - ($grandTotal*$overallDiscountPerc));
                $grandTotalWithoutVat = ($grandTotalWithoutVat - ($grandTotalWithoutVat*$overallDiscountPerc));
            }
            ?>
            <tr>
                <td colspan="4" style="text-align: right;">(-) Discount <?php echo $discountType; ?>: </td>
                <td style="text-align: right;">
                    <?php
                    echo number_format(floatval($overallDiscount), 2);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; border-bottom: 1px dotted #000000;">Net Payable: </td>
                <td style="text-align: right; border-bottom: 1px dotted #000000;"><?php echo number_format(floatval($grandTotal), 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; border-bottom: 1px dotted #000000;">Payment: </td>
                <td style="border-bottom: 1px dotted #000000;"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;">
                    <?php
                    if (end($data)->cash_payment != 0)
                        echo "CASH: <br>";
                    if (end($data)->visa_payment != 0)
                        echo "VISA: <br>";
                    if (end($data)->master_payment != 0)
                        echo "MASTER: <br>";
                    if (end($data)->amex_payment != 0)
                        echo "AMEX: <br>";
                    if (end($data)->gift_card_payment != 0)
                        echo "GIFT CARD:";
                    ?>
                </td>
                <td style="text-align: right;">
                    <?php
                    if (end($data)->cash_payment != 0)
                        echo number_format(floatval(end($data)->cash_payment), 2) . "<br>";
                    if (end($data)->visa_payment != 0)
                        echo number_format(floatval(end($data)->visa_payment), 2) . "<br>";
                    if (end($data)->master_payment != 0)
                        echo number_format(floatval(end($data)->master_payment), 2) . "<br>";
                    if (end($data)->amex_payment != 0)
                        echo number_format(floatval(end($data)->amex_payment), 2) . "<br>";
                    if (end($data)->gift_card_payment != 0)
                        echo number_format(floatval(end($data)->gift_card_payment), 2);
                    $cashPaid = end($data)->cash_payment + end($data)->visa_payment + end($data)->master_payment + end($data)->amex_payment + end($data)->gift_card_payment;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right; border-top: 1px dotted #000000;">TOTAL PAID: </td>
                <td style="text-align: right; border-top: 1px dotted #000000;"><?php echo number_format(floatval($cashPaid), 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;">RETURN AMOUNT: </td>
                <td style="text-align: right;"><?php echo number_format(floatval(end($data)->cash_return), 2); ?></td>
            </tr>
            <tr>
                <td colspan="5" style="border-top: 1px dotted #000000; padding-top: 10px; padding-bottom: 10px; text-align: left;">
                    <?php
                    if ($memberName != "") {
                        echo "Thank you Mr." . $memberName;
                        echo "<br>Points for this shopping: " . $pointOfThisSale;
                        echo "<br>Total points: " . $memberAVPoint;
                    } else {
                        echo "Thanks for shopping at " . $yourCompanyName;
                    }
                    if (!empty($yourCompanyContact))
                        echo '<br>For any query, Please call: ' . $yourCompanyContact;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left;"><?php echo "Developed by " . Yii::app()->params->developedBy; ?></td>
            </tr>
        </table>
        <?php
    } else {
        echo "<div class='flash-error'>No result found !</div>";
    }
    ?>
</div>