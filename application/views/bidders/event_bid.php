<div class="bid-page">
    <div class="auction-header">
        <div class="auction-header-content">
            <a href="<?= site_url('bidders/events') ?>" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Lelang</a>
            <h1><?= htmlspecialchars($event['name']) ?></h1>
            <?php if (!empty($event['description'])): ?>
                <p class="auction-desc"><?= htmlspecialchars($event['description']) ?></p>
            <?php endif; ?>
        </div>
        <div class="auction-timer-box" id="auctionTimerBox" data-end="<?= $event['auction_end'] ?>">
            <div class="timer-label">Sisa Waktu</div>
            <div class="timer-display">
                <div class="timer-block"><span id="timerDays">00</span><small>Hari</small></div>
                <div class="timer-sep">:</div>
                <div class="timer-block"><span id="timerHours">00</span><small>Jam</small></div>
                <div class="timer-sep">:</div>
                <div class="timer-block"><span id="timerMins">00</span><small>Menit</small></div>
                <div class="timer-sep">:</div>
                <div class="timer-block"><span id="timerSecs">00</span><small>Detik</small></div>
            </div>
            <div class="timer-status <?= $event['status'] === 'active' ? 'timer-active' : 'timer-ended' ?>" id="timerStatus">
                <?php if ($event['status'] === 'active'): ?>
                    <span class="pulse-dot"></span> Lelang Berlangsung
                <?php else: ?>
                    Lelang Selesai
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($event['auction_end'])): ?>
    <div class="auction-progress" id="auctionProgress" data-start="<?= $event['auction_start'] ?>" data-end="<?= $event['auction_end'] ?>">
        <div class="progress-bar-track">
            <div class="progress-bar-fill" id="progressFill"></div>
        </div>
    </div>
    <?php endif; ?>

    <div class="items-grid" id="itemsGrid">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <?php
                    $highest = null;
                    $bid_count = 0;
                    if (!empty($item['bids'])) {
                        $highest = $item['bids'][0];
                        $bid_count = count($item['bids']);
                    }
                    $current_price = $highest ? $highest['amount'] : $item['starting_price'];
                    $increment = (float) ($item['min_increment'] ?? 0);
                    $start_price = (float) $item['starting_price'];
                    if ($increment > 0) {
                        $base = $highest ? (float) $highest['amount'] : $start_price;
                        $k = (int) floor(($base - $start_price) / $increment) + 1;
                        $min_bid = $start_price + ($k * $increment);
                    } else {
                        $min_bid = $highest ? (float) $highest['amount'] + 1 : $start_price;
                    }
                    $is_my_bid = $highest && $highest['bidder_id'] == $this->session->userdata('user_id');
                    $item_image = !empty($item['image']) ? base_url('uploads/items/' . $item['image']) : base_url('assets/images/placeholder-item.php');
                    $is_over = ($event['status'] !== 'active');
                ?>
                <div class="item-card <?= $is_over ? 'item-ended' : '' ?>" id="item-<?= $item['id'] ?>">
                    <div class="item-image-wrap">
                        <?php $gallery = $item['images'] ?? array(); ?>
                        <div class="gallery-slide" id="gallery-slide-<?= $item['id'] ?>">
                            <?php if (!empty($gallery)): ?>
                                <?php $i = 0; foreach ($gallery as $gimg): ?>
                                    <img src="<?= base_url('uploads/items/' . $gimg['image']) ?>" data-gallery-index="<?= $i ?>" class="item-image <?= $i === 0 ? 'active' : '' ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.parentNode.removeChild(this)">
                                <?php $i++; endforeach; ?>
                            <?php else: ?>
                                <img src="<?= $item_image ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="item-image active" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
                            <?php endif; ?>
                        </div>
                        <?php if (count($gallery) > 1): ?>
                            <div class="gallery-nav">
                                <button class="gallery-arrow gallery-prev" onclick="galleryNav(<?= $item['id'] ?>, -1)"><i class="fas fa-chevron-left"></i></button>
                                <div class="gallery-dots" id="gallery-dots-<?= $item['id'] ?>">
                                    <?php foreach ($gallery as $gi => $gimg): ?>
                                        <span class="gallery-dot <?= $gi === 0 ? 'active' : '' ?>" data-dot-index="<?= $gi ?>" onclick="galleryGo(<?= $item['id'] ?>, <?= $gi ?>)"></span>
                                    <?php endforeach; ?>
                                </div>
                                <button class="gallery-arrow gallery-next" onclick="galleryNav(<?= $item['id'] ?>, 1)"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($is_my_bid && !$is_over): ?>
                            <span class="my-bid-badge"><i class="fas fa-crown"></i> Bid Anda Paling Tinggi</span>
                        <?php endif; ?>
                        <?php if ($is_over): ?>
                            <div class="item-ended-overlay">
                                <i class="fas fa-gavel"></i>
                                <span>Lelang Selesai</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="item-body">
                        <h3 class="item-name"><?= htmlspecialchars($item['name']) ?></h3>
                        <?php if (!empty($item['description'])): ?>
                            <p class="item-desc"><?= htmlspecialchars(mb_strimwidth($item['description'], 0, 120, '...')) ?></p>
                        <?php endif; ?>

                        <div class="item-price-section">
                            <div class="price-row">
                                <span class="price-label">Harga Mulai</span>
                                <span class="price-starting">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></span>
                            </div>
                            <div class="price-row price-current-row">
                                <span class="price-label">Harga Saat Ini</span>
                                <span class="price-current" id="price-<?= $item['id'] ?>">
                                    <?php if ($highest): ?>
                                        Rp <?= number_format($current_price, 0, ',', '.') ?>
                                    <?php else: ?>
                                        <em style="color:#8b949e;">Belum ada bid</em>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Jumlah Bid</span>
                                <span class="bid-count" id="bidcount-<?= $item['id'] ?>">
                                    <i class="fas fa-gavel"></i> <?= $bid_count ?> bid
                                </span>
                            </div>
                        </div>

                        <?php if (!$is_over): ?>
                            <div class="bid-form-section" id="bidform-<?= $item['id'] ?>">
                                <div class="bid-input-group">
                                    <span class="bid-currency">Rp</span>
                                    <input type="text" class="bid-input" id="bid-input-<?= $item['id'] ?>"
                                           placeholder="Masukkan harga bid..."
                                           data-item="<?= $item['id'] ?>"
                                           data-min="<?= $min_bid ?>"
                                           data-increment="<?= $increment ?>"
                                           data-start="<?= $start_price ?>"
                                           oninput="formatBidInput(this)"
                                           onkeydown="if(event.key==='Enter'){placeBid(<?= $item['id'] ?>, <?= $event['id'] ?>)}">
                                </div>
                                <div class="bid-min-hint" id="bidmin-<?= $item['id'] ?>">Min: Rp <?= number_format($min_bid, 0, ',', '.') ?><?= $increment > 0 ? ' (kelipatan Rp ' . number_format($increment, 0, ',', '.') . ')' : '' ?></div>
                                <button class="bid-btn" id="bidbtn-<?= $item['id'] ?>" onclick="placeBid(<?= $item['id'] ?>, <?= $event['id'] ?>)">
                                    <span class="bid-btn-text"><i class="fas fa-gavel"></i> Bid!</span>
                                    <span class="bid-btn-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Memproses...</span>
                                </button>
                                <div class="bid-result" id="bidresult-<?= $item['id'] ?>"></div>
                            </div>
                        <?php else: ?>
                            <div class="auction-ended-info">
                                <?php if ($highest): ?>
                                    <div class="winner-info">
                                        <i class="fas fa-trophy"></i>
                                        <span>Pemenang: <strong><?= $highest['bidder_id'] == $this->session->userdata('user_id') ? 'Anda' : 'Bidder ' . str_pad($highest['bidder_id'], 3, '0', STR_PAD_LEFT) ?></strong></span>
                                    </div>
                                    <div class="winner-price">Rp <?= number_format($highest['amount'], 0, ',', '.') ?></div>
                                <?php else: ?>
                                    <div class="no-bids-info"><i class="fas fa-info-circle"></i> Tidak ada bid untuk item ini.</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Item</h3>
                <p>Belum ada item yang tersedia untuk lelang ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="bid-modal" id="bidModal" style="display:none;">
    <div class="bid-modal-content">
        <div class="bid-modal-icon" id="bidModalIcon"><i class="fas fa-check-circle"></i></div>
        <h3 id="bidModalTitle">Berhasil!</h3>
        <p id="bidModalMsg"></p>
        <button class="bid-modal-btn" onclick="closeBidModal()">OK</button>
    </div>
</div>

<style>
.bid-page { max-width: 1200px; }

.auction-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 32px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.auction-header-content { flex: 1; min-width: 300px; }

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    color: #8b949e;
    text-decoration: none;
    margin-bottom: 12px;
    transition: color 0.2s;
}
.back-link:hover { color: #00d4ff; }

.auction-header-content h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #e6edf3;
    margin-bottom: 6px;
}

.auction-desc { font-size: 0.9rem; color: #8b949e; line-height: 1.5; }

.auction-timer-box {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 16px;
    padding: 24px 32px;
    text-align: center;
    min-width: 320px;
    position: relative;
    overflow: hidden;
}

.auction-timer-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #00d4ff, #ffd700, #00d4ff);
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
}

@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.timer-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #8b949e;
    margin-bottom: 12px;
}

.timer-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.timer-block {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.timer-block span {
    font-family: 'Orbitron', sans-serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: #e6edf3;
    min-width: 60px;
    text-align: center;
    background: #0d1117;
    padding: 8px 12px;
    border-radius: 10px;
    border: 1px solid #21262d;
}

.timer-block small {
    font-size: 0.65rem;
    color: #8b949e;
    margin-top: 6px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.timer-sep {
    font-family: 'Orbitron', sans-serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: #8b949e;
    margin: 0 2px;
    padding-bottom: 20px;
}

.timer-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.timer-active { color: #3fb950; }
.timer-ended { color: #f85149; }

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #3fb950;
    border-radius: 50%;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.8); }
}

.auction-progress { margin-bottom: 32px; }

.progress-bar-track {
    height: 4px;
    background: #21262d;
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #00d4ff, #3fb950);
    border-radius: 2px;
    transition: width 1s linear;
    width: 0%;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.item-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
    perspective: 1000px;
}

.item-card:hover {
    transform: translateY(-6px) rotateX(2deg);
    border-color: #00d4ff;
    box-shadow: 0 12px 40px rgba(0,212,255,0.15), 0 0 0 1px rgba(0,212,255,0.1);
}

.item-ended {
    opacity: 0.7;
}

.item-ended:hover {
    transform: none;
    border-color: #21262d;
    box-shadow: none;
}

.item-image-wrap {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: #0d1117;
}

.item-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}

.item-card:hover .item-image { transform: scale(1.08); }

.gallery-slide { position: relative; width: 100%; height: 100%; overflow: hidden; }
.gallery-slide img.item-image { display: none; }
.gallery-slide img.item-image.active { display: block; }
.gallery-nav { position: absolute; top: 0; left: 0; right: 0; height: 220px; display: none; justify-content: space-between; align-items: center; padding: 0 8px; pointer-events: none; z-index: 5; }
.item-image-wrap:hover .gallery-nav { display: flex; }
.gallery-arrow { pointer-events: auto; background: rgba(0,0,0,.45); color: #fff; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.gallery-dots { position: absolute; bottom: 8px; left: 0; right: 0; display: flex; justify-content: center; gap: 6px; }
.gallery-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.6); cursor: pointer; display: inline-block; }
.gallery-dot.active { background: #fff; }

.my-bid-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, rgba(255,215,0,0.95), rgba(255,180,0,0.95));
    color: #1a1a00;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
    z-index: 2;
    box-shadow: 0 2px 10px rgba(255,215,0,0.3);
}

.item-ended-overlay {
    position: absolute;
    inset: 0;
    background: rgba(13,17,23,0.8);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #8b949e;
    gap: 8px;
    z-index: 2;
}
.item-ended-overlay i { font-size: 2rem; opacity: 0.5; }
.item-ended-overlay span { font-size: 0.85rem; font-weight: 600; }

.item-body { padding: 20px; }

.item-name {
    font-size: 1.05rem;
    font-weight: 600;
    color: #e6edf3;
    margin-bottom: 6px;
}

.item-desc {
    font-size: 0.82rem;
    color: #8b949e;
    line-height: 1.5;
    margin-bottom: 16px;
}

.item-price-section {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 16px;
    padding: 14px;
    background: #0d1117;
    border-radius: 10px;
    border: 1px solid #21262d;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-label { font-size: 0.78rem; color: #8b949e; }

.price-starting { font-size: 0.82rem; color: #8b949e; font-weight: 500; }

.price-current {
    font-family: 'Orbitron', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: #ffd700;
}

.price-current-row {
    padding: 8px 0;
    border-top: 1px solid #21262d;
    border-bottom: 1px solid #21262d;
}

.bid-count {
    font-size: 0.82rem;
    color: #8b949e;
    font-weight: 500;
}
.bid-count i { color: #00d4ff; }

.bid-form-section {
    padding-top: 4px;
}

.bid-input-group {
    display: flex;
    align-items: center;
    background: #0d1117;
    border: 2px solid #21262d;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s;
    margin-bottom: 6px;
}

.bid-input-group:focus-within {
    border-color: #00d4ff;
    box-shadow: 0 0 0 3px rgba(0,212,255,0.1);
}

.bid-currency {
    padding: 0 14px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #8b949e;
    background: rgba(33,38,45,0.5);
    height: 46px;
    display: flex;
    align-items: center;
}

.bid-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 12px 14px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #e6edf3;
    font-family: 'Inter', sans-serif;
}

.bid-input::placeholder { color: #484f58; font-weight: 400; }

.bid-min-hint {
    font-size: 0.72rem;
    color: #8b949e;
    margin-bottom: 10px;
    padding-left: 2px;
}

.bid-btn {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #ffd700, #f0b400);
    color: #1a1a00;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.bid-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.bid-btn:hover::before { left: 100%; }

.bid-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255,215,0,0.4);
}

.bid-btn:active { transform: translateY(0); }

.bid-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

.bid-result {
    margin-top: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    min-height: 20px;
    text-align: center;
}

.bid-result.success { color: #3fb950; }
.bid-result.error { color: #f85149; }

.auction-ended-info {
    padding: 16px;
    background: #0d1117;
    border-radius: 10px;
    border: 1px solid #21262d;
    text-align: center;
}

.winner-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #8b949e;
}
.winner-info i { color: #ffd700; }
.winner-price {
    font-family: 'Orbitron', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffd700;
    margin-top: 8px;
}

.no-bids-info {
    color: #8b949e;
    font-size: 0.85rem;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #8b949e;
}
.empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.3; display: block; }
.empty-state h3 { font-size: 1.2rem; color: #e6edf3; margin-bottom: 8px; }

/* Modal */
.bid-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(4px);
    animation: fadeIn 0.2s;
}

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.bid-modal-content {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    max-width: 380px;
    width: 90%;
    animation: modalPop 0.3s;
}

@keyframes modalPop {
    from { transform: scale(0.85); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.bid-modal-icon { font-size: 3rem; margin-bottom: 16px; }
.bid-modal-icon.success { color: #3fb950; }
.bid-modal-icon.error { color: #f85149; }
.bid-modal-content h3 { font-size: 1.2rem; color: #e6edf3; margin-bottom: 8px; }
.bid-modal-content p { font-size: 0.9rem; color: #8b949e; margin-bottom: 24px; line-height: 1.5; }

.bid-modal-btn {
    padding: 10px 32px;
    border: none;
    border-radius: 8px;
    background: #21262d;
    color: #e6edf3;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.bid-modal-btn:hover { background: #30363d; }

@media (max-width: 1024px) { .items-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .items-grid { grid-template-columns: 1fr; }
    .auction-header { flex-direction: column; }
    .auction-timer-box { min-width: auto; width: 100%; }
    .timer-block span { font-size: 1.6rem; min-width: 44px; padding: 6px 8px; }
}
</style>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_COOKIE = '<?= config_item('csrf_cookie_name') ?>';
var CURRENT_USER_ID = <?= $this->session->userdata('user_id') ?>;

function getCsrfHash() {
    var raw = document.cookie.match(new RegExp('(^|; )' + CSRF_COOKIE + '=([^;]*)'));
    if (raw) {
        return decodeURIComponent(raw[2]);
    }
    return '<?= $this->security->get_csrf_hash() ?>';
}

function formatBidInput(input) {
    var val = input.value.replace(/[^0-9]/g, '');
    if (val) {
        input.value = parseInt(val).toLocaleString('id-ID');
    }
}

function parseBidValue(str) {
    return parseInt(str.replace(/[^0-9]/g, '')) || 0;
}

function gallerySlideEls(itemId) {
    var slide = document.getElementById('gallery-slide-' + itemId);
    return slide ? slide.querySelectorAll('img[data-gallery-index]') : [];
}

function galleryShow(itemId, idx) {
    var imgs = gallerySlideEls(itemId);
    var total = imgs.length;
    if (total === 0) return;
    var n = ((idx % total) + total) % total;
    imgs.forEach(function (img) {
        img.classList.toggle('active', parseInt(img.getAttribute('data-gallery-index')) === n);
    });
    var dots = document.getElementById('gallery-dots-' + itemId);
    if (dots) {
        dots.querySelectorAll('.gallery-dot').forEach(function (d) {
            d.classList.toggle('active', parseInt(d.getAttribute('data-dot-index')) === n);
        });
    }
}

function galleryNav(itemId, dir) {
    var slide = document.getElementById('gallery-slide-' + itemId);
    var active = slide.querySelector('img.active');
    var idx = active ? (parseInt(active.getAttribute('data-gallery-index')) || 0) : 0;
    galleryShow(itemId, idx + dir);
}

function galleryGo(itemId, idx) {
    galleryShow(itemId, idx);
}

function placeBid(itemId, eventId) {
    var input = document.getElementById('bid-input-' + itemId);
    var btn = document.getElementById('bidbtn-' + itemId);
    var result = document.getElementById('bidresult-' + itemId);
    var amount = parseBidValue(input.value);
    var min = parseInt(input.getAttribute('data-min')) || 0;
    var inc = parseFloat(input.getAttribute('data-increment')) || 0;
    var start = parseFloat(input.getAttribute('data-start')) || 0;

    if (!amount || amount < min) {
        result.className = 'bid-result error';
        result.textContent = 'Minimal bid: Rp ' + min.toLocaleString('id-ID');
        return;
    }

    if (inc > 0) {
        var diff = amount - start;
        if (diff % inc !== 0) {
            result.className = 'bid-result error';
            result.textContent = 'Bid harus kelipatan Rp ' + inc.toLocaleString('id-ID') + ' dari harga awal (contoh: ' + (start + inc).toLocaleString('id-ID') + ', dst.)';
            return;
        }
    }

    btn.disabled = true;
    btn.querySelector('.bid-btn-text').style.display = 'none';
    btn.querySelector('.bid-btn-loading').style.display = 'inline-flex';
    result.className = 'bid-result';
    result.textContent = '';

    var formData = new FormData();
    formData.append('item_id', itemId);
    formData.append('amount', amount);
    formData.append(CSRF_NAME, getCsrfHash());

    fetch('<?= site_url("api/bid") ?>', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.status === 'success') {
            result.className = 'bid-result success';
            result.textContent = 'Bid berhasil! Rp ' + amount.toLocaleString('id-ID');

            var priceEl = document.getElementById('price-' + itemId);
            if (priceEl) {
                priceEl.innerHTML = 'Rp ' + data.data.highest_bid.toLocaleString('id-ID');
                priceEl.style.animation = 'none';
                priceEl.offsetHeight;
                priceEl.style.animation = 'flashGold 0.6s';
            }

            var countEl = document.getElementById('bidcount-' + itemId);
            if (countEl) {
                countEl.innerHTML = '<i class="fas fa-gavel"></i> ' + data.data.bid_count + ' bid';
            }

            var newMin;
            if (inc > 0) {
                var k = Math.floor((data.data.highest_bid - start) / inc) + 1;
                newMin = start + k * inc;
            } else {
                newMin = data.data.highest_bid + 1;
            }
            input.setAttribute('data-min', newMin);
            input.value = '';
            var minHint = document.getElementById('bidmin-' + itemId);
            if (minHint) minHint.textContent = 'Min: Rp ' + newMin.toLocaleString('id-ID') + (inc > 0 ? ' (kelipatan Rp ' + inc.toLocaleString('id-ID') + ')' : '');

            if (data.data.highest_bidder == CURRENT_USER_ID) {
                var card = document.getElementById('item-' + itemId);
                var existing = card.querySelector('.my-bid-badge');
                if (!existing) {
                    var badge = document.createElement('span');
                    badge.className = 'my-bid-badge';
                    badge.innerHTML = '<i class="fas fa-crown"></i> Bid Anda Paling Tinggi';
                    card.querySelector('.item-image-wrap').appendChild(badge);
                }
            }

            showBidModal('success', 'Bid Berhasil!', 'Bid Anda sebesar Rp ' + amount.toLocaleString('id-ID') + ' telah diterima.');
        } else {
            result.className = 'bid-result error';
            result.textContent = data.message || 'Gagal melakukan bid.';
            showBidModal('error', 'Bid Gagal', data.message || 'Terjadi kesalahan.');
        }
    })
    .catch(function() {
        result.className = 'bid-result error';
        result.textContent = 'Kesalahan jaringan. Coba lagi.';
        showBidModal('error', 'Kesalahan', 'Gagal terhubung ke server.');
    })
    .then(function() {
        btn.disabled = false;
        btn.querySelector('.bid-btn-text').style.display = 'inline-flex';
        btn.querySelector('.bid-btn-loading').style.display = 'none';
    });
}

function showBidModal(type, title, msg) {
    var modal = document.getElementById('bidModal');
    var icon = document.getElementById('bidModalIcon');
    var titleEl = document.getElementById('bidModalTitle');
    var msgEl = document.getElementById('bidModalMsg');

    icon.className = 'bid-modal-icon ' + type;
    icon.innerHTML = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
    titleEl.textContent = title;
    msgEl.textContent = msg;
    modal.style.display = 'flex';
}

function closeBidModal() {
    document.getElementById('bidModal').style.display = 'none';
}

document.getElementById('bidModal').addEventListener('click', function(e) {
    if (e.target === this) closeBidModal();
});

(function() {
    var timerBox = document.getElementById('auctionTimerBox');
    if (!timerBox) return;

    var endStr = timerBox.getAttribute('data-end');
    if (!endStr) return;
    var endTime = new Date(endStr).getTime();

    function updateTimer() {
        var diff = endTime - Date.now();
        if (diff <= 0) {
            document.getElementById('timerDays').textContent = '00';
            document.getElementById('timerHours').textContent = '00';
            document.getElementById('timerMins').textContent = '00';
            document.getElementById('timerSecs').textContent = '00';
            var status = document.getElementById('timerStatus');
            status.className = 'timer-ended';
            status.innerHTML = 'Lelang Selesai';
            return;
        }
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        document.getElementById('timerDays').textContent = String(d).padStart(2, '0');
        document.getElementById('timerHours').textContent = String(h).padStart(2, '0');
        document.getElementById('timerMins').textContent = String(m).padStart(2, '0');
        document.getElementById('timerSecs').textContent = String(s).padStart(2, '0');
    }
    updateTimer();
    setInterval(updateTimer, 1000);

    var progress = document.getElementById('auctionProgress');
    if (progress) {
        var startStr = progress.getAttribute('data-start');
        var pEndStr = progress.getAttribute('data-end');
        if (startStr && pEndStr) {
            var pStart = new Date(startStr).getTime();
            var pEnd = new Date(pEndStr).getTime();
            function updateProgress() {
                var now = Date.now();
                var total = pEnd - pStart;
                var elapsed = now - pStart;
                var pct = Math.min(100, Math.max(0, (elapsed / total) * 100));
                document.getElementById('progressFill').style.width = pct + '%';
            }
            updateProgress();
            setInterval(updateProgress, 5000);
        }
    }
})();
</script>

<style>
@keyframes flashGold {
    0% { text-shadow: 0 0 20px rgba(255,215,0,0.8); transform: scale(1.1); }
    100% { text-shadow: none; transform: scale(1); }
}
</style>
