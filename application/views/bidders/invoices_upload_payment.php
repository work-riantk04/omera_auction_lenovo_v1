<?= $this->load->view('templates/bidders/header', [], TRUE) ?>

<div class="upload-payment-page">
    <div class="upload-topbar">
        <a href="<?= site_url('bidders/invoices_detail/' . $invoice['id']) ?>" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Detail Invoice</a>
    </div>

    <div class="upload-grid">
        <div class="upload-main-card">
            <h2 class="upload-title"><i class="fas fa-receipt"></i> Invoice #<?= str_pad($invoice['id'], 5, '0', STR_PAD_LEFT) ?></h2>

            <div class="upload-info-grid">
                <div class="upload-info-item">
                    <span class="info-label">Event</span>
                    <span class="info-value"><?= htmlspecialchars($invoice['event_name'] ?? '-') ?></span>
                </div>
                <div class="upload-info-item">
                    <span class="info-label">Item</span>
                    <span class="info-value"><?= htmlspecialchars($invoice['item_name'] ?? '-') ?></span>
                </div>
                <div class="upload-info-item">
                    <span class="info-label">Jumlah</span>
                    <span class="info-value info-amount">Rp <?= number_format($invoice['win_amount'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <div class="upload-sidebar">
            <div class="upload-form-card">
                <h3 class="section-title"><i class="fas fa-cloud-upload-alt"></i> Upload Bukti Pembayaran</h3>

                <form action="<?= site_url('bidders/invoices_upload_payment/' . $invoice['id']) ?>" method="POST" enctype="multipart/form-data" id="paymentUploadForm">
                    <?= csrf_field() ?>

                    <div class="file-upload-area" id="uploadArea">
                        <input type="file" name="payment_proof" id="paymentFile" accept="image/*" style="display:none;" onchange="handleFileSelect(this)">
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik atau seret gambar ke sini</p>
                            <small>JPG, PNG (Maks 2MB)</small>
                        </div>
                        <div class="upload-preview" id="uploadPreview" style="display:none;">
                            <img id="previewImg" src="" alt="Preview">
                            <div class="preview-info">
                                <span id="previewName" class="preview-filename"></span>
                                <button type="button" class="remove-file" onclick="removeFile()"><i class="fas fa-times"></i> Hapus</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-payment" id="submitPayment" disabled>
                        <i class="fas fa-upload"></i> Upload &amp; Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.upload-payment-page { max-width: 900px; }

.upload-topbar {
    margin-bottom: 28px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #8b949e;
    text-decoration: none;
    transition: color 0.2s;
}
.back-link:hover { color: #00d4ff; }

.upload-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: start;
}

.upload-main-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    padding: 24px;
}

.upload-title {
    font-family: 'Orbitron', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #e6edf3;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.upload-title i { color: #00d4ff; }

.upload-info-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.upload-info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 12px 16px;
    background: #0d1117;
    border-radius: 10px;
    border: 1px solid #21262d;
}
.info-label { font-size: 0.72rem; color: #8b949e; text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.9rem; color: #e6edf3; font-weight: 500; }
.info-amount { font-family: 'Orbitron', sans-serif; color: #ffd700; font-size: 1rem; font-weight: 700; }

.upload-sidebar {
    display: flex;
    flex-direction: column;
}

.upload-form-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    padding: 24px;
}

.section-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8b949e;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.section-title i { font-size: 0.8rem; color: #00d4ff; }

.file-upload-area {
    border: 2px dashed #21262d;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 16px;
}

.file-upload-area:hover,
.file-upload-area.dragover {
    border-color: #00d4ff;
    background: rgba(0,212,255,0.04);
}

.upload-placeholder i { font-size: 2.5rem; color: #21262d; margin-bottom: 12px; display: block; }
.upload-placeholder p { font-size: 0.9rem; color: #8b949e; margin-bottom: 4px; }
.upload-placeholder small { font-size: 0.75rem; color: #484f58; }

.upload-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.upload-preview img {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #21262d;
}
.preview-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.preview-filename { font-size: 0.82rem; color: #e6edf3; word-break: break-all; }
.remove-file {
    background: rgba(248,81,73,0.1);
    border: 1px solid rgba(248,81,73,0.2);
    border-radius: 6px;
    color: #f85149;
    cursor: pointer;
    font-size: 0.78rem;
    padding: 4px 10px;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
    flex-shrink: 0;
    margin-left: 10px;
}
.remove-file:hover { background: rgba(248,81,73,0.2); }

.btn-submit-payment {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #00d4ff, #00b4d8);
    color: #0d1117;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-submit-payment:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,212,255,0.3); }
.btn-submit-payment:disabled { opacity: 0.4; cursor: not-allowed; }

@media (max-width: 768px) {
    .upload-grid { grid-template-columns: 1fr; }
}
</style>

<script>
var fileInput = document.getElementById('paymentFile');
var uploadArea = document.getElementById('uploadArea');

if (uploadArea) {
    uploadArea.addEventListener('click', function() { fileInput.click(); });
    uploadArea.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('dragover'); });
    uploadArea.addEventListener('dragleave', function() { this.classList.remove('dragover'); });
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(fileInput);
        }
    });
}

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var placeholder = document.getElementById('uploadPlaceholder');
        var preview = document.getElementById('uploadPreview');
        var previewImg = document.getElementById('previewImg');
        var previewName = document.getElementById('previewName');
        var submitBtn = document.getElementById('submitPayment');

        placeholder.style.display = 'none';
        preview.style.display = 'flex';
        previewName.textContent = file.name;
        submitBtn.disabled = false;

        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) { previewImg.src = e.target.result; };
            reader.readAsDataURL(file);
        }
    }
}

function removeFile() {
    var fi = document.getElementById('paymentFile');
    var placeholder = document.getElementById('uploadPlaceholder');
    var preview = document.getElementById('uploadPreview');
    var submitBtn = document.getElementById('submitPayment');

    fi.value = '';
    placeholder.style.display = '';
    preview.style.display = 'none';
    submitBtn.disabled = true;
}
</script>

<?= $this->load->view('templates/bidders/footer', [], TRUE) ?>
