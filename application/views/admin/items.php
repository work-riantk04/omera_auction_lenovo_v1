<div class="page-header">
    <h1 class="page-title">Items Verification</h1>
</div>

<div class="table-card">
    <?php if (!empty($items)): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Event</th>
                        <th>Titipers</th>
                        <th>Image</th>
                        <th>Starting Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                            <td><?= htmlspecialchars($item['event_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($item['titipers_name'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="" class="table-thumb">
                                <?php else: ?>
                                    <div class="table-thumb-placeholder"><i class="fas fa-image"></i></div>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></td>
                            <td><span class="badge badge-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></td>
                            <td>
                                <?php if ($item['status'] === 'submitted' || $item['status'] === 'pending'): ?>
                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#verifyModal"
                                        data-id="<?= $item['id'] ?>"
                                        data-name="<?= htmlspecialchars($item['name']) ?>"
                                        data-event="<?= htmlspecialchars($item['event_name'] ?? '-') ?>"
                                        data-titipers="<?= htmlspecialchars($item['titipers_name'] ?? '-') ?>"
                                        data-image="<?= !empty($item['image']) ? base_url('uploads/items/' . $item['image']) : '' ?>"
                                        data-price="Rp <?= number_format($item['starting_price'], 0, ',', '.') ?>"
                                        data-note="<?= htmlspecialchars($item['admin_note'] ?? '') ?>">
                                        <i class="fas fa-check"></i> Verify
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>No items found.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Verify Modal -->
<div class="modal" id="verifyModal" tabindex="-1">
    <div class="modal-overlay" data-dismiss="modal"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Verify Item</h3>
            <button class="modal-close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="verify-detail">
                <div class="verify-image" id="verifyImage"></div>
                <div class="verify-info">
                    <h4 id="verifyName"></h4>
                    <p><strong>Event:</strong> <span id="verifyEvent"></span></p>
                    <p><strong>Titipers:</strong> <span id="verifyTitipers"></span></p>
                    <p><strong>Starting Price:</strong> <span id="verifyPrice"></span></p>
                </div>
            </div>
            <form id="verifyForm" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="item_id" id="verifyItemId">
                <div class="form-group">
                    <label for="admin_note">Admin Note</label>
                    <textarea id="admin_note" name="admin_note" class="form-control" rows="3" placeholder="Optional note for the titipers..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" name="status" value="rejected" class="btn btn-danger"><i class="fas fa-times"></i> Reject</button>
                    <button type="submit" name="status" value="approved" class="btn btn-success"><i class="fas fa-check"></i> Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('[data-target="#verifyModal"]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('verifyItemId').value = this.dataset.id;
        document.getElementById('verifyName').textContent = this.dataset.name;
        document.getElementById('verifyEvent').textContent = this.dataset.event;
        document.getElementById('verifyTitipers').textContent = this.dataset.titipers;
        document.getElementById('verifyPrice').textContent = this.dataset.price;
        document.getElementById('verifyForm').action = '<?= site_url('admin/items_verify/') ?>' + this.dataset.id;

        var imgContainer = document.getElementById('verifyImage');
        if (this.dataset.image) {
            imgContainer.innerHTML = '<img src="' + this.dataset.image + '" alt="Item">';
            imgContainer.style.display = 'block';
        } else {
            imgContainer.innerHTML = '<div class="no-image"><i class="fas fa-image"></i></div>';
            imgContainer.style.display = 'block';
        }
    });
});

document.querySelectorAll('[data-dismiss="modal"]').forEach(function(el) {
    el.addEventListener('click', function() {
        document.getElementById('verifyModal').classList.remove('active');
    });
});

document.querySelectorAll('[data-toggle="modal"]').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var target = document.querySelector(this.dataset.target);
        if (target) target.classList.add('active');
    });
});
</script>
