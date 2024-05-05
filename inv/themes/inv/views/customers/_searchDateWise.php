<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/report.css" type="text/css" media="screen" />
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customers-form',
            'action' => Yii::app()->createUrl('/customers/partyLedgerViewDateWise'),
        ));
?>

<fieldset>
    <legend>Search Conditions</legend>
    <table class="summaryTab">
        <tr>
            <td colspan="3">Options</td>
        </tr>
        <tr>
            <td><?php echo $form->label($model, 'startDate'); ?></td>
            <td><?php echo $form->label($model, 'endDate'); ?></td>
            <td><?php echo $form->label($model, 'id'); ?></td>
        </tr>
        <tr>
            <td>
                 <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model,
                        'attribute' => 'startDate',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                            'id' => 'dateFrom',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
            </td>
            <td>
                <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                        'model' => $model,
                        'attribute' => 'endDate',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                            'id' => 'dateTo',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
            </td>    
             <td>
                <?php
                echo $form->dropDownList(
                        $model, 'id', CHtml::listData(Customers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'), array(
                    'prompt' => 'Select',
                ));
                ?>
            </td>
        </tr>          
        <tr style="border: none;">
            <td colspan="3" style="text-align: left; border: none;">
                <?php
echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('customers/partyLedgerViewDateWise', 'render' => true)), array(
    'dataType' => 'json',
    'type' => 'post',
    'success' => 'function(data) {
                    $("#ajaxLoader").hide(); 
                    $("#resultDiv").html(data.content);
                }',
    'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
                if($("#Customers_startDate").val()=="" || $("#Customers_endDate").val()=="" || $("#Customers_id").val()==""){
                    alertify.alert("Warning! Please select a Customer, Start Date & End Date!");
                    
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


