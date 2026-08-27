<div class="page-header">
    <h1 class="page-title"><i class="fas fa-box"></i> Item Detail</h1>
    <a href="<?= site_url('admin/items') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Items</a>
</div>

<div class="item-detail-grid">
    <!-- Item Image -->
    <div class="item-detail-image card-3d">
        <?php if (!empty($item['image'])): ?>
            <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <?php else: ?>
            <div class="no-image-placeholder">
                <i class="fas fa-image"></i>
                <span>No Image</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Item Info -->
    <div class="item-detail-info card-3d">
        <div class="detail-header">
            <h2><?= htmlspecialchars($item['name']) ?></h2>
            <span class="badge badge-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span>
        </div>

        <div class="detail-grid">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-tag"></i> Category</span>
                <span class="detail-value"><?= htmlspecialchars($item['category'] ?? '-') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar"></i> Event</span>
                <span class="detail-value"><?= htmlspecialchars($item['event_name'] ?? '-') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Titipers</span>
                <span class="detail-value"><?= htmlspecialchars($item['titipers_name'] ?? '-') ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-money-bill"></i> Starting Price</span>
                <span class="detail-value price">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></span>
            </div>
            <div class="detail-row full-width">
                <span class="detail-label"><i class="fas fa-align-left"></i> Description</span>
                <p class="detail-desc"><?= nl2br(htmlspecialchars($item['description'] ?? '-')) ?></p>
            </div>
            <?php if (!empty($item['admin_note'])): ?>
                <div class="detail-row full-width">
                    <span class="detail-label"><i class="fas fa-sticky-note"></i> Admin Note</span>
                    <p class="detail-desc admin-note"><?= htmlspecialchars($item['admin_note']) ?></p>
                </div>
            <?php endif; ?>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-clock"></i> Created</span>
                <span class="detail-value"><?= date('d M Y H:i', strtotime($item['created_at'])) ?></span>
            </div>
        </div>

        <?php if (!in_array($item['status'], ['approved', 'rejected', 'sold'])): ?>
            <div class="detail-actions">
                <form method="POST" action="<?= site_url('admin/items_verify/' . $item['id']) ?>" id="verifyForm" style="width:100%">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <div class="form-group">
                        <label for="admin_note"><i class="fas fa-sticky-note"></i> Admin Note <small>(notes untuk titipers)</small></label>
                        <textarea id="admin_note" name="admin_note" class="form-control" rows="3" placeholder="Tulis catatan untuk titipers, misal: barang perlu fotonya lebih jelas, deskripsi kurang lengkap, dll."></textarea>
                    </div>
                    <div class="action-row">
                        <button type="submit" name="status" value="rejected" class="btn btn-danger" onclick="return confirm('Tolak item ini?')">
                            <i class="fas fa-times"></i> Reject
                        </button>
                        <button type="submit" name="status" value="approved" class="btn btn-success" onclick="return confirm('Setujui item ini?')">
                            <i class="fas fa-check"></i> Approve
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
