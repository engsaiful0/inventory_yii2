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
<fieldset style="float: left; width: 98%;">
    <legend>Print Bill</legend>
    <table>
        <tr>
            <td>
                <label>Bill No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('customerBill/billPreview'), array(
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
                    'href' => Yii::app()->createUrl('customerBill/billPreview'),
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
        'title' => 'Bill Preview',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id='AjFlashReportSo' class="" style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<fieldset style="float: left; width: 98%;">
    <legend>Create Credit Memo for Bills</legend>
    <?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'customer-bill-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'sl_no',
            array(
                'name' => 'sl_no',
                'header'=>'Bill Date',
                'value' => '$data->bill_date',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header'=>'Due Date',
                'value' => '$data->due_date',
                'filter' => '',
            ),
            array(
                'name' => 'sl_no',
                'header'=>'Customer',
                'value' => 'Customers::model()->customerName($data->customer_id)',
                'filter' => '',
            ),
            'challan_no',
            array(
                'name' => 'sl_no',
                'header'=>'Payment Details',
                'value' => 'CustomerBill::model()->paymentInfo($data->sl_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
</fieldset>
<?php
    $criteria=new CDbCriteria();
    $criteria->select="sl_no";
    $criteria->group="sl_no";
    $soData = CustomerBill::model()->findAll($criteria);
    if($soData){
        foreach ($soData as $sod):
                $sl_no = $sod->sl_no;
                echo '<script type="text/javascript">';
                echo 'function allDeliver' . $sl_no . '(){';
                echo CHtml::ajax(array(
                    'url' => array('creditMemo/create', 'sl_no' => $sl_no),
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
                            $.fn.yiiGridView.update('customer-bill-grid');
                            $('#deliverAll-dialog div.deliverAll-dialog-content').html(data.content);
                            $('#deliverAll-dialog div.deliverAll-dialog-content form').submit(allDeliver" . $sl_no . ");
                        }else{
                            $.fn.yiiGridView.update('customer-bill-grid');
                            $('#deliverAll-dialog div.deliverAll-dialog-content').html(data.content);
                            //setTimeout(\"$('#deliverAll-dialog').dialog('close') \",1000);
                        }
                    }",
                ));
                echo ';';
                echo 'return false;';
                echo '}';
                echo '</script>';
        endforeach;
    }
    ?>
    <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'deliverAll-dialog',
    'options' => array(
        'title' => 'Create Credit Memo',
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

