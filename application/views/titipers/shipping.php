<style>
    .page-header {
        margin-bottom: 32px;
    }
    .page-header h1 {
        font-family: 'Orbitron', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-header h1 i { color: var(--accent-secondary); }
    .page-header p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-top: 6px;
    }
    .shipping-table-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    .shipping-table {
        width: 100%;
        border-collapse: collapse;
    }
    .shipping-table thead {
        background: var(--bg-secondary);
    }
    .shipping-table th {
        padding: 14px 16px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }
    .shipping-table td {
        padding: 14px 16px;
        font-size: 0.85rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    .shipping-table tbody tr {
        transition: background 0.2s ease;
    }
    .shipping-table tbody tr:hover {
        background: var(--bg-hover);
    }
    .shipping-table tbody tr:last-child td {
        border-bottom: none;
    }
    .item-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .item-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-hover);
        flex-shrink: 0;
    }
    .item-cell-name {
        font-weight: 600;
        color: var(--text-primary);
    }
    .item-cell-event {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .badge-pending { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .badge-shipped { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .badge-in_transit { background: rgba(168, 85, 247, 0.15); color: var(--accent-secondary); }
    .badge-delivered { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: none;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        color: #fff;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px var(--accent-glow);
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
    }
    .proof-link {
        color: var(--accent-secondary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .proof-link:hover {
        text-decoration: underline;
    }
    .timeline {
        display: flex;
        align-items: center;
        gap: 0;
        padding: 4px 0;
    }
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
    }
    .timeline-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--border-color);
        margin-bottom: 6px;
        z-index: 1;
    }
    .timeline-dot.active {
        background: var(--accent-secondary);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .timeline-dot.done {
        background: var(--success);
    }
    .timeline-line {
        position: absolute;
        top: 5px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: var(--border-color);
        z-index: 0;
    }
    .timeline-step:last-child .timeline-line {
        display: none;
    }
    .timeline-label {
        font-size: 0.6rem;
        color: var(--text-muted);
        text-align: center;
        white-space: nowrap;
    }
    .price-text {
        font-weight: 600;
        color: var(--success);
    }
    .date-text {
        color: var(--text-muted);
        font-size: 0.8rem;
    }
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
        opacity: 0.4;
    }
    .empty-state p {
        font-size: 0.9rem;
    }
    .table-responsive {
        overflow-x: auto;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-content {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 32px;
        width: 100%;
        max-width: 480px;
        margin: 20px;
        animation: modalIn 0.3s ease;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .modal-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .modal-close {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s ease;
    }
    .modal-close:hover {
        color: var(--text-primary);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .file-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .file-upload-area:hover {
        border-color: var(--accent-primary);
        background: rgba(124, 58, 237, 0.05);
    }
    .file-upload-area input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .upload-icon {
        font-size: 2rem;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
    .upload-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .upload-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 4px;
    }
    .image-preview {
        margin-top: 12px;
        display: none;
        position: relative;
    }
    .image-preview img {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-truck"></i> Pengiriman</h1>
    <p>Kelola pengiriman barang yang sudah terjual. Upload bukti kirim setelah admin memberikan notifikasi.</p>
</div>

<?php if (!empty($shipping)): ?>
    <div class="shipping-table-wrapper">
        <div class="table-responsive">
            <table class="shipping-table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Pembeli</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Bukti Kirim</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shipping as $ship): ?>
                        <tr>
                            <td>
                                <div class="item-cell">
                                    <?php if (!empty($ship['item_image'])): ?>
                                        <img src="<?= base_url('uploads/items/' . $ship['item_image']) ?>" alt="<?= $ship['item_name'] ?>" class="item-thumb" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
                                    <?php else: ?>
                                        <div class="item-thumb" style="display:flex;align-items:center;justify-content:center;color:var(--text-muted);"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="item-cell-name"><?= $ship['item_name'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($ship['bidders_name'])): ?>
                                    <?= $ship['bidders_name'] ?>
                                <?php else: ?>
                                    <span style="color:var(--text-muted);">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="price-text">Rp <?= number_format($ship['win_amount'], 0, ',', '.') ?></td>
                            <td><span class="badge badge-<?= $ship['status'] ?>"><?= str_replace('_', ' ', ucfirst($ship['status'])) ?></span></td>
                            <td>
                                <?php if (!empty($ship['shipping_proof'])): ?>
                                    <a href="<?= base_url('uploads/shipping/' . $ship['shipping_proof']) ?>" target="_blank" class="proof-link"><i class="fas fa-file-alt"></i> Lihat</a>
                                <?php else: ?>
                                    <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $statuses = ['pending', 'shipped', 'in_transit', 'delivered'];
                                $current_idx = array_search($ship['status'], $statuses);
                                if ($current_idx === FALSE) $current_idx = -1;
                                ?>
                                <div class="timeline">
                                    <?php foreach ($statuses as $idx => $s): ?>
                                        <div class="timeline-step">
                                            <div class="timeline-dot <?= $idx < $current_idx ? 'done' : ($idx == $current_idx ? 'active' : '') ?>"></div>
                                            <?php if ($idx < count($statuses) - 1): ?>
                                                <div class="timeline-line"></div>
                                            <?php endif; ?>
                                            <div class="timeline-label"><?= str_replace('_', ' ', ucfirst($s)) ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($ship['status'] == 'pending'): ?>
                                    <span class="btn btn-outline" style="opacity:0.5; cursor:default;">
                                        <i class="fas fa-hourglass-half"></i> Menunggu
                                    </span>
                                <?php elseif ($ship['status'] == 'shipped'): ?>
                                    <span class="btn btn-outline" style="opacity:0.5; cursor:default;">
                                        <i class="fas fa-check-circle"></i> Terkirim
                                    </span>
                                <?php else: ?>
                                    <span class="btn btn-outline" style="opacity:0.5; cursor:default;">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="empty-state" style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:12px;">
        <i class="fas fa-truck"></i>
        <p>Belum ada data pengiriman.</p>
    </div>
<?php endif; ?>

<div class="modal-overlay" id="uploadModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-upload" style="color:var(--accent-secondary);margin-right:8px;"></i> Upload Bukti Kirim</h3>
            <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="uploadForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
            <input type="hidden" name="shipping_id" id="modalShippingId">
            <div class="form-group">
                <label>Bukti Pengiriman</label>
                <div class="file-upload-area" id="modalUploadArea">
                    <input type="file" name="shipping_proof" id="modalProofInput" accept="image/jpeg,image/png,image/gif,application/pdf" required>
                    <div class="upload-icon"><i class="fas fa-shipping-fast"></i></div>
                    <div class="upload-text">Klik atau seret bukti kirim</div>
                    <div class="upload-hint">Format: JPG, PNG, GIF, PDF. Maks 2MB.</div>
                </div>
                <div class="image-preview" id="modalPreview">
                    <img id="modalPreviewImg" src="" alt="Preview">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Upload</button>
                <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function openUploadModal(shippingId) {
    document.getElementById('modalShippingId').value = shippingId;
    document.getElementById('uploadForm').action = '<?= site_url('titipers/shipping_upload/') ?>' + shippingId;
    document.getElementById('uploadModal').classList.add('active');
}

function closeModal() {
    document.getElementById('uploadModal').classList.remove('active');
    document.getElementById('modalProofInput').value = '';
    document.getElementById('modalPreview').style.display = 'none';
    document.getElementById('modalPreviewImg').src = '';
}

document.getElementById('modalProofInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('modalPreviewImg').src = e.target.result;
            document.getElementById('modalPreview').style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});

document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
