<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('basic-sheet-req-dr-grid', {
		data: $(this).serialize()
	});
	return false;
});
$('.deleteall-button').click(function(){
        var atLeastOneIsChecked = $('input[name=\"basic-sheet-req-dr-grid_c0[]\"]:checked').length > 0;
        if (!atLeastOneIsChecked){
                alertify.alert('Please select atleast one record to delete');
        }else if(window.confirm('Are you sure you want to delete the selected records ?')){
                document.getElementById('basick-sheet-req-dr-search-form').action='deleteall';
                document.getElementById('basick-sheet-req-dr-search-form').submit();
        }
});
");
?>
<?php
if (Yii::app()->user->hasFlash('error')) {
    echo '<div class="flash-error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>
<fieldset style="float: left; width: 98%;">
    <legend>Approve Store Requisition Deliveries</legend>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'basick-sheet-req-dr-search-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
            ));
    ?>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'basic-sheet-req-dr-grid',
        'dataProvider' => $model->searchApprove(),
        'mergeColumns' => array('req_no', 'req_id'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        //'selectableRows' => 2,
        'columns' => array(
//            array(
//                'value' => '$data->id',
//                'class' => 'CCheckBoxColumn',
//            ),
            'req_no',
            array(
                'name' => 'req_id',
                'value' => 'BasickSheetRequisition::model()->itemOfThis($data->req_id)',
                'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            'd_date',
            'd_qty',
            array(
                'name' => 'is_approved',
                'value' => 'BasickSheetReqDR::model()->isApproved($data->is_approved)',
                'filter' => array(1 => "Approved", 0 => "Pending"),
            ),
            array(
                'name' => 'approved_by',
                'value' => 'CHtml::encode(Users::model()->fullNameOfThis($data->approved_by))',
                'filter' => CHtml::listData(Employees::model()->findAll(array("order" => "full_name ASC")), "id", "full_name"),
            ),
            'approved_time',
            array(
                'name' => 'req_no',
                'header' => 'Approve',
                'value' => 'BasickSheetReqDR::model()->approveAll($data->req_no)',
                'filter' => '',
            ),
        )
    ));
    ?>
    <?php
    $condition = "is_approved!=1 GROUP BY req_no";
    $poData = BasickSheetReqDR::model()->findAll(array('condition' => $condition,), 'id');
    if ($poData) {
        foreach ($poData as $pod):
            $sl_no = $pod->req_no;
            echo '<script type="text/javascript">';
            echo 'function allApprove' . $sl_no . '(){';
            echo CHtml::ajax(array(
                'url' => array('basickSheetReqDR/allApprove', 'sl_no' => $sl_no),
                'data' => 'js:$(this).serialize()',
                'type' => 'post',
                'dataType' => 'json',
                'beforeSend' => "function(){
                    $('.ajaxLoaderViewApproveAll').show();
                }",
                'complete' => "function(){
                    $('.ajaxLoaderViewApproveAll').hide();
                }",
                'success' => "function(data){
                    if (data.status == 'failure'){
                        $.fn.yiiGridView.update('basic-sheet-req-dr-grid');
                        $('#approveAll-dialog div.approveAll-dialog-content').html(data.content);
                        $('#approveAll-dialog div.approveAll-dialog-content form').submit(allApprove" . $sl_no . ");
                    }else{
                        $.fn.yiiGridView.update('basic-sheet-req-dr-grid');
                        $('#approveAll-dialog div.approveAll-dialog-content').html(data.content);
                        setTimeout(\"$('#approveAll-dialog').dialog('close') \",1000);
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
        'id' => 'approveAll-dialog',
        'options' => array(
            'title' => 'Approve Items',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1240,
            'resizable' => false,
        ),
    ));
    ?>
    <div id="ajaxLoaderViewApproveAll" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>

    <div class="approveAll-dialog-content"></div>
    <?php $this->endWidget(); ?>
    <?php $this->endWidget(); ?>

</fieldset>
