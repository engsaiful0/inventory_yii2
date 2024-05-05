<div class="custom_wide_form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
            ));
    ?>


    <table class="custom_row_table">
        <tr class="custom_row_tr">

            <td class="custom_row_td"><?php echo $form->label($model, 'username'); ?></td>
            <td class="custom_row_td"><?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255)); ?></td>


        </tr>


        <tr class="custom_row_tr">
            <td class="custom_row_td"><?php echo $form->label($model, 'create_by'); ?></td>
            <td class="custom_row_td"><?php echo $form->textField($model, 'create_by', array('size' => 60, 'maxlength' => 255)); ?></td>

            <td class="custom_row_td"> <?php echo $form->label($model, 'create_time'); ?></td>
            <td class="custom_row_td"><?php echo $form->textField($model, 'create_time', array('size' => 60)); ?></td>


        </tr>

        <tr class="custom_row_tr">
            <td class="custom_row_td"><?php echo $form->label($model, 'update_by'); ?></td>
            <td class="custom_row_td"><?php echo $form->textField($model, 'update_by', array('size' => 60, 'maxlength' => 255)); ?></td>

            <td class="custom_row_td"> <?php echo $form->label($model, 'update_time'); ?></td>
            <td class="custom_row_td"><?php echo $form->textField($model, 'update_time', array('size' => 60)); ?></td>
        </tr>
        <tr class="custom_row_tr">
            <td> <?php echo CHtml::submitButton('', array("class" => "custom_row_td_button")); ?></td>   
        </tr>
    </table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
