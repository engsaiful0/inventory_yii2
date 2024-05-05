<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('customer-bill-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gridview/styles.css" type="text/css" media="screen" />
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-bill-form',
            'action' => Yii::app()->createUrl('/customerBill/billCreateView'),
        ));
?>
<fieldset>
    <legend>Search Challan Numbers To Create Bill</legend>
    <div class="grid-view" style="float: left; width: 100%;">
        <table class="items">
            <tr>
                <td><?php echo $form->labelEx($model, 'customer_id'); ?></td>
                <td>
                    <?php
                        echo $form->dropDownList(
                                $model, 'customer_id', CHtml::listData(Customers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'), array(
                            'prompt' => 'Select',
                        ));
                        ?>
                </td>
            </tr>

            <tr style="border: none;">
                <td colspan="2" style="text-align: left; border: none;">
                    <?php
                    echo CHtml::ajaxSubmitButton('Search', CHtml::normalizeUrl(array('customerBill/billCreateView', 'render' => true)), array(
                        'dataType' => 'json',
                        'type' => 'post',
                        'success' => 'function(data) {
                            $("#ajaxLoader").hide(); 
                            $("#resultDiv").html(data.content);
                        }',
                        'beforeSend' => 'function(){     
                            if($("#CustomerBill_customer_id").val()==""){
                                alertify.alert("Please select a customer !");
                                return false;
                            }else{
                                $("#ajaxLoader").show();
                            }
                 }',
                    ));
                    ?>
                </td>
            </tr>
        </table>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
<fieldset style="float: left; width: 98%;">
    <legend>Challan List <span style=" float: right; margin-left: 8px;"><div id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div><span></legend>
    <div id="resultDiv">

    </div>
</fieldset>
