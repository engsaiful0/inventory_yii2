<fieldset>
    <legend><span class="heighlightSpan">ID No: <?php echo $model->id_no; ?></span></legend>
    <div class="grid-view">
        <table class="items">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>ID No</th>
                    <th>Contact No</th>
                    <th>E-Mail</th>                    
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td><?php echo $model->full_name; ?></td>
                    <td><?php echo Designations::model()->infoOfThis($model->designation_id); ?></td>
                    <td><?php echo Departments::model()->nameOfThis($model->department_id); ?></td>
                    <td><?php echo $model->id_no; ?></td>
                    <td><?php echo $model->contact_no; ?></td>
                    <td><?php echo $model->email; ?></td>                                   
                </tr>
            </tbody>
        </table>

        <table class="items" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <tr class="even">
                    <td><pre><?php echo $model->address; ?></pre></td>  
                </tr>
            </tbody>
        </table>
    </div>
</fieldset>
