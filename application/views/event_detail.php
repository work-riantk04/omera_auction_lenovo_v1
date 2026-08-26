<?php $this->load->view('welcome_header', ['title' => $event['name'], 'csrf_token_name' => $csrf_token_name, 'csrf_hash' => $csrf_hash]); ?>

<section class="event-detail-hero">
    <div class="container">
        <div class="event-detail-banner card-3d">
            <?php if ($event['banner_image']): ?>
                <img src="<?= base_url('uploads/events/' . $event['banner_image']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" class="event-banner-img">
            <?php else: ?>
                <div class="event-banner-placeholder">
                    <i class="fas fa-gavel"></i>
                </div>
            <?php endif; ?>
            <div class="event-banner-overlay">
                <div class="event-detail-info">
                    <span class="badge badge-lg badge-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                    <h1><?= htmlspecialchars($event['name']) ?></h1>
                    <p class="event-detail-dates">
                        <i class="fas fa-calendar"></i>
                        <?= date('d M Y H:i', strtotime($event['auction_start'])) ?> - <?= date('d M Y H:i', strtotime($event['auction_end'])) ?>
                    </p>
                    <?php if ($event['description']): ?>
                        <p class="event-detail-desc"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($event['status'] === 'active' && strtotime($event['auction_end']) > time()): ?>
<section class="event-countdown-section">
    <div class="container">
        <div class="event-countdown-bar card-3d">
            <div class="countdown-label">
                <i class="fas fa-hourglass-half"></i> Sisa Waktu Lelang:
            </div>
            <div class="countdown-large" data-end="<?= $event['auction_end'] ?>" id="eventCountdown">
                Memuat...
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="event-items-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-box-open"></i> Barang Lelang</h2>
            <p class="section-subtitle"><?= count($items) ?> barang tersedia dalam event ini</p>
        </div>

        <?php if ($event['status'] === 'active' || $event['status'] === 'completed'): ?>
            <?php if (!empty($items)): ?>
            <div class="items-grid">
                <?php foreach ($items as $item): ?>
                <div class="item-card card-3d">
                    <div class="item-image">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <?php else: ?>
                            <div class="item-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        <?php endif; ?>
                        <?php if ($item['status'] === 'sold'): ?>
                            <span class="item-badge sold"><i class="fas fa-check"></i> Terjual</span>
                        <?php elseif (!empty($item['highest_bid']) && $item['highest_bid'] > $item['starting_price']): ?>
                            <span class="item-badge hot"><i class="fas fa-fire"></i> Hot</span>
                        <?php endif; ?>
                    </div>
                    <div class="item-body">
                        <h4 class="item-name"><?= htmlspecialchars($item['name']) ?></h4>
                        <p class="item-titipers"><i class="fas fa-store"></i> <?= htmlspecialchars($item['titipers_name'] ?? '') ?></p>
                        <div class="item-prices">
                            <div class="price-row">
                                <span class="price-label">Harga Awal</span>
                                <span class="price-value starting">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Tertinggi Saat Ini</span>
                                <span class="price-value current" id="highest-<?= $item['id'] ?>">Rp <?= number_format($item['highest_bid'], 0, ',', '.') ?></span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Jumlah Bid</span>
                                <span class="price-value bid-count" id="bidcount-<?= $item['id'] ?>"><?= count($item['bids'] ?? []) ?></span>
                            </div>
                        </div>
                        <?php if ($event['status'] === 'active' && strtotime($event['auction_end']) > time()): ?>
                        <div class="item-timer">
                            <i class="fas fa-hourglass-half"></i>
                            <span class="countdown" data-end="<?= $event['auction_end'] ?>">Memuat...</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="item-footer">
                        <?php if ($event['status'] === 'active' && $this->session->userdata('logged_in') && $this->session->userdata('role') === 'bidders' && strtotime($event['auction_end']) > time()): ?>
                            <button class="btn btn-primary btn-block bid-btn" onclick="openBidModal(<?= $item['id'] ?>, <?= $item['highest_bid'] ?>, '<?= htmlspecialchars(addslashes($item['name'])) ?>')">
                                <i class="fas fa-gavel"></i> Bid Sekarang
                            </button>
                        <?php elseif ($event['status'] === 'active' && strtotime($event['auction_end']) > time()): ?>
                            <div class="item-login-prompt">
                                <a href="javascript:void(0)" onclick="openModal('loginModal')" class="btn btn-outline btn-block btn-sm">
                                    <i class="fas fa-sign-in-alt"></i> Masuk untuk Bid
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($event['status'] === 'completed' && !empty($item['bids'])): ?>
                        <div class="winner-highlight">
                            <i class="fas fa-trophy"></i>
                            <span>Pemenang: <?= htmlspecialchars($item['bids'][0]['bidder_name'] ?? '') ?> - Rp <?= number_format($item['bids'][0]['amount'], 0, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state card-3d">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Belum Ada Barang</h3>
                <p>Belum ada barang yang tersedia dalam event ini.</p>
            </div>
            <?php endif; ?>

        <?php elseif ($event['status'] === 'upcoming' || $event['status'] === 'collecting'): ?>
        <div class="empty-state card-3d">
            <div class="empty-icon">
                <i class="fas fa-hourglass-start"></i>
            </div>
            <h3>Lelang Belum Dimulai</h3>
            <p>Event lelang ini belum dimulai. Silakan tunggu hingga jadwal lelang tiba.</p>
            <div class="upcoming-info">
                <p><i class="fas fa-calendar-check"></i> Jadwal Mulai: <strong><?= date('d M Y H:i', strtotime($event['auction_start'])) ?></strong></p>
            </div>
        </div>
        <?php elseif ($event['status'] === 'completed'): ?>
        <div class="event-completed-notice card-3d">
            <i class="fas fa-flag-checkered"></i>
            <h3>Lelang Telah Selesai</h3>
            <p>Event lelang ini telah berakhir. Berikut adalah hasil akhir dari lelang ini.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($event['status'] === 'active' && $this->session->userdata('logged_in') && $this->session->userdata('role') === 'bidders' && strtotime($event['auction_end']) > time()): ?>
<div class="modal-overlay" id="bidModal">
    <div class="modal-box modal-bid">
        <div class="modal-header">
            <h3><i class="fas fa-gavel"></i> Pasang Bid</h3>
            <button class="modal-close" onclick="closeModal('bidModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="bid-item-name" id="bidItemName"></div>
            <div class="bid-current">
                <span class="bid-current-label">Harga Tertinggi Saat Ini</span>
                <span class="bid-current-value" id="bidCurrentPrice"></span>
            </div>
            <form id="bidForm" onsubmit="return submitBid(event)">
                <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                <input type="hidden" name="item_id" id="bidItemId">
                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                <div class="form-group">
                    <label for="bidAmount"><i class="fas fa-money-bill-wave"></i> Jumlah Bid</label>
                    <div class="bid-input-wrapper">
                        <span class="bid-currency">Rp</span>
                        <input type="number" id="bidAmount" name="amount" class="form-control bid-input" min="0" step="1000" required>
                    </div>
                    <small class="bid-hint">Minimal: <span id="bidMinHint">Rp 0</span></small>
                </div>
                <div class="bid-result" id="bidResult" style="display:none;"></div>
                <button type="submit" class="btn btn-primary btn-block btn-lg" id="bidSubmitBtn">
                    <i class="fas fa-gavel"></i> Kirim Bid
                </button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function openBidModal(itemId, currentHighest, itemName) {
    document.getElementById('bidItemId').value = itemId;
    document.getElementById('bidItemName').textContent = itemName;
    document.getElementById('bidCurrentPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentHighest);
    const minBid = parseInt(currentHighest) + 1;
    document.getElementById('bidMinHint').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(minBid);
    document.getElementById('bidAmount').min = minBid;
    document.getElementById('bidAmount').value = minBid;
    document.getElementById('bidResult').style.display = 'none';
    openModal('bidModal');
}

function submitBid(e) {
    e.preventDefault();
    const form = document.getElementById('bidForm');
    const btn = document.getElementById('bidSubmitBtn');
    const result = document.getElementById('bidResult');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

    const formData = new FormData(form);

    fetch('<?= base_url('api/bid') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        result.style.display = 'block';
        if (data.status === 'success') {
            result.className = 'bid-result bid-success';
            result.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
            const itemId = document.getElementById('bidItemId').value;
            const highestEl = document.getElementById('highest-' + itemId);
            const countEl = document.getElementById('bidcount-' + itemId);
            if (highestEl) highestEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.data.highest_bid);
            if (countEl) countEl.textContent = data.data.bid_count;
            document.getElementById('bidCurrentPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.data.highest_bid);
            const newMin = parseInt(data.data.highest_bid) + 1;
            document.getElementById('bidMinHint').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newMin);
            document.getElementById('bidAmount').min = newMin;
            document.getElementById('bidAmount').value = newMin;
        } else {
            result.className = 'bid-result bid-error';
            result.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-gavel"></i> Kirim Bid';
    })
    .catch(err => {
        result.style.display = 'block';
        result.className = 'bid-result bid-error';
        result.innerHTML = '<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan. Silakan coba lagi.';
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-gavel"></i> Kirim Bid';
    });

    return false;
}
</script>

<?php $this->load->view('welcome_footer'); ?>
