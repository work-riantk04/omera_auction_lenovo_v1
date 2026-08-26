<div class="page-header">
    <h1 class="page-title">Invoices</h1>
</div>

<!-- Filter -->
<div class="filter-bar">
    <div class="form-group">
        <select id="eventFilter" class="form-control form-control-sm" onchange="filterByEvent(this.value)">
            <option value="">All Events</option>
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $evt): ?>
                    <option value="<?= htmlspecialchars($evt['name']) ?>"><?= htmlspecialchars($evt['name']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="table-card">
    <?php if (!empty($invoices)): ?>
        <div class="table-responsive">
            <table class="data-table" id="invoicesTable">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Event</th>
                        <th>Item</th>
                        <th>Bidder</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                        <tr data-event="<?= htmlspecialchars($inv['event_name'] ?? '') ?>">
                            <td><strong>#<?= $inv['id'] ?></strong></td>
                            <td><?= htmlspecialchars($inv['event_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($inv['item_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($inv['bidder_name'] ?? '-') ?></td>
                            <td><strong>Rp <?= number_format($inv['win_amount'], 0, ',', '.') ?></strong></td>
                            <td>
                                <?php if ($inv['payment_status'] === 'unpaid'): ?>
                                    <span class="badge badge-warning">Unpaid</span>
                                <?php elseif ($inv['payment_status'] === 'paid'): ?>
                                    <span class="badge badge-info">Paid</span>
                                <?php elseif ($inv['payment_status'] === 'verified'): ?>
                                    <span class="badge badge-success">Verified</span>
                                <?php elseif ($inv['payment_status'] === 'pending'): ?>
                                    <span class="badge badge-secondary">Pending</span>
                                <?php else: ?>
                                    <span class="badge badge-<?= $inv['payment_status'] ?>"><?= ucfirst($inv['payment_status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($inv['payment_status'] === 'paid'): ?>
                                    <form method="POST" action="<?= site_url('admin/invoices_verify_payment/' . $inv['id']) ?>" style="display:inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="btn btn-sm btn-success" title="Verify Payment"><i class="fas fa-check"></i> Verify</button>
                                    </form>
                                    <form method="POST" action="<?= site_url('admin/invoices_verify_payment/' . $inv['id']) ?>" style="display:inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject Payment"><i class="fas fa-times"></i></button>
                                    </form>
                                <?php elseif ($inv['payment_status'] === 'verified'): ?>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Payment Verified</span>
                                <?php elseif ($inv['payment_status'] === 'unpaid' || $inv['payment_status'] === 'pending'): ?>
                                    <span class="text-muted">Waiting for payment</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-file-invoice"></i>
            <p>No invoices found.</p>
        </div>
    <?php endif; ?>
</div>

<script>
function filterByEvent(value) {
    var rows = document.querySelectorAll('#invoicesTable tbody tr');
    rows.forEach(function(row) {
        if (!value || row.dataset.event === value) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
