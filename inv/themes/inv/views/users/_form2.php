
<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'users-form',
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
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'employee_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'username'); ?></td>
                <td><?php echo $form->textField($model, 'username', array('maxlength' => 20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'username'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'password'); ?></td>
                <td><?php echo $form->passwordField($model, 'password', array('maxlength' => 20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'password'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'password2'); ?></td>
                <td><?php echo $form->passwordField($model, 'password2', array('maxlength' => 20)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'password2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_pos_user'); ?></td>
                <td><?php echo $form->checkBox($model, 'is_pos_user', array('id'=>'Users_is_pos_user2', 'style'=>'width: unset;')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_pos_user'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_authorizer'); ?></td>
                <td><?php echo $form->checkBox($model, 'is_authorizer', array('id'=>'Users_is_authorizer2', 'style'=>'width: unset;')); ?></td>            
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
       <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMR").show();
    }
    $(document).ready(function(){
        var checkboxIsPosUser2 = $('#Users_is_pos_user2');
        var checkboxIsPosAuthorizer2 = $('#Users_is_authorizer2');
        $(checkboxIsPosUser2).click(function(){
               $(checkboxIsPosAuthorizer2).prop('checked',false);
        })
        $(checkboxIsPosAuthorizer2).click(function(){
               $(checkboxIsPosUser2).prop('checked',false);
        })
    });
</script>
<?php $this->endWidget(); ?>