<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('master-lc-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if ($model->isNewRecord) { ?>
    <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
<?php } else { ?>
    <?php echo $this->renderPartial('_form2', array('model' => $model)); ?>
<?php } ?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Master LC(s)</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'master-lc-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('id'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name'=>'supplier_id',
                'value'=>'CHtml::encode(Suppliers::model()->supplierName($data->supplier_id))',
                'filter'=>CHtml::listData(Suppliers::model()->findAll(array('order' => 'id DESC')), "id", "company_name"),
            ),
            'lc_no',
            'shipment_date',
            'expire_date',
            'lc_date',
            array(
                'name'=>'lc_tenor_id',
                'value'=>'CHtml::encode(Tenors::model()->nameOfThis($data->lc_tenor_id))',
                'filter'=>CHtml::listData(Tenors::model()->findAll(array('order' => 'id DESC')), "id", "title"),
            ),
            'export_lc_no',
            array(
                'name'=>'bank_id',
                'value'=>'CHtml::encode(Banks::model()->nameOfThis($data->bank_id))',
                'filter'=>CHtml::listData(Banks::model()->findAll(array('order' => 'id DESC')), "id", "bank_name"),
            ),
            'po_no',
            array
                (
                'header' => 'Options',
                'template' => '{view}{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'view' => array(
                        'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('master-lc-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('master-lc-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                    ),
                    'update' => array(
                        'click' => "function( e ){
            e.preventDefault();
            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
            updateDialog( $( this ).attr( 'href' ) );
            $( '#update-dialog' )
              .dialog( { title: 'Update Info' } )
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
        'title' => 'Viewing Single Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1030,
        'resizable' => false,
    ),
));
?>
<div id="ajaxLoaderView" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
<div id='AjFlash' style="display:none; margin-top: 20px;">

</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Info',
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
