<?php
$form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
?>
<table style="width: 60%;">
    <tr>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'startDate'); ?></td>
        <td>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig1 = array(
                'model' => $model,
                'attribute' => 'startDate',
                'mode' => 'date',
                'language' => 'en-AU',
                'options' => array(
                    'changeMonth' => 'true',
                    'changeYear' => 'true',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array('style' => 'width: 100%; padding: 10px 0px;',),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig1);
            ?>
        </td>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'endDate'); ?></td>
        <td>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig2 = array(
                'model' => $model,
                'attribute' => 'endDate',
                'mode' => 'date',
                'language' => 'en-AU',
                'options' => array(
                    'changeMonth' => 'true',
                    'changeYear' => 'true',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array('style' => 'width: 100%; padding: 10px 0px;',),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig2);
            ?>
        </td>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'customer_id'); ?></td>
        <td>
            <?php
            echo $form->dropDownList(
                    $model, 'customer_id', CHtml::listData(Customers::model()->findAll(array('order'=>'company_name ASC')), 'id', 'company_name'), array(
                'prompt' => 'Select',
                'style' => 'width: 100%; padding: 10px 0px;',
            ));
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::submitButton('Search'); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
