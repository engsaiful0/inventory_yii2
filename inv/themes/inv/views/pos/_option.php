<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMemberInfo',
    'options' => array(
        'title' => 'Member Informations',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'resizable' => false,
    ),
));
?>
<div class="divForForm">                         
    <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function addMember(){
<?php
echo CHtml::ajax(array(
    'url' => array('members/createMembersFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
        if (data.status == 'failure')
        {
            $('#dialogMemberInfo div.divForForm').html(data.div);
                  // Here is the trick: on submit-> once again this function!
            $('#dialogMemberInfo div.divForForm form').submit(addMember);
        }
        else
        {
            $('#dialogMemberInfo div.divForForm').html(data.div);
            setTimeout( \"$( '#dialogMemberInfo' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
        }
    }",
))
?>;
        return false; 
    } 
</script> 


<script type="text/javascript">
    function membersAVPoint(){
<?php
echo CHtml::ajax(array(
    'url' => array('members/membersAVpoint'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend' => "function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete' => "function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
        if (data.status == 'failure')
        {
            $('#dialogMemberInfo div.divForForm').html(data.div);
                  // Here is the trick: on submit-> once again this function!
            $('#dialogMemberInfo div.divForForm form').submit(membersAVPoint);
        }
        else
        {
            $('#dialogMemberInfo div.divForForm').html(data.div);
            setTimeout( \"$( '#dialogMemberInfo' ).dialog( 'close' ).children( ':eq(0)' ).empty();\", 1000 );
        }
    }",
))
?>;
        return false; 
    } 
</script> 
<ul class="noListStyle">
    <li><?php echo CHtml::link('Add New Member', "", array('onclick' => "{addMember(); $('#dialogMemberInfo').dialog('open');}", 'class'=>'performLink')); ?></li>
    <li><?php echo CHtml::link('Points', "", array('onclick' => "{membersAVPoint(); $('#dialogMemberInfo').dialog('open');}", 'class'=>'performLink')); ?></li>
</ul>
<style>
    ul.noListStyle{
        list-style: none;
    }
    a.performLink{
        border:1px solid #000000;
        padding: 6px;
        background-color: tomato;
        font-weight: bold;
        margin: 2px 0px;
        float: left;
    }
</style>
