<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'employees-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Employee Info' : 'Update Employee Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'id_no'); ?></td>
                <td><?php echo $form->textField($model, 'id_no', array('maxlength' => 20)); ?><span class="heighlightSpan">Keep blank to auto generate</span></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'id_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'full_name'); ?></td>
                <td><?php echo $form->textField($model, 'full_name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'full_name'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'designation_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'designation_id', CHtml::listData(Designations::model()->allInfos(), 'id', 'designation'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'designation_id'); ?></td>
            </tr>
              <tr>
                <td><?php echo $form->labelEx($model, 'department_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'department_id', CHtml::listData(Departments::model()->findAll(), 'id', 'department_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'department_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
                <td><?php echo $form->textField($model, 'contact_no', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_no'); ?></td>
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 50)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'address'); ?></td>
                <td><?php echo $form->textArea($model, 'address', array('rows' => 4, 'cols'=>20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'address'); ?></td>
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
</script>

<?php $this->endWidget(); ?>
