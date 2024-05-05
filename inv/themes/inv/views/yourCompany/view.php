<fieldset>
    <legend>View Your Company Info</legend>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'company_name',
            'location',
            'contact',
            'email',
            'web',
            'vat_amount',
        ),
    ));
    ?>
    <table class="detail-view">
        <tbody>
            <tr class="even">
                <th>is Active</th>
                <td>
<?php echo Lookup::item('is_active', $model->is_active); ?>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>
