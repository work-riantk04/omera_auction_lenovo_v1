<?php
$inv = $invoice;
$status = $inv['payment_status'];
$item_image = !empty($inv['item_image']) ? base_url('uploads/items/' . $inv['item_image']) : base_url('assets/images/default-item.jpg');
$shipping = !empty($inv['shipping_id']) ? $this->Shipping_model->get_by_id($inv['shipping_id']) : null;
if (!$shipping) {
    $this->load->model('Shipping_model');
    $shipping = $this->Shipping_model->get_by_invoice_id($inv['id']);
}
?>

<div class="inv-detail-page">
    <div class="inv-topbar">
        <a href="<?= site_url('bidders/invoices') ?>" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Invoice</a>
        <button class="btn-print" onclick="window.print()"><i class="fas fa-print"></i> Cetak Invoice</button>
    </div>

    <div class="inv-detail-grid">
        <div class="inv-main-card">
            <div class="inv-header">
                <div class="inv-header-left">
                    <h2 class="inv-number">Invoice #<?= str_pad($inv['id'], 5, '0', STR_PAD_LEFT) ?></h2>
                    <span class="inv-date">Diterbitkan: <?= date('d M Y H:i', strtotime($inv['created_at'])) ?></span>
                </div>
                <div class="inv-header-right">
                    <?php if ($status === 'unpaid'): ?>
                        <span class="inv-status-badge inv-unpaid"><i class="fas fa-exclamation-circle"></i> Belum Bayar</span>
                    <?php elseif ($status === 'paid'): ?>
                        <span class="inv-status-badge inv-paid"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                    <?php elseif ($status === 'verified'): ?>
                        <span class="inv-status-badge inv-verified"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                    <?php elseif ($status === 'rejected'): ?>
                        <span class="inv-status-badge inv-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="inv-item-section">
                <h3 class="section-title"><i class="fas fa-box"></i> Detail Item</h3>
                <div class="inv-item-card">
                    <img src="<?= $item_image ?>" alt="" class="inv-item-img" onerror="this.src='<?= base_url('assets/images/default-item.jpg') ?>'">
                    <div class="inv-item-info">
                        <h4><?= htmlspecialchars($inv['item_name'] ?? '-') ?></h4>
                        <p class="inv-item-event"><i class="fas fa-calendar"></i> <?= htmlspecialchars($inv['event_name'] ?? '-') ?></p>
                    </div>
                    <div class="inv-item-amount">
                        <span class="amount-label">Jumlah Menang</span>
                        <span class="amount-value">Rp <?= number_format($inv['win_amount'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>

            <div class="inv-bidder-section">
                <h3 class="section-title"><i class="fas fa-user"></i> Informasi Pembeli</h3>
                <div class="inv-info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama</span>
                        <span class="info-value"><?= htmlspecialchars($inv['bidder_name'] ?? '-') ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?= htmlspecialchars($inv['bidder_email'] ?? '-') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="inv-sidebar">
            <div class="inv-total-card">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-amount">Rp <?= number_format($inv['win_amount'], 0, ',', '.') ?></span>
            </div>

            <?php if ($status === 'unpaid'): ?>
                <div class="inv-payment-card">
                    <h3 class="section-title"><i class="fas fa-credit-card"></i> Upload Bukti Bayar</h3>
                    <form action="<?= site_url('bidders/invoices_upload_payment/' . $inv['id']) ?>" method="POST" enctype="multipart/form-data" id="paymentForm">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <div class="file-upload-area" id="uploadArea">
                            <input type="file" name="payment_proof" id="paymentFile" accept="image/*,.pdf" style="display:none;" onchange="handleFileSelect(this)">
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik atau seret file ke sini</p>
                                <small>JPG, PNG, atau PDF (Maks 2MB)</small>
                            </div>
                            <div class="upload-preview" id="uploadPreview" style="display:none;">
                                <img id="previewImg" src="" alt="">
                                <span id="previewName"></span>
                                <button type="button" class="remove-file" onclick="removeFile()"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit-payment" id="submitPayment" disabled>
                            <i class="fas fa-upload"></i> Upload & Kirim
                        </button>
                    </form>
                </div>
            <?php elseif ($status === 'paid'): ?>
                <div class="inv-payment-card">
                    <div class="payment-waiting">
                        <div class="waiting-icon"><i class="fas fa-hourglass-half"></i></div>
                        <h3>Menunggu Verifikasi</h3>
                        <p>Bukti bayar Anda sedang diverifikasi oleh admin. Mohon tunggu.</p>
                    </div>
                    <?php if (!empty($inv['payment_proof'])): ?>
                        <div class="proof-display">
                            <span class="proof-label">Bukti Bayar yang Diupload:</span>
                            <a href="<?= base_url('uploads/payments/' . $inv['payment_proof']) ?>" target="_blank" class="proof-link">
                                <i class="fas fa-image"></i> Lihat Bukti
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif ($status === 'verified'): ?>
                <div class="inv-payment-card payment-verified">
                    <div class="verified-icon"><i class="fas fa-check-circle"></i></div>
                    <h3>Pembayaran Terverifikasi</h3>
                    <p>Pembayaran Anda telah dikonfirmasi. Silakan cek status pengiriman.</p>
                </div>
            <?php elseif ($status === 'rejected'): ?>
                <div class="inv-payment-card payment-rejected">
                    <div class="rejected-icon"><i class="fas fa-times-circle"></i></div>
                    <h3>Pembayaran Ditolak</h3>
                    <p>Bukti bayar Anda ditolak. Silakan upload ulang.</p>
                    <a href="<?= site_url('bidders/invoices_detail/' . $inv['id']) ?>" class="btn-retry"><i class="fas fa-redo"></i> Upload Ulang</a>
                </div>
            <?php endif; ?>

            <?php if ($status === 'verified' && $shipping): ?>
                <div class="inv-shipping-card">
                    <h3 class="section-title"><i class="fas fa-truck"></i> Status Pengiriman</h3>
                    <div class="shipping-timeline">
                        <?php
                        $steps = ['pending' => 'Menunggu', 'shipping' => 'Dikirim', 'delivered' => 'Diterima', 'verified' => 'Terverifikasi'];
                        $ship_status = $shipping['status'];
                        ?>
                        <?php foreach ($steps as $key => $label): ?>
                            <?php
                            $step_index = array_search($key, array_keys($steps));
                                $current_index = array_search($ship_status, array_keys($steps));
                                $is_done = ($step_index <= $current_index);
                                $is_current = ($key === $ship_status);
                            ?>
                            <div class="timeline-step <?= $is_done ? 'step-done' : '' ?> <?= $is_current ? 'step-current' : '' ?>">
                                <div class="step-dot"></div>
                                <div class="step-content">
                                    <span class="step-label"><?= $label ?></span>
                                    <?php if ($is_current && $shipping['shipped_at']): ?>
                                        <span class="step-date"><?= date('d M Y', strtotime($shipping['shipped_at'])) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($shipping['titipers_name'])): ?>
                        <div class="shipping-info">
                            <span class="info-label">Dikirim oleh</span>
                            <span class="info-value"><?= htmlspecialchars($shipping['titipers_name']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($shipping['shipping_proof'])): ?>
                        <a href="<?= base_url('uploads/shipping/' . $shipping['shipping_proof']) ?>" target="_blank" class="btn-shipping-proof">
                            <i class="fas fa-file-alt"></i> Lihat Bukti Kirim
                        </a>
                    <?php endif; ?>

                    <?php if ($ship_status === 'shipping'): ?>
                        <form action="<?= site_url('bidders/invoices_confirm_delivery/' . $inv['id']) ?>" method="POST" style="margin-top:12px;">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <button type="submit" class="btn-confirm-delivery" onclick="return confirm('Konfirmasi bahwa Anda telah menerima barang?')">
                                <i class="fas fa-box-open"></i> Barang Diterima
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.inv-detail-page { max-width: 1100px; }

.inv-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
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

.btn-print {
    padding: 8px 18px;
    border-radius: 8px;
    border: 1px solid #21262d;
    background: #161b22;
    color: #8b949e;
    font-size: 0.82rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-print:hover { border-color: #30363d; color: #e6edf3; }

.inv-detail-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
}

.inv-main-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    overflow: hidden;
}

.inv-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid #21262d;
    flex-wrap: wrap;
    gap: 12px;
}

.inv-number {
    font-family: 'Orbitron', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #e6edf3;
}

.inv-date { font-size: 0.82rem; color: #8b949e; display: block; margin-top: 4px; }

.inv-status-badge {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.inv-unpaid { background: rgba(248,81,73,0.12); color: #f85149; }
.inv-paid { background: rgba(210,153,34,0.12); color: #d29922; }
.inv-verified { background: rgba(63,185,80,0.12); color: #3fb950; }
.inv-rejected { background: rgba(248,81,73,0.12); color: #f85149; }

.section-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8b949e;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.section-title i { font-size: 0.8rem; }

.inv-item-section, .inv-bidder-section {
    padding: 24px;
    border-bottom: 1px solid #21262d;
}
.inv-bidder-section { border-bottom: none; }

.inv-item-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: #0d1117;
    border-radius: 12px;
    border: 1px solid #21262d;
}

.inv-item-img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #21262d;
}

.inv-item-info { flex: 1; }
.inv-item-info h4 { font-size: 1rem; font-weight: 600; color: #e6edf3; margin-bottom: 4px; }
.inv-item-event { font-size: 0.82rem; color: #8b949e; display: flex; align-items: center; gap: 6px; }

.inv-item-amount { text-align: right; }
.amount-label { font-size: 0.75rem; color: #8b949e; display: block; margin-bottom: 4px; }
.amount-value { font-family: 'Orbitron', sans-serif; font-size: 1.1rem; font-weight: 700; color: #ffd700; }

.inv-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.info-label { font-size: 0.75rem; color: #8b949e; text-transform: uppercase; letter-spacing: 0.5px; }
.info-value { font-size: 0.9rem; color: #e6edf3; font-weight: 500; }

.inv-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.inv-total-card {
    background: linear-gradient(135deg, #161b22 0%, #1a1f2e 100%);
    border: 1px solid #21262d;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.inv-total-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #ffd700, #f0b400);
}

.total-label { font-size: 0.78rem; color: #8b949e; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 8px; }
.total-amount { font-family: 'Orbitron', sans-serif; font-size: 1.5rem; font-weight: 700; color: #ffd700; }

.inv-payment-card, .inv-shipping-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    padding: 24px;
}

.file-upload-area {
    border: 2px dashed #21262d;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 16px;
}

.file-upload-area:hover, .file-upload-area.dragover {
    border-color: #00d4ff;
    background: rgba(0,212,255,0.04);
}

.upload-placeholder i { font-size: 2.5rem; color: #21262d; margin-bottom: 12px; display: block; }
.upload-placeholder p { font-size: 0.9rem; color: #8b949e; margin-bottom: 4px; }
.upload-placeholder small { font-size: 0.75rem; color: #484f58; }

.upload-preview {
    display: flex;
    align-items: center;
    gap: 12px;
}
.upload-preview img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #21262d; }
.upload-preview span { flex: 1; font-size: 0.85rem; color: #e6edf3; word-break: break-all; }
.remove-file { background: none; border: none; color: #f85149; cursor: pointer; font-size: 1rem; padding: 4px; }

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

.payment-waiting, .payment-verified, .payment-rejected {
    text-align: center;
    padding: 20px 0;
}
.waiting-icon, .verified-icon, .rejected-icon { font-size: 2.5rem; margin-bottom: 12px; }
.waiting-icon { color: #d29922; }
.verified-icon { color: #3fb950; }
.rejected-icon { color: #f85149; }
.payment-waiting h3, .payment-verified h3, .payment-rejected h3 { font-size: 1rem; color: #e6edf3; margin-bottom: 6px; }
.payment-waiting p, .payment-verified p, .payment-rejected p { font-size: 0.82rem; color: #8b949e; line-height: 1.5; }

.proof-display {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #21262d;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.proof-label { font-size: 0.8rem; color: #8b949e; }
.proof-link { font-size: 0.82rem; color: #00d4ff; text-decoration: none; display: flex; align-items: center; gap: 6px; }
.proof-link:hover { text-decoration: underline; }

.btn-retry {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 12px;
    padding: 8px 16px;
    background: rgba(248,81,73,0.1);
    border: 1px solid rgba(248,81,73,0.2);
    border-radius: 8px;
    color: #f85149;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.2s;
}
.btn-retry:hover { background: rgba(248,81,73,0.2); }

.shipping-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-bottom: 16px;
}

.timeline-step {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 12px 0;
    position: relative;
}

.timeline-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 7px;
    top: 28px;
    bottom: -4px;
    width: 2px;
    background: #21262d;
}

.timeline-step.step-done:not(:last-child)::after {
    background: #3fb950;
}

.step-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #21262d;
    border: 2px solid #21262d;
    flex-shrink: 0;
    margin-top: 2px;
}

.step-done .step-dot { background: #3fb950; border-color: #3fb950; }
.step-current .step-dot { box-shadow: 0 0 0 4px rgba(63,185,80,0.2); }

.step-content { display: flex; flex-direction: column; }
.step-label { font-size: 0.85rem; color: #8b949e; font-weight: 500; }
.step-done .step-label, .step-current .step-label { color: #e6edf3; }
.step-date { font-size: 0.72rem; color: #8b949e; margin-top: 2px; }

.shipping-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 12px;
    background: #0d1117;
    border-radius: 8px;
    margin-bottom: 12px;
}

.btn-shipping-proof {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    border: 1px solid #21262d;
    border-radius: 8px;
    color: #8b949e;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.2s;
    margin-bottom: 12px;
}
.btn-shipping-proof:hover { border-color: #30363d; color: #e6edf3; }

.btn-confirm-delivery {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #3fb950, #2ea043);
    color: #fff;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-confirm-delivery:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(63,185,80,0.3); }

@media (max-width: 900px) {
    .inv-detail-grid { grid-template-columns: 1fr; }
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
        } else {
            previewImg.src = '<?= base_url("assets/images/default-item.jpg") ?>';
        }
    }
}

function removeFile() {
    var fileInput = document.getElementById('paymentFile');
    var placeholder = document.getElementById('uploadPlaceholder');
    var preview = document.getElementById('uploadPreview');
    var submitBtn = document.getElementById('submitPayment');

    fileInput.value = '';
    placeholder.style.display = '';
    preview.style.display = 'none';
    submitBtn.disabled = true;
}
</script>
