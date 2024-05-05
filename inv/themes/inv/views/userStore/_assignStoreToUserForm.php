<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-store-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Assign Store To 
            <span class="heightlightedText">
                <?php
                $empNm = Users::model()->fullNameOfThis($user_id);
                $userNm = Users::model()->userNameOfThis($user_id);
                echo $empNm;
                ?>
            </span>
        </legend>
        <table>
            <?php
            $model->user_id = $user_id;
            ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'user_id'); ?></td>
                <td>
                    <div class="receivedByDiv">
                        <?php echo $userNm; ?>
                        <?php echo $form->hiddenField($model, 'user_id'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'user_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'store_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'store_id', CHtml::listData(Stores::model()->findAll(), 'id', 'store_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'store_id'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_active'); ?></td>
                <td><?php echo $form->dropDownList($model, 'is_active', Lookup::items('is_active')); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'is_active'); ?></td>
            </tr>
        </table>
    </fieldset>

   <fieldset class="tblFooters">
       <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Add', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
