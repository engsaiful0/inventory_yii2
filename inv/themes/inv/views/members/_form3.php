<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'members-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Find Member's Available Points</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'card_no'); ?></td>
                <td><?php echo $form->textField($model, 'card_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_no'); ?></td>
                <td><?php echo $form->textField($model, 'contact_no', array('maxlength' => 255, 'class' => 'optionalInputsForPos')); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'available_point'); ?></td>
                <td><div class="receivedByDiv" id="availablePoints"></div></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'usable_points'); ?></td>
                <td><input type="text" id="usablePoints" class="optionalInputsForPos" style="background-color: #d7d7d7;"/></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'usable_amounts'); ?></td>
                <td><input type="text" id="usableAmounts" class="optionalInputsForPos" style="background-color: #d7d7d7;"/></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderAVP" style="display: none; float: left;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
            <?php
            echo CHtml::submitButton('Search', array(
                'ajax' => array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'url' => CController::createUrl('members/availablePointsOfThis'),
                    'success' => 'function(data) {
                                                $("#availablePoints").html(data.availablePoints);
                                                $("#usablePoints").val(data.usablePoints);
                                                $("#usableAmounts").val(data.usableAmounts);
                                         }',
                    'data' => array(
                        'cardNo' => 'js:jQuery("#Members_card_no").val()',
                        'contactNo' => 'js:jQuery("#Members_contact_no").val()',
                    ),
                    'beforeSend' => 'function(){
                                                    $("#ajaxLoaderAVP").show(); 
                                         }',
                    'complete' => 'function(){
                                                    $("#ajaxLoaderAVP").hide();
                                        }',
                ),
                    )
            );
            ?>
            <?php
                echo CHtml::submitButton('Use These Points', array('id'=>'usePointsBtn')
                );
                ?>
    </fieldset>
</div>
<script>
    $('#Members_card_no').focus();
    $("#usablePoints").focus(function(){
        $(this).blur();         
    });
    $("#usableAmounts").focus(function(){
        $(this).blur();         
    });
    $("#usePointsBtn").click(function(){
        if($("#usablePoints").val()>0){
            $("#memberCardNoInputForReduce").val($("#Members_card_no").val());
            $("#memberPointAddInputForReduce").val($("#usablePoints").val());
            $("#cashOverallDisc").val($("#usableAmounts").val());
            $("#cashOverallDisc").click();
        }else{
            $("#memberCardNoInputForReduce").val("");
            $("#memberPointAddInputForReduce").val("");
            $("#cashOverallDisc").val('0');
            $("#cashOverallDisc").click();
            alertify.alert("Notice: Insufficient points !");
        }
        
        return false;
    });
</script>
<?php $this->endWidget(); ?>
