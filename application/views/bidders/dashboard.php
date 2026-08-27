<div class="dashboard-page">
    <div class="page-header">
        <h1>Selamat Datang, <?= htmlspecialchars($this->session->userdata('name')) ?>!</h1>
        <p style="color:#8b949e; margin-top:4px;">Berikut ringkasan aktivitas lelang Anda.</p>
    </div>

    <div class="stat-cards">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-gavel"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= number_format($total_bids) ?></span>
                <span class="stat-label">Total Bid</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-trophy"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= number_format($won_auctions) ?></span>
                <span class="stat-label">Menang Lelang</span>
            </div>
        </div>
        <div class="stat-card stat-yellow">
            <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= number_format($pending_payments) ?></span>
                <span class="stat-label">Invoice Pending</span>
            </div>
        </div>
        <div class="stat-card stat-purple">
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            <div class="stat-info">
                <span class="stat-value">Rp <?= number_format($total_spent, 0, ',', '.') ?></span>
                <span class="stat-label">Total Belanja</span>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Lelang Aktif</h3>
                <a href="<?= site_url('bidders/events') ?>" class="card-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <?php if (!empty($active_events)): ?>
                    <?php foreach ($active_events as $event): ?>
                        <a href="<?= site_url('bidders/event_bid/' . $event['id']) ?>" class="event-quick-item">
                            <div class="event-quick-info">
                                <span class="event-quick-name"><?= htmlspecialchars($event['name']) ?></span>
                                <span class="event-quick-meta"><?= $event['item_count'] ?? 0 ?> item &middot; <?= $event['bid_count'] ?? 0 ?> bid</span>
                            </div>
                            <div class="event-quick-countdown" data-end="<?= $event['auction_end'] ?>">
                                <i class="fas fa-hourglass-half"></i>
                                <span class="countdown-text">Memuat...</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state-small">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada lelang aktif.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Riwayat Bid Terakhir</h3>
            </div>
            <div class="card-body">
                <?php
                $recent_bids = $recent_bids ?? [];
                if (!empty($recent_bids)):
                    $shown = 0;
                    foreach ($recent_bids as $bid):
                        if ($shown >= 5) break;
                        $shown++;
                        $is_highest = ($bid['amount'] >= ($bid['highest_amount'] ?? $bid['amount']));
                ?>
                    <div class="bid-history-item <?= $is_highest ? 'bid-leading' : 'bid-outbid' ?>">
                        <div class="bid-history-left">
                            <span class="bid-history-item-name"><?= htmlspecialchars($bid['item_name']) ?></span>
                            <span class="bid-history-event"><?= htmlspecialchars($bid['event_name']) ?></span>
                        </div>
                        <div class="bid-history-right">
                            <span class="bid-history-amount">Rp <?= number_format($bid['amount'], 0, ',', '.') ?></span>
                            <span class="bid-history-status <?= $is_highest ? 'status-winning' : 'status-outbid' ?>">
                                <?= $is_highest ? 'Memimpin' : 'Tertinggi' ?>
                            </span>
                        </div>
                    </div>
                <?php
                    endforeach;
                else:
                ?>
                    <div class="empty-state-small">
                        <i class="fas fa-hand-pointer"></i>
                        <p>Belum ada riwayat bid.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-page { max-width: 1200px; }
.page-header h1 { font-size: 1.6rem; font-weight: 700; color: #e6edf3; }

.stat-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin: 28px 0;
}

.stat-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, border-color 0.2s;
}

.stat-card:hover { transform: translateY(-2px); }

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.stat-blue .stat-icon { background: rgba(0,212,255,0.12); color: #00d4ff; border: 1px solid rgba(0,212,255,0.25); }
.stat-green .stat-icon { background: rgba(63,185,80,0.12); color: #3fb950; border: 1px solid rgba(63,185,80,0.25); }
.stat-yellow .stat-icon { background: rgba(210,153,34,0.12); color: #d29922; border: 1px solid rgba(210,153,34,0.25); }
.stat-purple .stat-icon { background: rgba(188,140,255,0.12); color: #bc8cff; border: 1px solid rgba(188,140,255,0.25); }

.stat-info { display: flex; flex-direction: column; }
.stat-value { font-size: 1.35rem; font-weight: 700; color: #e6edf3; }
.stat-label { font-size: 0.8rem; color: #8b949e; margin-top: 2px; }

.stat-blue { border-left: 3px solid #00d4ff; }
.stat-green { border-left: 3px solid #3fb950; }
.stat-yellow { border-left: 3px solid #d29922; }
.stat-purple { border-left: 3px solid #bc8cff; }

.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-top: 8px;
}

.dashboard-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    overflow: hidden;
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    border-bottom: 1px solid #21262d;
}

.card-header h3 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #e6edf3;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-header h3 i { color: #8b949e; font-size: 0.85rem; }

.card-link {
    font-size: 0.8rem;
    color: #00d4ff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: opacity 0.2s;
}
.card-link:hover { opacity: 0.8; }

.card-body { padding: 16px 24px; }

.event-quick-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #21262d;
    text-decoration: none;
    transition: background 0.15s;
}
.event-quick-item:last-child { border-bottom: none; }
.event-quick-item:hover { background: rgba(0,212,255,0.04); margin: 0 -24px; padding: 14px 24px; border-radius: 8px; }

.event-quick-name { font-size: 0.9rem; font-weight: 600; color: #e6edf3; }
.event-quick-meta { font-size: 0.78rem; color: #8b949e; margin-top: 2px; display: block; }
.event-quick-info { display: flex; flex-direction: column; }

.event-quick-countdown {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    color: #d29922;
    white-space: nowrap;
}

.bid-history-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #21262d;
}
.bid-history-item:last-child { border-bottom: none; }

.bid-history-item-name { font-size: 0.9rem; font-weight: 600; color: #e6edf3; }
.bid-history-event { font-size: 0.78rem; color: #8b949e; margin-top: 2px; display: block; }
.bid-history-left { display: flex; flex-direction: column; }
.bid-history-right { display: flex; flex-direction: column; align-items: flex-end; }
.bid-history-amount { font-size: 0.9rem; font-weight: 600; color: #e6edf3; }

.bid-history-status {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 6px;
    margin-top: 4px;
}
.status-winning { background: rgba(63,185,80,0.15); color: #3fb950; }
.status-outbid { background: rgba(248,81,73,0.15); color: #f85149; }

.empty-state-small {
    text-align: center;
    padding: 32px 0;
    color: #8b949e;
}
.empty-state-small i { font-size: 2rem; margin-bottom: 8px; opacity: 0.4; display: block; }
.empty-state-small p { font-size: 0.85rem; }

@media (max-width: 1024px) { .stat-cards { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .stat-cards { grid-template-columns: 1fr; }
    .dashboard-grid { grid-template-columns: 1fr; }
}
</style>

<script>
(function() {
    var countdowns = document.querySelectorAll('.event-quick-countdown[data-end]');
    function updateCountdowns() {
        countdowns.forEach(function(el) {
            var end = new Date(el.getAttribute('data-end')).getTime();
            var now = Date.now();
            var diff = end - now;
            if (diff <= 0) {
                el.querySelector('.countdown-text').textContent = 'Selesai';
                el.style.color = '#f85149';
                return;
            }
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            var txt = '';
            if (d > 0) txt = d + 'h ' + h + 'j ' + m + 'm';
            else if (h > 0) txt = h + 'j ' + m + 'm ' + s + 'd';
            else txt = m + 'm ' + s + 'd';
            el.querySelector('.countdown-text').textContent = txt;
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);
})();
</script>
