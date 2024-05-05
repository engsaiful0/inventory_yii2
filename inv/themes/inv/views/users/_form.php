<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-form',
            'action' => $this->createUrl('users/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New User' : 'Update User Info: ' . $model->username); ?></legend>
         <table>            
            <tr>
                <td><?php echo $form->labelEx($model, 'employee_id'); ?></td>
                <td>
                <?php
                    echo $form->dropDownList(
                            $model, 'employee_id', CHtml::listData(Employees::model()->findAll(), 'id', 'full_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addEmployee(); $('#dialogAddEmployee').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogAddEmployee',
                        'options' => array(
                            'title' => 'Add Employee',
                            'autoOpen' => false,
                            'modal' => true,
                            'width' => 550,
                            'resizable' => false,
                        ),
                    ));
                    ?>
                     <div class="divForForm">
                        <div class="ajaxLoaderFormLoad" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></div>
                    </div>

                    <?php $this->endWidget(); ?>

                    <script type="text/javascript">
                        // here is the magic
                        function addEmployee(){
<?php
echo CHtml::ajax(array(
    'url' => array('employees/createEmployeeFromOutSide'),
    'data' => "js:$(this).serialize()",
    'type' => 'post',
    'dataType' => 'json',
    'beforeSend'=>"function(){
        $('.ajaxLoaderFormLoad').show();
    }",
    'complete'=>"function(){
        $('.ajaxLoaderFormLoad').hide();
    }",
    'success' => "function(data){
                                        if (data.status == 'failure')
                                        {
                                            $('#dialogAddEmployee div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogAddEmployee div.divForForm form').submit(addEmployee);
                                        }
                                        else
                                        {
                                            $('#dialogAddEmployee div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogAddEmployee').dialog('close') \",1000);
                                            $('#Users_employee_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
                                        }
                                                                }",
))
?>;
                return false; 
            } 
                    </script> 
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'employee_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'username'); ?></td>
                <td><?php echo $form->textField($model, 'username', array('maxlength'=>20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'username'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'password'); ?></td>
                <td><?php echo $form->passwordField($model, 'password', array('maxlength'=>20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'password'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'password2'); ?></td>
                <td><?php echo $form->passwordField($model, 'password2', array('maxlength'=>20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'password2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_pos_user'); ?></td>
                <td><?php echo $form->checkBox($model, 'is_pos_user', array('style'=>'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_pos_user'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_authorizer'); ?></td>
                <td><?php echo $form->checkBox($model, 'is_authorizer', array('style'=>'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_authorizer'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'pin_code'); ?></td>
                <td><?php echo $form->passwordField($model, 'pin_code', array('maxlength'=>20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'pin_code'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('users/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#users-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("users-grid", {
		data: $(this).serialize()
	});
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#users-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#users-form #"+key+"_em_").show();
                        });
                    }       
                }',
            'beforeSend' => 'function(){                        
                $("#ajaxLoader").show();
             }'
        ));
        ?>
    </fieldset>
    <div id="formResult" class="ajaxTargetDiv" style="display: none;"></div>
    <div id="formResultError" class="ajaxTargetDivErr" style="display: none;"></div>
</div>
<script>
    $(document).ready(function(){
        var checkboxIsPosUser = $('#Users_is_pos_user');
        var checkboxIsPosAuthorizer = $('#Users_is_authorizer');
        $(checkboxIsPosUser).click(function(){
               $(checkboxIsPosAuthorizer).prop('checked',false);
        })
        $(checkboxIsPosAuthorizer).click(function(){
               $(checkboxIsPosUser).prop('checked',false);
        })
    });
</script>
<?php $this->endWidget(); ?>