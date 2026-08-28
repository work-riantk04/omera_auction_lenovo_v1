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
    .multi-preview {
        margin-top: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .multi-preview .preview-item {
        position: relative;
        width: 120px;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }
    .multi-preview .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .multi-preview .preview-item .remove-preview {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        line-height: 1;
    }
    .multi-preview .preview-empty {
        color: var(--text-muted);
        font-size: 0.8rem;
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
    <h1><i class="fas fa-plus-circle"></i> Tambah Barang</h1>
</div>

<?php if (validation_errors()): ?>
    <div class="form-error-list">
        <?= validation_errors() ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <?= form_open_multipart('titipers/items_add') ?>
        <div class="form-group">
            <label for="name">Nama Barang</label>
            <input type="text" name="name" id="name" value="<?= set_value('name') ?>" placeholder="Masukkan nama barang" required>
        </div>

        <div class="form-group">
            <label for="category">Kategori</label>
            <select name="category" id="category" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="electronics" <?= set_select('category', 'electronics') ?>>Elektronik</option>
                <option value="fashion" <?= set_select('category', 'fashion') ?>>Fashion</option>
                <option value="accessories" <?= set_select('category', 'accessories') ?>>Aksesoris</option>
                <option value="collectibles" <?= set_select('category', 'collectibles') ?>>Collectibles</option>
                <option value="home" <?= set_select('category', 'home') ?>>Rumah Tangga</option>
                <option value="other" <?= set_select('category', 'other') ?>>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" placeholder="Deskripsikan barang Anda secara detail..." required><?= set_value('description') ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagesInput">Foto Barang (bisa lebih dari satu)</label>
            <div class="file-upload-area" id="uploadArea">
                <input type="file" name="images[]" id="imagesInput" accept="image/jpeg,image/png,image/gif" multiple>
                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <div class="upload-text">Klik atau seret foto ke sini</div>
                <div class="upload-hint">Format: JPG, PNG, GIF. Maks 2MB per file. Bisa pilih banyak sekaligus.</div>
            </div>
            <div class="multi-preview" id="multiPreview"></div>
        </div>

        <div class="form-group">
            <label for="starting_price">Harga Mulai (Rp)</label>
            <input type="number" name="starting_price" id="starting_price" value="<?= set_value('starting_price') ?>" min="0" step="1000" placeholder="0" required>
            <div class="form-help">Harga minimum yang ditawarkan saat lelang dimulai.</div>
        </div>

        <div class="form-group">
            <label for="min_increment">Harga Kenaikan Minimal (Rp)</label>
            <input type="number" name="min_increment" id="min_increment" value="<?= set_value('min_increment') ?>" min="0" step="100" placeholder="0">
            <div class="form-help">
                Kelipatan bid minimum. Contoh: harga mulai 5000 dan kenaikan 500, maka bidders wajib bid 5500 / 6000 / 6500 / dst.
                Kosongkan atau isi 0 jika tidak ingin membatasi.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Barang</button>
            <a href="<?= site_url('titipers/items') ?>" class="btn btn-outline">Batal</a>
        </div>
    <?= form_close() ?>
</div>

<script>
(function() {
    var input = document.getElementById('imagesInput');
    var container = document.getElementById('multiPreview');

    input.addEventListener('change', function() {
        container.innerHTML = '';
        var files = Array.prototype.slice.call(this.files || []);
        if (files.length === 0) {
            container.innerHTML = '<span class="preview-empty">Belum ada foto dipilih.</span>';
            return;
        }
        files.forEach(function(file) {
            if (!/^image\//.test(file.type)) return;
            var item = document.createElement('div');
            item.className = 'preview-item';
            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-preview';
            btn.innerHTML = '<i class="fas fa-times"></i>';
            btn.addEventListener('click', function() {
                item.remove();
                var dt = new DataTransfer();
                var remaining = Array.prototype.slice.call(input.files).filter(function(f) { return f !== file; });
                remaining.forEach(function(f) { dt.items.add(f); });
                input.files = dt.files;
                if (!remaining.length) {
                    container.innerHTML = '<span class="preview-empty">Belum ada foto dipilih.</span>';
                }
            });
            item.appendChild(img);
            item.appendChild(btn);
            container.appendChild(item);
        });
    });
})();
</script>
