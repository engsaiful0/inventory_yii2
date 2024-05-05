<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/pos/css/pos.css" type="text/css" media="screen" />
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="statusMsg"></div>

<fieldset style="float: left; width: 25%;">
    <legend>Print POS Invoice</legend>
    <table>
        <tr>
            <td style="text-align: right;">Invoice No</td>
            <td>
                <input type="text" name="soForReport" id="soForReport" class="numPadBtnInput"/>
            </td>
            <td>
                <?php
                echo CHtml::ajaxLink(
                        "Preview", Yii::app()->createUrl('pos/soReportOfThisNonPosUser'), array(
                    'type' => 'POST',
                    'beforeSend' => "function(){
                       document.getElementById('soForReport').style.background='url(" . Yii::app()->theme->baseUrl . "/images/ajax-loader.gif) no-repeat #FFFFFF 95% 5px';   
                     }",
                    'success' => "function( data ){
                        $('#soReportDialogBox').dialog('open'); 
                        $('#AjFlashReportSo').html(data).show();                                                                 
                    }",
                    'complete' => "function(){
                        document.getElementById('soForReport').style.background='#FFFFFF'; 
                    }",
                    'data' => array(
                        'so' => 'js:jQuery("#soForReport").val()'
                    )
                        ), array(
                    'href' => Yii::app()->createUrl('pos/soReportOfThis'),
                    'class' => 'additionalBtn',
                        )
                );
                ?>
            </td>    
        </tr>
        <tr>
        <div class="search-form" style="float: left; width: 100%;">
            <?php $this->renderPartial('_search', array('model' => $model)); ?>
        </div>
        </tr>
    </table>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'soReportDialogBox',
    'options' => array(
        'title' => 'POS Invoice Preview',
        'autoOpen' => false,
        'modal' => true,
        'resizable' => false,
        'position' => 'top',
        'width'=>'306px',
    ),
));
?>
<div id='AjFlashReportSo' style="display:none;"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<style>
    .ui-widget-header .ui-icon {
        float: right;
        background: url("<?php echo Yii::app()->theme->baseUrl; ?>/css/pos/images/close.png") center transparent no-repeat;
        width: 32px;
        height: 32px;
    }
    .ui-dialog .ui-dialog-titlebar-close{
        margin: -18px -5px 0px;
    }
</style>
<table class="numPadTab numPadTab2" style="width: 40%;">
    <tr>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn1" attrVl="1" value="1"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn2" attrVl="2" value="2"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn3" attrVl="3" value="3"/></td>
    </tr>
    <tr>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn4" attrVl="4" value="4"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn5" attrVl="5" value="5"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn6" attrVl="6" value="6"/></td>
    </tr>
    <tr>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn7" attrVl="7" value="7"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn8" attrVl="8" value="8"/></td>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn9" attrVl="9" value="9"/></td>
    </tr>
    <tr>
        <td><input type="button" class="numPadBtn soundBtn" id="numPadBtn0" attrVl="0" value="0"/></td>
		<td colspan="2"><input type="button" class="ersButton soundBtn" id="numPadBtnClr" attrVl="c" value="X"/></td>
    </tr>
</table>
<fieldset>
    <input type="button" class="main_menuBtn soundBtn" value="Close" onclick="closeMe();"/>
</fieldset>
<fieldset style="float: left; width: 98%;">
    <legend>Manage POS Transactions</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'pos-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('inv_no'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name' => 'inv_no',
                'value' => '$data->inv_no',
                'filter' => '',
            ),
            array(
                'name' => 'cash_card',
                'value' => 'Lookup::item("cash_card", $data->cash_card)',
                'filter' => Lookup::items('cash_card'),
            ),
            array(
                'name' => 'inv_no',
                'header' => 'Date/Time',
                'value' => '$data->date." / ".$data->time',
                'filter' => '',
            ),
            array(
                'name' => 'item_id',
                'value' => 'Items::model()->item($data->item_id)',
                'filter' => CHtml::listData(Items::model()->findAll(), 'id', 'name'),
               'htmlOptions'=>array('style'=>'text-align: left;')
            ),
            array(
                'name' => 'price',
                'filter' => '',
            ),
            array(
                'name' => 'qty',
                'filter' => '',
            ),
            array
                (
                'header' => 'Options',
                'template' => '{update}{delete}',
                'class' => 'CButtonColumn',
				'htmlOptions'=>array('style'=>'width: 130px;'),
                'buttons' => array(
                    'update' => array(
                        'imageUrl' => Yii::app()->theme->baseUrl . '/css/pos/images/editBtnPos.png',
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Informations' } )
                              .dialog( 'open' ); }",
                                ),
                        'delete' => array(
                        'imageUrl' => Yii::app()->theme->baseUrl . '/css/pos/images/deleteBtnPos.png',
                    ),
                )
            ),
        )
    ));
    ?>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Informations',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderUpdate" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div class="update-dialog-content">

</div>
<?php $this->endWidget(); ?>

<?php
$updateJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'beforeSend' => "function(){
        $('#ajaxLoaderUpdate').show();
}",
            'complete' => "function(){
        $('#ajaxLoaderUpdate').hide();
}",
            'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      $( '#update-dialog div.update-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          updateDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#update-dialog div.update-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // Update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
        });
      }
      setTimeout( \"$( '#update-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('updateDialog', "
function updateDialog( url, act )
{
  var action = '';
  var form = $( '#update-dialog div.update-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$updateJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('updateDialogCreate', "
jQuery( function($){
    $( 'a.update-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#update-dialog' ).children( ':eq(0)' ).empty();
      updateDialog( $( this ).attr( 'href' ) );
      $( '#update-dialog' )
        .dialog( { title: 'Update' } )
        .dialog( 'open' );
    });
});
");
?>
<style>
    .numPadBtnInput{
        height: 25px;
    }
    .numPadBtn{
        height: 40px;
    }
</style>
<script type="text/javascript">
    function closeMe(){
        window.opener = self;
        window.close();
    }
    $(document).ready(function(){
        $("input.numPadBtnInput").click(function(){
            focusedElem=$(this).attr("id");
        });
        $(".numPadBtn").click(function(e) {
            e.preventDefault();
            var numPadBtnVal=$(this).attr("attrVl");
            var focusedElemVal=$("#"+focusedElem);
            focusedElemVal.val(focusedElemVal.val() + numPadBtnVal + '');
        });
        
        $(".ersButton").click(function(e) {
            e.preventDefault();
            var focusedElemVal=$("#"+focusedElem);
            var oldVal=focusedElemVal.val();
            $reduceDval=focusedElemVal.val().slice(0, -1);
            focusedElemVal.val($reduceDval);
        }); 
    });
</script>