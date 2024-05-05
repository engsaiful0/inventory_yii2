<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen" />
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customers-form',
            'action' => Yii::app()->createUrl('/customers/partyLedgerView'),
        ));
?>

<fieldset>
    <legend>Search Conditions</legend>
    <table class="poReportTabUpper">
        <tr>
            <td colspan="7">Options</td>
        </tr>
        <tr>
            <td><?php echo $form->label($model, 'month'); ?></td>
            <td><?php echo $form->label($model, 'year'); ?></td>
            <td><?php echo $form->label($model, 'id'); ?></td>
        </tr>
        <tr>
            <td>
                <?php
                    echo $form->dropDownList(
                            $model, 'month', CHtml::listData(Months::model()->findAll(array('order' => 'id ASC')), 'id', 'month_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
            </td>
            <td>
                <?php
                    echo $form->dropDownList(
                            $model, 'year', CHtml::listData(Years::model()->findAll(array('order' => 'id ASC')), 'year_name', 'year_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
            </td>    
             <td>
                <?php
                echo $form->dropDownList(
                        $model, 'id', CHtml::listData(Customers::model()->findAll(), 'id', 'company_name'), array(
                    'prompt' => 'Select',
                ));
                ?>
            </td>
        </tr>          
        <tr style="border: none;">
            <td colspan="9" style="text-align: left; border: none;">
                <?php
echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('customers/partyLedgerView', 'render' => true)), array(
    'dataType' => 'json',
    'type' => 'post',
    'success' => 'function(data) {
                    $("#ajaxLoader").hide(); 
                    $("#resultDiv").html(data.content);
                }',
    'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
                if($("#Customers_month").val()=="" || $("#Customers_year").val()=="" || $("#Customers_id").val()==""){
                    alertify.alert("Warning! Please select a Customer, Month & Year!");
                    
                }
             }',
));
?>
                <?php //echo CHtml::submitButton('Search', array('id' => 'isStoreEmpty')); ?>
            </td>
        </tr>
    </table>
</fieldset>

<?php $this->endWidget(); ?>


