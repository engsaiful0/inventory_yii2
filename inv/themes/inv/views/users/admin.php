
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
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
<div id="statusMsg"></div>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Users</legend>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'users-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'mergeColumns' => array('id'),
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name'=>'userLevel',
                'value'=>'CHtml::encode(Users::model()->findAllRolesOfThisUser($data->id))',
                'filter'=>  '',
            ),
            array(
                'name' => 'username',
                'value' => '$data->username',
                'filter' => CHtml::listData($model->findAll(), "username", "username"),
            ),
            'real_password',
            array(
                'name'=>'is_pos_user',
                'value'=>'Users::model()->isPosUser($data->is_pos_user)',
                'filter'=>array(1 => "POS User", 0 => "Others"),
            ),
            array(
                'name'=>'is_authorizer',
                'value'=>'Users::model()->isPosAuthorizer($data->is_authorizer)',
                'filter'=>array(1 => "POS Authorizer", 0 => "Others"),
            ),
            'real_pin_code',
            array(
                'name' => 'employee_id',
                'value' => 'Users::model()->fullNameOfThis($data->id)',
                'filter' => CHtml::listData(Employees::model()->findAll(), "id", "full_name"),
            ),
            array(
                'name'=>'assignedStores',
                'header'=>'Assigned Stores',
                'value'=>'UserStore::model()->assignedStoresOfThisUser($data->id)',
                'filter'=>'',
            ),
            array
                (
                'header' => 'Options',
                'template' => '{update}{delete}',
                'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); }',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'update' => array(
                        'click' => "function( e ){
                            e.preventDefault();
                            $( '#update-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                            updateDialog( $( this ).attr( 'href' ) );
                            $( '#update-dialog' )
                              .dialog( { title: 'Update User Info' } )
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
        'title' => 'Update User Info',
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
