
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
<?php echo CHtml::link('Manage Assigned Stores', array('/userStore/admin'), array('class'=>'additionalBtn')); ?>
<div id="statusMsg"></div>
<fieldset style="float: left; width: 98%;">
    <legend>Manage Assigned Stores</legend>
    <span class="heighlightSpan">
        Assign Just One Store if the user is a POS User
    </span>
    <?php
    $this->widget('ext.groupgridview.GroupGridView', array(
        'id' => 'users-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'mergeColumns' => array('id'),
        'cssFile' => Yii::app()->theme->baseUrl . '/css/gridview/styles.css',
        'columns' => array(
            array(
                'name'=>'is_pos_user',
                'value'=>'Users::model()->isPosUser($data->is_pos_user)',
                'filter'=>array(1 => "POS User", 0 => "Others"),
            ),
            array(
                'name' => 'username',
                'value' => '$data->username',
                'filter' => CHtml::listData($model->findAll(), "username", "username"),
            ),
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
                'template' => '{assignStoreToThisUser}',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'assignStoreToThisUser' => array(
                        'label' => 'Assign Store',
                        'imageUrl' => Yii::app()->theme->baseUrl . '/images/stores.ico',
                        'url' => 'Yii::app()->controller->createUrl("userStore/assignStoreToThisUser",array("user_id"=>$data->id))',
                        'click' => "function( e ){
                                e.preventDefault();
                                $( '#addCreditLimit-dialog' ).children( ':eq(0)' ).empty(); // Stop auto POST
                                addCreditLimitDialog( $( this ).attr( 'href' ) );
                                $( '#addCreditLimit-dialog' )
                                  .dialog( { title: 'Assign Store Form' } )
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
    'id' => 'addCreditLimit-dialog',
    'options' => array(
        'title' => 'Assign Store',
        'autoOpen' => false,
        'modal' => true,
        'width' => 'auto',
        'resizable'=>false,
    ),
));
?>
<div class="addCreditLimit-dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
$addCreditLimitJS = CHtml::ajax(array(
            'url' => "js:url",
            'data' => "js:form.serialize() + action",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function( data )
  {
    if( data.status == 'failure' ){
    $('#statusMsg').html('');
      $( '#addCreditLimit-dialog div.addCreditLimit-dialog-content' ).html( data.content );
      $( '#addCreditLimit-dialog div.addCreditLimit-dialog-content form input[type=submit]' )
        .die() // Stop from re-binding event handlers
        .live( 'click', function( e ){ // Send clicked button value
          e.preventDefault();
          addCreditLimitDialog( false, $( this ).attr( 'name' ) );
      });
    }else if(data.status=='notice'){
        $('#addCreditLimit-dialog').dialog( 'close' );
        $('#statusMsg').html(data.msg);
    }
    else{
        $('#statusMsg').html('');
      $( '#addCreditLimit-dialog div.addCreditLimit-dialog-content' ).html( data.content );
      if( data.status == 'success' ) // update all grid views on success
      {
        $( 'div.grid-view' ).each( function(){ // Change the selector if you use different class or element
          $.fn.yiiGridView.update( $( this ).attr( 'id' ) );
         });
      }
      setTimeout( \"$( '#addCreditLimit-dialog' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
    }
  }"
        ));
?>

<?php Yii::app()->clientScript->registerScript('addCreditLimitDialog', "
function addCreditLimitDialog( url, act )
{
  var action = '';
  var form = $( '#addCreditLimit-dialog div.addCreditLimit-dialog-content form' );
  if( url == false )
  {
    action = '&action=' + act;
    url = form.attr( 'action' );
  }
  {$addCreditLimitJS}
}"); ?>

<?php
Yii::app()->clientScript->registerScript('addCreditLimitDialogCreate', "
jQuery( function($){
    $( 'a.addCreditLimit-dialog-create' ).bind( 'click', function( e ){
      e.preventDefault();
      $( '#addCreditLimit-dialog' ).children( ':eq(0)' ).empty();
      addCreditLimitDialog( $( this ).attr( 'href' ) );
      $( '#addCreditLimit-dialog' )
        .dialog( { title: 'Create' } )
        .dialog( 'open' );
    });
});
");
?>
