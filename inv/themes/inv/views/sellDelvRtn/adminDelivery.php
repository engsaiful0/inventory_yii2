<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sale-order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Sale Order</legend>
    <table>
        <tr>
            <td>
                <label>SO No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('saleOrder/soPreview'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       $('#ajaxLoaderReport').show();
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                                           $('#ajaxLoaderReport').hide(); 
                    }",
                    'data' => array('sl_no' => 'js:jQuery("#soForReport").val()')
                        ), array(
                    'href' => Yii::app()->createUrl('saleOrder/soPreview'),
                    'class' => 'additionalBtn'
                        )
                );
                ?>
                <span id="ajaxLoaderReport" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            </td>
        </tr>
    </table>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'Sale Order Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<fieldset style="float: left; width: 98%;">
    <legend>Deliver Items</legend>
    <?php
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'sale-order-grid',
        'dataProvider' => $model->searchForDelivery(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'sl_no',
            'issue_date',
            'expected_d_date',
            array(
                'name' => 'store',
                'value' => 'Stores::model()->storeName($data->store)',
                'filter' => CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'),
            ),
            array(
                'name' => 'customer_id',
                'value' => 'Customers::model()->customerName($data->customer_id)',
                'filter' => CHtml::listData(Customers::model()->findAll(array('order' => 'company_name ASC')), 'id', 'company_name'),
            ),
            array(
                'name' => 'order_type2',
                'value' => 'Lookup::item("order_type2", $data->order_type2)',
                'filter' => Lookup::items("order_type2"),
            ),
            'pi_no',
            'pi_date',
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"),
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'qty',
             array(
                'name' => 'conv_unit',
                'value' => 'Items::model()->convertedUnitText($data->conv_unit, $data->item, $data->qty)',
                'filter' => array('1'=>'SFT', '2'=>'RFT', '3'=>'CFT', '4'=>'SQM'),
            ),
            'price',
            array(
                'name' => 'sales_by',
                'value' => 'Employees::model()->fullName($data->sales_by)',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            array(
                'name' => 'id',
                'header' => 'Remaining Deliverable Qty',
                'value' => '$data->qty-SellDelvRtn::model()->availableQtyOfThisSellOrderId($data->id)',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Delivery',
                'value' => 'SellDelvRtn::model()->deliverAll($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php
    $condition = "issue_date!='0000-00-00' GROUP BY sl_no";
    $soData = SaleOrder::model()->findAll(array('condition' => $condition,), 'id');
    if ($soData) {
        foreach ($soData as $sod):
            //$remainingQty=$sod->qty-  SellDelvRtn::model()->availableQtyOfThisSellOrderId($sod->id);
            //if($remainingQty>0){
            $sl_no = $sod->sl_no;
            echo '<script type="text/javascript">';
            echo 'function allDeliver' . $sl_no . '(){';
            echo CHtml::ajax(array(
                'url' => array('sellDelvRtn/allDeliver', 'sl_no' => $sl_no),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                        $('.ajaxLoaderViewDeliverAll').show();
                    }",
                'complete' => "function(){
                        $('.ajaxLoaderViewDeliverAll').hide();
                    }",
                'success' => "function(data){
                        if (data.status == 'failure'){
                            $.fn.yiiGridView.update('sale-order-grid');
                            $('#deliverAll-dialog div.deliverAll-dialog-content').html(data.content);
                            $('#deliverAll-dialog div.deliverAll-dialog-content form').submit(allDeliver" . $sl_no . ");
                        }else{
                            $.fn.yiiGridView.update('sale-order-grid');
                            $('#deliverAll-dialog div.deliverAll-dialog-content').html(data.content);
                            //setTimeout(\"$('#deliverAll-dialog').dialog('close') \",1000);
                        }
                    }",
            ));
            echo ';';
            echo 'return false;';
            echo '}';
            echo '</script>';
        //}
        endforeach;
    }
    ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'deliverAll-dialog',
        'options' => array(
            'title' => 'Deliver Items',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1240,
            'resizable' => false,
        ),
    ));
    ?>
    <div id="ajaxLoaderViewDeliverAll" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>

    <div class="deliverAll-dialog-content"></div>
    <?php $this->endWidget(); ?>
</fieldset>

