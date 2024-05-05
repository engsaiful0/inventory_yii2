<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('suppliers-grid', {
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
<?php echo CHtml::link('Manage Contact Persons', array('/supplierContactPersons/admin'), array('class'=>'additionalBtn')); ?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage suppliers</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'suppliers-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            'id_no',
            array(
                'name'=>'id_no',
                'header'=>'Generate Barcode',
                'value'=>'CHtml::encode(Items::model()->barcodeGenerator($data->id_no))',
                'filter'=>'',
            ),
            'company_name',
            array
                (
                'header' => 'Options',
                'htmlOptions' => array('style'=>'width:100px'),
                'template' => '{view}{update}{delete}{addContactPerson}{contactPersons}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                      'contactPersons' => array(
                         'label'=>'Contact Persons',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/contacts.ico',
                        'url' => 'Yii::app()->controller->createUrl("supplierContactPersons/contacts",array("company_id"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('suppliers-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('suppliers-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
                    ),
                    'addContactPerson' => array(
                        'label' => 'Add Contact Person',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/contact_person.ico',
                        'url' => 'Yii::app()->controller->createUrl("supplierContactPersons/addContactPerson",array("company_id"=>$data->id))',
                        'click' => "function( e ){
                                e.preventDefault();
                                $( '#addContactPerson-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                addContactPersonDialog( $( this ).attr( 'href' ) );
                                $( '#addContactPerson-dialog' )
                                  .dialog( { title: 'Contact Person Form' } )
                                  .dialog( 'open' ); }",
                    ),
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update Customer Info' } )
                              .dialog( 'open' ); }",
                    ),
                    'view' => array(
                        'url' => 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))',
                        'click' => "function(){
                                    $('#viewDialog').dialog('open');
                                    $.fn.yiiGridView.update('suppliers-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                             $('#ajaxLoaderView').hide();  
                                              //$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $('#AjFlash').html(data).show();
                                              $.fn.yiiGridView.update('suppliers-grid');
                                        },
                                        beforeSend: function(){
                                            $('#ajaxLoaderView').show();
                                        }
                                    })
                                    return false;
                              }
                     ",
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
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update Customer Info',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="update-dialog-content"></div>
<?php //$this->endWidget(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php
$updateJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
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
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>

<style>
    /* grid border */
    .grid-view table.items th, .grid-view table.items td {
        border: 1px solid gray !important;
        text-align: center;
    } 

    /* disable selected for merged cells */     
    .grid-view td.merge {
        background: none repeat scroll 0 0 #F8F8F8; 
    }
</style>

<!--Contact person dialog box---------------------------------------------------------------------->

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addContactPerson-dialog',
    'options' => array(
        'title' => 'ADD Contact Person',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="addContactPerson-dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php
$addContactPersonJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function( data )
  {
    if( data.status == 'failure' )
    {
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content' ).html( data.content );
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addContactPersonDialog( false, $( this ).attr( 'name' ) );
      });
    }
    else
    {
      $( '#addContactPerson-dialog div.addContactPerson-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      setTimeout( \"$( '#addContactPerson-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('addContactPersonDialog', "
function addContactPersonDialog( url, act )
{
  var action = '';
  var form = $( '#addContactPerson-dialog div.addContactPerson-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addContactPersonJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addContactPersonDialogCreate', "
jQuery( function($){
    $( 'a.addContactPerson-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addContactPerson-dialog' ).children( ':eq(0)' ).empty();
      addContactPersonDialog( $( this ).attr( 'href' ) );
      $( '#addContactPerson-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>