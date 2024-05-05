<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'your-company-form',
            'action' => $this->createUrl('yourCompany/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Company Info' : 'Update Company Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'company_name'); ?></td>
                <td><?php echo $form->textField($model, 'company_name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'company_name'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model, 'location'); ?></td>
                <td><?php echo $form->textField($model, 'location', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'location'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact'); ?></td>
                <td><?php echo $form->textField($model, 'contact', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact'); ?></td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'web'); ?></td>
                <td><?php echo $form->textField($model, 'web', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'web'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'vat_regi_no'); ?></td>
                <td><?php echo $form->textField($model, 'vat_regi_no', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'vat_regi_no'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'vat_amount'); ?></td>
                <td><?php echo $form->textField($model, 'vat_amount'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'vat_amount'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList($model, 'is_active', Lookup::items('is_active'));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('yourCompany/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                    $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#your-company-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("your-company-grid", {
		data: $(this).serialize()
	});
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#your-company-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#your-company-form #"+key+"_em_").show();
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
