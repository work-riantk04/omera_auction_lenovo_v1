<div class="page-header">
    <h1 class="page-title">Shipping</h1>
</div>

<div class="table-card">
    <?php if (!empty($shipping)): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Titipers</th>
                        <th>Amount</th>
                        <th>Shipping Proof</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shipping as $ship): ?>
                        <tr>
                            <td><strong>#<?= $ship['id'] ?></strong></td>
                            <td><?= htmlspecialchars($ship['item_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($ship['titipers_name'] ?? '-') ?></td>
                            <td>Rp <?= number_format($ship['win_amount'] ?? 0, 0, ',', '.') ?></td>
                            <td>
                                <?php if (!empty($ship['shipping_proof'])): ?>
                                    <a href="<?= base_url('uploads/shipping/' . $ship['shipping_proof']) ?>" target="_blank" class="btn btn-sm btn-outline">
                                        <i class="fas fa-image"></i> View
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">No proof</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ship['status'] === 'pending'): ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php elseif ($ship['status'] === 'shipping'): ?>
                                    <span class="badge badge-info">In Transit</span>
                                <?php elseif ($ship['status'] === 'delivered'): ?>
                                    <span class="badge badge-primary">Delivered</span>
                                <?php elseif ($ship['status'] === 'verified'): ?>
                                    <span class="badge badge-success">Verified</span>
                                <?php else: ?>
                                    <span class="badge badge-<?= $ship['status'] ?>"><?= ucfirst($ship['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ship['status'] === 'pending'): ?>
                                    <form method="POST" action="<?= site_url('admin/shipping_verify/' . $ship['id']) ?>" style="display:inline">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="status" value="in_transit">
                                        <button type="submit" class="btn btn-sm btn-info" title="Notify Titipers / Start Shipping"><i class="fas fa-truck"></i> Ship</button>
                                    </form>
                                <?php elseif ($ship['status'] === 'shipping'): ?>
                                    <?php if (!empty($ship['shipping_proof'])): ?>
                                        <form method="POST" action="<?= site_url('admin/shipping_verify/' . $ship['id']) ?>" style="display:inline">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                            <input type="hidden" name="status" value="delivered">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Verify Delivery"><i class="fas fa-box-open"></i> Verify Delivery</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">Awaiting proof</span>
                                    <?php endif; ?>
                                <?php elseif ($ship['status'] === 'delivered'): ?>
                                    <form method="POST" action="<?= site_url('admin/shipping_verify/' . $ship['id']) ?>" style="display:inline">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="btn btn-sm btn-success" title="Confirm & Trigger Disbursement"><i class="fas fa-check"></i> Confirm</button>
                                    </form>
                                <?php elseif ($ship['status'] === 'verified'): ?>
                                    <span class="text-success"><i class="fas fa-check-circle"></i> Complete</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-truck"></i>
            <p>No shipping records found.</p>
        </div>
    <?php endif; ?>
</div>
