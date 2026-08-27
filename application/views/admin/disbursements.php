<div class="page-header">
    <h1 class="page-title">Disbursements</h1>
</div>

<div class="table-card">
    <?php if (!empty($disbursements)): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titipers</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Processed Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disbursements as $disb): ?>
                        <tr>
                            <td><strong>#<?= $disb['id'] ?></strong></td>
                            <td><?= htmlspecialchars($disb['titipers_name'] ?? '-') ?></td>
                            <td><strong>Rp <?= number_format($disb['amount'], 0, ',', '.') ?></strong></td>
                            <td>
                                <?php if ($disb['status'] === 'pending'): ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php elseif ($disb['status'] === 'processed'): ?>
                                    <span class="badge badge-info">Processed</span>
                                <?php elseif ($disb['status'] === 'completed'): ?>
                                    <span class="badge badge-success">Completed</span>
                                <?php else: ?>
                                    <span class="badge badge-<?= $disb['status'] ?>"><?= ucfirst($disb['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($disb['processed_at'])): ?>
                                    <?= date('d M Y H:i', strtotime($disb['processed_at'])) ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($disb['status'] === 'pending'): ?>
                                    <form method="POST" action="<?= site_url('admin/disbursements_process/' . $disb['id']) ?>" style="display:inline">
                                         <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="btn btn-sm btn-success" title="Process Disbursement"><i class="fas fa-money-bill-wave"></i> Process</button>
                                    </form>
                                <?php elseif ($disb['status'] === 'processed'): ?>
                                    <form method="POST" action="<?= site_url('admin/disbursements_process/' . $disb['id']) ?>" style="display:inline">
                                         <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-primary" title="Mark Complete"><i class="fas fa-check"></i> Complete</button>
                                    </form>
                                <?php elseif ($disb['status'] === 'completed'): ?>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Done</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-money-bill-wave"></i>
            <p>No disbursements found.</p>
        </div>
    <?php endif; ?>
</div>
