<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('customers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset style="float: left; width: 98%;">
    <legend>Customer's Money Receipts</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'customers-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'id_no',
            'company_name',
            array(
                'name' => 'id_no',
                'header'=>'Transaction Details',
                'value' => 'Customers::model()->transactionInfo($data->id)',
                'filter' => '',
                'htmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
            ),
            array(
                'header' => 'Options',
                'template' => '{moneyReceiptHistory}{addMoneyReceipt}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'moneyReceiptHistory' => array(
                         'label'=>'Money Receipt History',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/history.ico',
                        'url' => 'Yii::app()->controller->createUrl("customerMr/moneyReceiptHistory",array("customer_id"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('customers-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('customers-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                    ),
                    'addMoneyReceipt' => array(
                        'label' => 'Create Money Receipt',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/reports.ico',
                        'url' => 'Yii::app()->controller->createUrl("customerMr/addMoneyReceipt",array("customer_id"=>$data->id))',
                        'click' => "function( e ){
                                e.preventDefault();
                                $( '#addMoneyReceipt-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                addMoneyReceiptDialog( $( this ).attr( 'href' ) );
                                $( '#addMoneyReceipt-dialog' )
                                  .dialog( { title: 'Money Receipt Form' } )
                                  .dialog( 'open' ); }",
                    ),
                )
            ),
        )
    ));
    ?>
</fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'viewDialog',
    'options' => array(
        'title' => 'Money Receipt History',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addMoneyReceipt-dialog',
    'options' => array(
        'title' => 'Create Money Receipt',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="addMoneyReceipt-dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$addMoneyReceiptJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#addMoneyReceipt-dialog div.addMoneyReceipt-dialog-content' ).html( data.content );
      $( '#addMoneyReceipt-dialog div.addMoneyReceipt-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addMoneyReceiptDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#addMoneyReceipt-dialog div.addMoneyReceipt-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      //setTimeout( \"$( '#addMoneyReceipt-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('addMoneyReceiptDialog', "
function addMoneyReceiptDialog( url, act )
{
  var action = '';
  var form = $( '#addMoneyReceipt-dialog div.addMoneyReceipt-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addMoneyReceiptJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addMoneyReceiptDialogCreate', "
jQuery( function($){
    $( 'a.addMoneyReceipt-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addMoneyReceipt-dialog' ).children( ':eq(0)' ).empty();
      addMoneyReceiptDialog( $( this ).attr( 'href' ) );
      $( '#addMoneyReceipt-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>
