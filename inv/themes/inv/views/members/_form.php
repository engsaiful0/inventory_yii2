<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'members-form',
            'action' => $this->createUrl('members/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Members Info' : 'Update Members Info'); ?></legend>
            <table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'card_no'); ?></td>
                    <td><?php echo $form->textField($model, 'card_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'card_no'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'name'); ?></td>
                    <td><?php echo $form->textField($model, 'name', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'name'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
                    <td><?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'contact_no'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'email'); ?></td>
                    <td><?php echo $form->textField($model, 'email', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'email'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'address'); ?></td>
                    <td><?php echo $form->textField($model, 'address', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'address'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'dob'); ?></td>
                    <td>
                        <?php
                        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                        $dateTimePickerConfig1 = array(
                            'model' => $model,
                            'attribute' => 'dob',
                            'mode' => 'date',
                            'language' => 'en-AU',
                            'options' => array(
                                'changeMonth' => 'true',
                                'changeYear' => 'true',
                                'dateFormat' => 'yy-mm-dd',
                            ), 'htmlOptions' => array('class' => 'optionalInputsForPos',),
                        );
                        $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'dob'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'spouse'); ?></td>
                    <td><?php echo $form->textField($model, 'spouse', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model, 'spouse'); ?></td>
                </tr>
            </table>
    </fieldset>

    <fieldset class="tblFooters">
        <div id="ajaxLoader" style="display: none; float: left;">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" />
        </div>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('members/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#members-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("members-grid", {
		data: $(this).serialize()
	});
                    }else{
                        //$("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#members-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#members-form #"+key+"_em_").show();
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

<?php $this->endWidget(); ?>
