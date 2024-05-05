<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'store-inventory-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true),
        ));
?>
<div class="formDiv">
    <fieldset>
        <legend>Update informations</legend>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig1 = array(
                        'model' => $model,
                        'attribute' => 'date',
                        'mode' => 'date',
                        'language' => 'en-AU',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                        )
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'store'); ?></td>
                <td>
                    <?php
                    echo $form->dropDownList(
                            $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                        'prompt' => 'Select',
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'store'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'item'); ?></td>
                <td><?php
                    echo $form->dropDownList($model, 'item', CHtml::listData(Items::model()->findAll(array("order" => "name ASC")), "id", "nameWithDesc"), array(
                        'prompt' => 'Select',
                    ));
                    ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'item'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'stock_in'); ?></td>
                <td><?php echo $form->textField($model, 'stock_in', array('maxlength' => 255)); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'stock_in'); ?></td>
            </tr>
        </table>
    </fieldset>

    <fieldset class="tblFooters">
        <span id="ajaxLoaderMR" style="display: none;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader.gif" /></span>
<?php echo CHtml::submitButton('Update', array('onclick' => 'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
        $("#ajaxLoaderMR").show();
    }
</script>
<?php $this->endWidget(); ?>
