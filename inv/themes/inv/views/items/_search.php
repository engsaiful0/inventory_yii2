<?php
$form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
?>
<table>
    <tr>
        <td><?php echo $form->label($model, 'store'); ?></td>
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
        <td><?php echo CHtml::submitButton('Search'); ?></td>
    </tr>
</table>
<?php $this->endWidget(); ?>
