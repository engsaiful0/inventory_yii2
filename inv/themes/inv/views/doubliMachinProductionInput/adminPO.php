<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchase-procurement-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Print Doubli Machin Input</legend>
    <table>
        <tr>
            <td>
                <label>Doubli Machin Input No</label>
            </td>
            <td>
                <input type="text" name="soForReport" id="soForReport"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('doubliMachinProductionInput/doubliMachinProductionInputPreview'), array(
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
                    'href' => Yii::app()->createUrl('doubliMachinProductionInput/doubliMachinProductionInputPreview'),
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
        'title' => 'Doubli Machin Production Input Preview',
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
    <legend>Doubli Machine Production Input</legend>
    <?php
    if (Yii::app()->user->hasFlash('error')) {
        echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
    }
    ?>
    <?php
    echo CHtml::link('Make Doubli Machine Production Input for the selected items', "", // the link for open the dialog
            array(
        'class' => 'additionalBtn',
        'onclick' => "{transferAll();}"));
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'purchase-procurement-search-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'purchase-procurement-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('sl_no'),
        'filter' => $model,
        'selectableRows' => 2,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'value' => '$data->id',
                'class' => 'CCheckBoxColumn',
            ),
            'sl_no',
            'date',
            array(
                'name' => 'item',
                'value' => 'Items::model()->item($data->item)',
                'filter' => CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"),
                'htmlOptions' => array('style' => 'text-align: left;')
            ),
            'length',
            'width',
            'thickness',
            array(
                'name' => 'unit_of_distance',
                'value' => 'CHtml::encode(UnitDistance::model()->unit_of_distanceOfThis($data->unit_of_distance))',
                'filter' => CHtml::listData(UnitDistance::model()->findAll(array("order" => "unit_of_distance ASC")), "id", "unit_of_distance"),
            ),
            'qty',
            'qty_kg',
        )
    ));
    ?>
    <?php $this->endWidget(); ?>
</fieldset>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTransferSelected',
        'options' => array(
            'title' => 'Purchase Order Form',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1030,
            'resizable' => false,
        ),
    ));
    ?>
<div class="divForForm"></div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function transferAll() {

        var atLeastOneIsChecked = $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked) {
            alertify.alert('Please select atleast one item to create PO');
        } else {
            var selectedArr = new Array();

            $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').each(function () { //loop through each checkbox
                if (this.checked) {
                    //alert($(this).val());
                    selectedArr.push($(this).val());
                }
            });

            $('#dialogTransferSelected').dialog('destroy');
            $('#dialogTransferSelected').dialog({autoOpen: false, resizable: false, title: 'Doubli Machin Production Input', width: 'auto', modal: true});
            $('#dialogTransferSelected').dialog('open');
<?php
echo CHtml::ajax(array(
    'url' => array('doubliMachinProductionInput/createFromSelected'),
    'data' => "js:{'selectedArr':''+selectedArr+''}",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $.fn.yiiGridView.update('purchase-procurement-grid', {
                                data: $(this).serialize()
                            });
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                }",
));
?>;
        }


        return false;
    }

    function transferAllAgain() {
        var atLeastOneIsChecked = $('input[name=\"purchase-procurement-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked) {
            alertify.alert('Please select atleast one item to create PO');
        } else {
            var dataString = '';

<?php
echo CHtml::ajax(array(
    'url' => array('doubliMachinProductionInput/createFromSelected'),
    'data' => "js:dataString+$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').show();
                    }",
    'complete' => "function(){
                        $('.ajaxLoaderFormLoadPurchReq').hide();
                    }",
    'success' => "function(data){
                        if (data.status == 'failure')
                        {
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                            $('#dialogTransferSelected div.divForForm form').submit(transferAllAgain);
                        }
                        else
                        {
                            $.fn.yiiGridView.update('purchase-procurement-grid', {
                                data: $(this).serialize()
                            });
                            $('#dialogTransferSelected div.divForForm').html(data.content);
                        }
                                                                                    }",
));
?>;
        }
        return false;
    }

</script> 
