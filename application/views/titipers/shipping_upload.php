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
    .shipping-info-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .shipping-info-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: rgba(59, 130, 246, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--info);
        flex-shrink: 0;
    }
    .shipping-info-details {
        flex: 1;
        min-width: 200px;
    }
    .shipping-info-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .shipping-info-meta {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 4px;
    }
    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 32px;
        max-width: 540px;
    }
    .form-group {
        margin-bottom: 24px;
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
        padding: 32px 20px;
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
        margin-top: 16px;
        display: none;
        position: relative;
    }
    .image-preview img {
        max-width: 280px;
        max-height: 200px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
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
        box-shadow: 0 4px 15px var(--accent-glow);
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
    .form-actions {
        display: flex;
        gap: 12px;
    }
    .form-note {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 24px;
        font-size: 0.82rem;
        color: var(--info);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-error-list {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 24px;
        color: var(--danger);
        font-size: 0.85rem;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-shipping-fast"></i> Upload Bukti Kirim</h1>
</div>

<?php if (validation_errors()): ?>
    <div class="form-error-list">
        <?= validation_errors() ?>
    </div>
<?php endif; ?>

<div class="shipping-info-card">
    <div class="shipping-info-icon"><i class="fas fa-truck"></i></div>
    <div class="shipping-info-details">
        <div class="shipping-info-name"><?= $shipping['item_name'] ?></div>
        <div class="shipping-info-meta">
            Status: <?= str_replace('_', ' ', ucfirst($shipping['status'])) ?>
            &middot; Harga: Rp <?= number_format($shipping['win_amount'], 0, ',', '.') ?>
        </div>
    </div>
</div>

<div class="form-note">
    <i class="fas fa-info-circle"></i>
    Upload bukti pengiriman berupa foto/resi pembayaran. Format yang didukung: JPG, PNG, GIF, PDF.
</div>

<div class="form-card">
    <?= form_open_multipart('titipers/shipping_upload/' . $shipping['id']) ?>
        <div class="form-group">
            <label>Bukti Pengiriman</label>
            <div class="file-upload-area" id="uploadArea">
                <input type="file" name="shipping_proof" id="proofInput" accept="image/jpeg,image/png,image/gif,application/pdf" required>
                <div class="upload-icon"><i class="fas fa-file-upload"></i></div>
                <div class="upload-text">Klik atau seret bukti kirim ke sini</div>
                <div class="upload-hint">Format: JPG, PNG, GIF, PDF. Maks 2MB.</div>
            </div>
            <div class="image-preview" id="proofPreview">
                <img id="previewImg" src="" alt="Preview">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Upload Bukti</button>
            <a href="<?= site_url('titipers/shipping') ?>" class="btn btn-outline">Kembali</a>
        </div>
    <?= form_close() ?>
</div>

<script>
document.getElementById('proofInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('proofPreview').style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
