<table class="checkoutTab">
    <tr>
        <th>Supplier</th>
        <td><?php echo Suppliers::model()->supplierName($model->supplier_id); ?></td>
        <th>LC No</th>
        <td><?php echo $model->lc_no; ?></td>
        <th>LC Amount</th>
        <td><?php echo $model->lc_amount; ?></td>
    </tr>
    <tr>
        <th>Shipment Date</th>
        <td><?php echo $model->shipment_date; ?></td>
        <th>Expire Date</th>
        <td><?php echo $model->expire_date; ?></td>
        <th>LC Date</th>
        <td><?php echo $model->lc_date; ?></td>
    </tr>
    <tr>
        <th>Shipment From</th>
        <td><?php echo $model->shipment_from; ?></td>
        <th>Shipment To</th>
        <td><?php echo $model->shipment_to; ?></td>
        <th>HS Code</th>
        <td><?php echo $model->hs_code; ?></td>
    </tr>
    <tr>
        <th>Insurance Company</th>
        <td><?php echo $model->insurance_company; ?></td>
        <th>Agent</th>
        <td><?php echo $model->agent; ?></td>
        <th>C & F Agent</th>
        <td><?php echo $model->c_f_agent; ?></td>
    </tr>
    <tr>
        <th>Transport Agency</th>
        <td><?php echo $model->transport_agency; ?></td>
        <th>LC Amended</th>
        <td><?php echo $model->lc_amended; ?></td>
        <th>Last Date of Shipment</th>
        <td><?php echo $model->last_date_of_shipment; ?></td>
    </tr>
    <tr>
        <th>LC Tenor</th>
        <td><?php echo Tenors::model()->nameOfThis($model->lc_tenor_id); ?></td>
        <th>Export LC No</th>
        <td><?php echo $model->export_lc_no; ?></td>
        <th>Bank</th>
        <td><?php echo Banks::model()->nameOfThis($model->bank_id); ?></td>
    </tr>
    <tr>
        <th>Remarks</th>
        <td colspan="5"><?php echo $model->remarks; ?></td>
    </tr>
    <tr>
        <th>PO No(s)</th>
        <td colspan="5"><?php echo $model->po_no; ?></td>
    </tr>
</table>
