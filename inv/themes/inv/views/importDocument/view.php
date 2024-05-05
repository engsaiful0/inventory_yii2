<table class="checkoutTab">
    <tr>
        <th colspan="2">Import Document</th>
    </tr>
    <tr>
        <th>PI No</th>
        <td class="textAlgnLeft"><?php echo $model->pi_no; ?></td>
    </tr>
    <tr>
        <th>PI Date</th>
        <td class="textAlgnLeft"><?php echo $model->pi_date; ?></td>
    </tr>
    <tr>
        <th>LC No</th>
        <td class="textAlgnLeft"><?php echo MasterLc::model()->nameOfThis($model->lc_id); ?></td>
    </tr>
    <tr>
        <th>LC Details</th>
        <td><?php MasterLc::model()->lcDetails($model->lc_id); ?></td>
    </tr>
</table>
