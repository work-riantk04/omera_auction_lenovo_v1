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
    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 32px;
        max-width: 640px;
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
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        transition: border-color 0.2s ease;
        outline: none;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238888a0' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }
    .form-group select option {
        background: var(--bg-secondary);
        color: var(--text-primary);
    }
    .form-error {
        color: var(--danger);
        font-size: 0.78rem;
        margin-top: 6px;
    }
    .form-help {
        color: var(--text-muted);
        font-size: 0.78rem;
        margin-top: 6px;
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
    .file-upload-area .upload-icon {
        font-size: 2rem;
        color: var(--text-muted);
        margin-bottom: 8px;
    }
    .file-upload-area .upload-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .file-upload-area .upload-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 4px;
    }
    .image-preview {
        margin-top: 16px;
        position: relative;
    }
    .image-preview img {
        max-width: 280px;
        max-height: 200px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }
    .image-preview .remove-preview {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    .current-image-label {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 8px;
        display: block;
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
        margin-right: 8px;
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
    }
    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 8px;
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
    <h1><i class="fas fa-edit"></i> Edit Barang</h1>
</div>

<?php if (validation_errors()): ?>
    <div class="form-error-list">
        <?= validation_errors() ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <?= form_open_multipart('titipers/items_edit/' . $item['id']) ?>
        <div class="form-group">
            <label for="name">Nama Barang</label>
            <input type="text" name="name" id="name" value="<?= set_value('name', $item['name']) ?>" placeholder="Masukkan nama barang" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>
            <select name="category" id="category" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="electronics" <?= set_select('category', 'electronics', ($item['category'] == 'electronics')) ?>>Elektronik</option>
                <option value="fashion" <?= set_select('category', 'fashion', ($item['category'] == 'fashion')) ?>>Fashion</option>
                <option value="accessories" <?= set_select('category', 'accessories', ($item['category'] == 'accessories')) ?>>Aksesoris</option>
                <option value="collectibles" <?= set_select('category', 'collectibles', ($item['category'] == 'collectibles')) ?>>Collectibles</option>
                <option value="home" <?= set_select('category', 'home', ($item['category'] == 'home')) ?>>Rumah Tangga</option>
                <option value="other" <?= set_select('category', 'other', ($item['category'] == 'other')) ?>>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" placeholder="Deskripsikan barang Anda secara detail..." required><?= set_value('description', $item['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto Barang</label>
            <?php if (!empty($item['image'])): ?>
                <span class="current-image-label">Foto saat ini:</span>
                <div class="image-preview" id="currentImagePreview">
                    <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= $item['name'] ?>">
                </div>
            <?php endif; ?>
            <div class="file-upload-area" id="uploadArea" style="margin-top:12px;">
                <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/gif">
                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <div class="upload-text">Klik untuk mengganti foto</div>
                <div class="upload-hint">Format: JPG, PNG, GIF. Maks 2MB. Kosongkan jika tidak ingin mengubah.</div>
            </div>
            <div class="image-preview" id="newImagePreview" style="display:none;">
                <img id="previewImg" src="" alt="Preview baru">
                <button type="button" class="remove-preview" id="removePreview"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="form-group">
            <label for="starting_price">Harga Mulai (Rp)</label>
            <input type="number" name="starting_price" id="starting_price" value="<?= set_value('starting_price', $item['starting_price']) ?>" min="0" step="1000" placeholder="0" required>
            <div class="form-help">Harga minimum yang ditawarkan saat lelang dimulai.</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="<?= site_url('titipers/items') ?>" class="btn btn-outline">Batal</a>
        </div>
    <?= form_close() ?>
</div>

<script>
(function() {
    var input = document.getElementById('imageInput');
    var newPreview = document.getElementById('newImagePreview');
    var previewImg = document.getElementById('previewImg');
    var removeBtn = document.getElementById('removePreview');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                newPreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    removeBtn.addEventListener('click', function() {
        input.value = '';
        newPreview.style.display = 'none';
        previewImg.src = '';
    });
})();
</script>
