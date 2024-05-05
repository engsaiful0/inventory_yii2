<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-store-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update this info</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'user_id'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'user_id', CHtml::listData(Users::model()->findAll(), 'id', 'username'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
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
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
