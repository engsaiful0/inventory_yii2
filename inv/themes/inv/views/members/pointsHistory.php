<fieldset>
    <legend>Points History Of Member Name: <?php echo $model->name; ?>, Card Number: <?php echo $model->card_no; ?>, Contact Number: <?php echo $model->contact_no; ?></legend>

    <div class="grid-view">
        <table class="items">
            <thead>
                <tr class="odd" style="text-align: center;">
                    <th>SL</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Points Added</th>
                    <th>Points Used</th>
                    <th>Remarks</th>
                    <th>Added By</th>
                    <th>Reduced By</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)) { ?>
                    <?php
                    $sl = 1;
                    $totalAdded = 0;
                    $totalUsed = 0;
                    ?>
                    <?php foreach ($data as $d): ?>
                        <tr class="
                        <?php
                        if ($sl % 2 == 0) {
                            echo 'even';
                        } else {
                            echo 'odd';
                        }
                        ?>
                            "> 
                            <td>
                                <?php echo $sl++; ?>
                            </td>
                            <td>
                                <?php echo $d->date; ?>
                            </td> 
                            <td>
                                <?php echo $d->inv_no; ?>
                            </td> 
                            <td>
                                <?php echo $d->added_point; ?>
                            </td>
                            <td>
                                <?php echo $d->used_point; ?>
                            </td> 
                            <td>
                                <?php echo $d->remarks; ?>
                            </td>
                            <td>
                                <?php echo Users::model()->userNameOfThis($d->added_by); ?>
                            </td>
                            <td>
                                <?php echo Users::model()->userNameOfThis($d->reduced_by); ?>
                            </td>
                        </tr>
                        <?php
                        $totalAdded = $d->added_point + $totalAdded;
                        $totalUsed = $d->used_point + $totalUsed;
                        ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="font-weight: bold; color: red;">Total:</td>
                        <td><?php echo $totalAdded; ?></td>
                        <td><?php echo $totalUsed; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight: bold; color: red;">Total Available Points:</td>
                        <td colspan="2"><?php echo ($totalAdded-$totalUsed); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } else { ?>
                    <tr style="text-align: center;">
                        <td colspan="8"><div class="flash-error">No result found!</div></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>
