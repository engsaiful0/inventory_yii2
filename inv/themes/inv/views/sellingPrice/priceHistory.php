<div class="grid-view">
    <table class="items">
        <tr>
            <td colspan="8" style="padding: 20px 0px;">Selling Price History of <?php Items::model()->item($item); ?></td>
        </tr>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Price</th>
            <th>isActive</th>
            <th>Created By</th>
            <th>Created Time</th>
            <th>Updated By</th>
            <th>Updated Time</th>
        </tr>
        <?php
        if ($data) {
            $i = 1;
            foreach ($data as $d) {
                ?>
                <tr class="<?php if ($i % 2 == 0)
            echo 'even'; else
            'odd'; ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $d->date; ?></td>
                    <td><?php echo $d->price; ?></td>
                    <td><?php echo Lookup::item("is_active", $d->is_active); ?></td>
                    <td><?php echo Users::model()->fullNameOfThis($d->created_by); ?></td>
                    <td><?php echo $d->created_time; ?></td>
                    <td><?php echo Users::model()->fullNameOfThis($d->updated_by); ?></td>
                    <td><?php echo $d->updated_time; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
