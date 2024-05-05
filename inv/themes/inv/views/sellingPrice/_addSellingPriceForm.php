<?php
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'selling-price-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array('validateOnSubmit'=>true),
        ));
?>
<script>
    $(document).ready(function(){ 
        $("#SellingPrice_item").css("background-color", "#EEEEEE");
        $("#SellingPrice_item").focus(function(){
            $(this).blur();
        });
    });
</script>
<div class="formDiv">
    <fieldset>
        <legend>Add Selling Price</legend>
        <table>
            <?php
            $model->item = $item;
            ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'item'); ?></td>
                <td>
                    <span class="heighlightSpan">
                        <?php echo $form->hiddenField($model, 'item'); Items::model()->item($model->item); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'item'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'price'); ?></td>
                <td><?php echo $form->textField($model, 'price'); ?></td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'price'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'date'); ?></td>
                <td>
                    <?php
                    Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
                    $dateTimePickerConfig2 = array(
                        'model' => $model, //Model object
                        'attribute' => 'date', //attribute name
                        'mode' => 'date', //use "time","date" or "datetime" (default)
                        'language' => 'en-AU',
                        'options' => array(
//                        'ampm' => true,
                            'dateFormat' => 'yy-mm-dd',
                            'width' => '100',
                        ) // jquery plugin options
                    );
                    $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
                    ?>
                </td>            
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->error($model, 'date'); ?></td>
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
        <?php echo CHtml::submitButton('Add', array('onclick'=>'loadingDivDisplay();')); ?>
    </fieldset>
</div>
<script type="text/javascript">
    function loadingDivDisplay(){
       $("#ajaxLoaderMR").show();
    }
</script>

<?php $this->endWidget(); ?>
