<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'supplier-contact-persons-form',
            'action' => $this->createUrl('supplierContactPersons/create'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>

<div class="formDiv">
    <fieldset>
        <legend><?php echo ($model->isNewRecord ? 'Add New Contact Person Info' : 'Update Contact Person Info'); ?></legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'company_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'company_id', CHtml::listData(Suppliers::model()->findAll(array('order' => 'id DESC')), 'id', 'company_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'company_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_person_name'); ?></td>
                <td><?php echo $form->textField($model, 'contact_person_name', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_person_name'); ?></td>
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
                    <?php
                    echo CHtml::link('', "", // the link for open the dialog
                            array(
                        'class' => 'add-additional-btn',
                        'onclick' => "{addSections(); $('#dialogSections').dialog('open');}"));
                    ?>

                    <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
                        'id' => 'dialogSections',
                        'options' => array(
                            'title' => 'Add Designation',
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
                        function addSections(){
<?php
echo CHtml::ajax(array(
    'url' => array('designations/create'),
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
                                            $('#dialogSections div.divForForm').html(data.div);
                                                  // Here is the trick: on submit-> once again this function!
                                            $('#dialogSections div.divForForm form').submit(addSections);
                                        }
                                        else
                                        {
                                            $('#dialogSections div.divForForm').html(data.div);
                                            setTimeout(\"$('#dialogSections').dialog('close') \",1000);
                                            $('#supplier-contact-persons_designation_id').append('<option selected value='+data.value+'>'+data.label+'</option>');
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
                <td><?php echo $form->error($model, 'designation_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number1'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number1', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number1'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number2'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number2', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number2'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_number3'); ?></td>
                <td><?php echo $form->textField($model, 'contact_number3', array('maxlength' => 20)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'contact_number3'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td><?php echo $form->textField($model, 'email', array('maxlength' => 50)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'email'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoader" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php
        echo CHtml::ajaxSubmitButton('Save', CHtml::normalizeUrl(array('supplierContactPersons/create', 'render' => true)), array(
            'dataType' => 'json',
            'type' => 'post',
            'success' => 'function(data) {
                $("#ajaxLoader").hide();  
                    if(data.status=="success"){
                        $("#formResultError").hide();
                        $("#formResult").fadeIn();
                        $("#formResult").html("Data saved successfully.");
                        $("#supplier-contact-persons-form")[0].reset();
                        $("#formResult").animate({opacity:1.0},1000).fadeOut("slow");
                        $.fn.yiiGridView.update("supplier-contact-persons-grid", {
                            data: $(this).serialize()
                        });
                    }else{
                        $("#formResult").hide();
                        $("#formResultError").show();
                        $("#formResultError").html("Data not saved. Pleae solve the above errors.");
                        $.each(data, function(key, val) {
                            $("#supplier-contact-persons-form #"+key+"_em_").html(""+val+"");                                                    
                            $("#supplier-contact-persons-form #"+key+"_em_").show();
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
