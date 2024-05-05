<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'customers-form',
            'action' => $this->createUrl('customers/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Customer Info' : 'Update Customer Info'); ?></legend>
            <table>
                <tr>
                    <td><?php echo $form->labelEx($model,'id_no'); ?></td>
                    <td><?php echo $form->textField($model,'id_no',array('maxlength'=>255)); ?><span class="heighlightSpan">Keep blank to auto generate</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'id_no'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'company_name'); ?></td>
                    <td><?php echo $form->textField($model,'company_name',array('maxlength'=>255)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_name'); ?></td>
                </tr>
                <tr>
                    <td> <?php echo $form->labelEx($model,'company_address'); ?></td>
                    <td><?php echo $form->textArea($model,'company_address',array('rows'=>4, 'cols'=>20)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_address'); ?></td>
                </tr>
                
                <tr>
                    <td><?php echo $form->labelEx($model,'company_contact_no'); ?></td>
                    <td><?php echo $form->textField($model,'company_contact_no',array('maxlength'=>20)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_contact_no'); ?></td>
                </tr>
                
                <tr>
                    <td> <?php echo $form->labelEx($model,'company_fax'); ?></td>
                    <td><?php echo $form->textField($model,'company_fax',array('maxlength'=>20)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_fax'); ?></td>
                </tr>
                
                <tr>
                    <td> <?php echo $form->labelEx($model,'company_email'); ?></td>
                    <td><?php echo $form->textField($model,'company_email',array('maxlength'=>50)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_email'); ?></td>
                </tr>
                
                <tr>
                    <td> <?php echo $form->labelEx($model,'company_web'); ?></td>
                    <td><?php echo $form->textField($model,'company_web',array('maxlength'=>50)); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->error($model,'company_web'); ?></td>
                </tr>
            </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('customers/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#customers-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("customers-grid", {
		data: $(this).serialize()
	});
                    }else{
                        $("#formResultError").html("Data not saved. Pleae solve the following errors.");
                        $.each(data, function(key, val) {
                            $("#customers-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#customers-form #"+key+"_em_").show();
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
