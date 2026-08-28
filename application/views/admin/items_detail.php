<div class="page-header">
    <h1 class="page-title"><i class="fas fa-box"></i> Item Detail</h1>
    <a href="<?= site_url('admin/items') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Items</a>
</div>

<div class="item-detail-grid">
    <!-- Item Image -->
    <div class="item-detail-image card-3d">
        <?php $gallery = $item['images'] ?? array(); ?>
        <?php if (!empty($gallery)): ?>
            <div class="admin-gallery-main">
                <img id="adminMainImg" src="<?= base_url('uploads/items/' . $gallery[0]['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
            </div>
            <?php if (count($gallery) > 1): ?>
                <div class="admin-gallery-thumbs">
                    <?php foreach ($gallery as $gi => $gimg): ?>
                        <img src="<?= base_url('uploads/items/' . $gimg['image']) ?>" data-src="<?= base_url('uploads/items/' . $gimg['image']) ?>" class="<?= $gi === 0 ? 'active' : '' ?>" alt="" title="<?= ($gimg['is_primary'] ? 'Utama' : '') ?>" onclick="adminGallerySet(this)">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php elseif (!empty($item['image'])): ?>
            <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
        <?php else: ?>
            <div class="no-image-placeholder">
                <i class="fas fa-image"></i>
                <span>No Image</span>
            </div>
        <?php endif; ?>
        <?php if ((float)($item['min_increment'] ?? 0) > 0): ?>
            <div class="admin-inc-badge">Kelipatan bid: Rp <?= number_format((float)$item['min_increment'], 0, ',', '.') ?></div>
        <?php endif; ?>
    </div>

    <style>
    .admin-gallery-main { width: 100%; height: 300px; overflow: hidden; border-radius: 8px; background: var(--bg-tertiary); display:flex; align-items:center; justify-content:center; }
    .admin-gallery-main img { width: 100%; height: 100%; object-fit: cover; }
    .admin-gallery-thumbs { display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
    .admin-gallery-thumbs img { width: 64px; height: 64px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid transparent; opacity: .75; }
    .admin-gallery-thumbs img.active { border-color: var(--primary, #4f46e5); opacity: 1; }
    .admin-inc-badge { margin-top: 12px; display:inline-block; background: var(--primary, #4f46e5); color:#fff; padding: 6px 12px; border-radius: 6px; font-size: .85rem; }
    </style>

    <script>
    function adminGallerySet(el) {
        var main = document.getElementById('adminMainImg');
        if (!main) return;
        main.src = el.getAttribute('data-src');
        var thumbs = el.parentNode.querySelectorAll('img');
        thumbs.forEach(function (t) { t.classList.toggle('active', t === el); });
    }
    </script>

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
