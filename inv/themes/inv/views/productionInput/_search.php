<?php
$form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
?>
<table style="width: 40%;">
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
    </tr>
    <tr>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'startTime'); ?></td>
        <td>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig3 = array(
                'model' => $model,
                'attribute' => 'startTime',
                'mode' => 'time',
                'language' => 'en-AU',
                'htmlOptions' => array('style' => 'width: 100%; padding: 10px 0px;',),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig3);
            ?>
        </td>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'endTime'); ?></td>
        <td>
            <?php
            Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
            $dateTimePickerConfig4 = array(
                'model' => $model,
                'attribute' => 'endTime',
                'mode' => 'time',
                'language' => 'en-AU',
                'htmlOptions' => array('style' => 'width: 100%; padding: 10px 0px;',),
            );
            $this->widget('CJuiDateTimePicker', $dateTimePickerConfig4);
            ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'store'); ?></td>
        <td>
            <?php
            echo $form->dropDownList(
                    $model, 'store', CHtml::listData(UserStore::model()->assignedActiveStoresOfThisLoggedInUserAllStores(), 'id', 'store_name'), array(
                'prompt' => 'Select',
                'style' => 'width: 100%; padding: 10px 0px;',
            ));
            ?>
        </td>
        <td style="text-align: right; padding-right: 6px;"><?php echo $form->labelEx($model, 'machine'); ?></td>
        <td>
            <?php
            echo $form->dropDownList(
                    $model, 'machine', CHtml::listData(Machines::model()->findAll(), 'id', 'nameWithCode'), array(
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
    </tr>
</table>
<?php $this->endWidget(); ?>
