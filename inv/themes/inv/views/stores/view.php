<fieldset>
    <legend>View Store</legend>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'cssFile' => Yii::app()->theme->baseUrl . '/css/detailview/styles.css',
        'attributes' => array(
            'store_name',
        ),
    ));
    ?> 
</fieldset>