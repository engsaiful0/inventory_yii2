<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Purchase Order</legend>
    <table>
        <tr>
            <td>
                <label>PO No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('purchaseOrder/requisitionPreview'), array(
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
                    'href' => Yii::app()->createUrl('purchaseOrder/requi'
                            . 'sitionPreview'),
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
        'title' => 'Purchase Order Preview',
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
    <legend>Manage Purchase Orders</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-order-grid',
        'dataProvider' => $model->searchForPORcv(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'sl_no',
            'ref_no',
            'issue_date',
            array(
                'name' => 'procurement_id',
                'value' => 'PurchaseProcurement::model()->itemOfThis($data->procurement_id)',
                'filter' => '',
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'order_qty',
              array(
                'name' => 'name_of_unit',
                'value' => 'Units::model()->name_of_unitOfThis($data->name_of_unit)',
                'filter' => CHtml::listData(Units::model()->findAll(array('order'=>'name_of_unit ASC')), 'id', 'name_of_unit'),
            ),
            array(
                'name' => 'id',
                'header' => 'Remaining Receivable Qty',
                'value' => '($data->order_qty-PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($data->id))',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header' => 'Receive',
                'value' => 'PurchaseRcvRtn::model()->receiveAll($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php
    $condition = "issue_date!='0000-00-00' GROUP BY sl_no";
    $poData = PurchaseOrder::model()->findAll(array('condition' => $condition,), 'id');
    if($poData){
        foreach ($poData as $pod):
            //$remainingQty=$pod->order_qty-PurchaseRcvRtn::model()->availableQtyOfThisPurchaseId($pod->id);
            //if($remainingQty>0){
                $sl_no = $pod->sl_no;
                echo '<script type="text/javascript">';
                echo 'function allReceive' . $sl_no . '(){';
                echo CHtml::ajax(array(
                    'url' => array('purchaseRcvRtn/allReceive', 'sl_no' => $sl_no),
                    'data' => 'js:$(this).serialize()',
                    'type' => 'post',
                    'dataType' => 'json',
                    'beforeSend' => "function(){
                        $('.ajaxLoaderViewReceiveAll').show();
                    }",
                    'complete' => "function(){
                        $('.ajaxLoaderViewReceiveAll').hide();
                    }",
                    'success' => "function(data){
                        if (data.status == 'failure'){
                            $.fn.yiiGridView.update('purchase-order-grid');
                            $('#receiveAll-dialog div.receiveAll-dialog-content').html(data.content);
                            $('#receiveAll-dialog div.receiveAll-dialog-content form').submit(allReceive" . $sl_no . ");
                        }else{
                            $.fn.yiiGridView.update('purchase-order-grid');
                            $('#receiveAll-dialog div.receiveAll-dialog-content').html(data.content);
                          //  setTimeout(\"$('#receiveAll-dialog').dialog('close') \",1000);
                                                                              
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
    'id' => 'receiveAll-dialog',
    'options' => array(
        'title' => 'Receive Items',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1240,
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderViewReceiveAll" style="display: none;">
    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" />
</div>

<div class="receiveAll-dialog-content"></div>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'receiveReturn-dialog',
    'options' => array(
        'title' => 'Receive Due',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1240,
        'resizable' => false,
    ),
));
?>


<div id='AjFlashReportReceiveReturnSo' class="" style="display:none;"></div>
<?php $this->endWidget(); ?>
</fieldset>
