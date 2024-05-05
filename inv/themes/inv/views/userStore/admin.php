<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-store-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo CHtml::link('Back To Assign Stores', array('/users/adminAssignStore'), array('class'=>'additionalBtn')); ?>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Assigned Stores</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'user-store-grid',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('user_id'),
        'filter' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array( 
            array(
                'name'=>'user_id',
                'value'=>'Users::model()->userNameOfThis($data->user_id)',
                'filter'=>CHtml::listData(Users::model()->findAll(), 'id', 'username'),
            ),
            array(
                'name' => 'store_id',
                'value' => 'CHtml::encode(Stores::model()->storeName($data->store_id))',
                'filter' => CHtml::listData(Stores::model()->findAll(), 'id', 'store_name'),
            ),
            array(
                'name' => 'is_active',
                'value' => 'Lookup::item("is_active", $data->is_active)',
                'filter' => Lookup::items('is_active'),
            ),
            array
                (
                'htmlOptions'=>array('style'=>'width: 80px'),
                'header' => 'Options',
                'template' => '{activate}{inactivate}{update}{delete}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'activate' => array(
                        'label' => 'Activate',
                          'imageUrl' => Yii::app()->theme->baseUrl . '/images/activate.ico',
                        'url' => 'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id, "status"=>"activate"))',
                        'click' => "function(){
                                            $.fn.yiiGridView.update('user-store-grid', {
                                                type:'POST',
                                                url:$(this).attr('href'),
                                                success:function(data) {
                                                      $.fn.yiiGridView.update('user-store-grid'); 
                                                }
                                            })
                                            return false;
                                          }",
                    ),
                   'inactivate' => array(
                        'label' => 'Inactivate',
                         'imageUrl' => Yii::app()->theme->baseUrl . '/images/inactivate.ico',
                        'url' => 'Yii::app()->controller->createUrl("changeStatus",array("id"=>$data->id, "status"=>"inactivate"))',
                        'click' => "function(){
                                            $.fn.yiiGridView.update('user-store-grid', {
                                                type:'POST',
                                                url:$(this).attr('href'),
                                                success:function(data) {
                                                      $.fn.yiiGridView.update('user-store-grid'); 
                                                }
                                            })
                                            return false;
                                          }",
                    ),
                     'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update This Info' } )
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
    'id' => 'update-dialog',
    'options' => array(
        'title' => 'Update This Info',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="update-dialog-content"></div>
<?php $this->endWidget(); ?>

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

