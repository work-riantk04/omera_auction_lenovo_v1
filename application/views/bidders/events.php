<div class="events-page">
    <div class="page-header">
        <h1><i class="fas fa-gavel"></i> Lelang</h1>
        <p style="color:#8b949e; margin-top:4px;">Jelajahi dan ikuti lelang yang sedang berlangsung.</p>
    </div>

    <div class="filter-bar">
        <button class="filter-btn active" data-filter="all" onclick="filterEvents('all', this)">Semua</button>
        <button class="filter-btn" data-filter="active" onclick="filterEvents('active', this)">
            <span class="filter-dot dot-green"></span> Aktif
        </button>
        <button class="filter-btn" data-filter="upcoming" onclick="filterEvents('upcoming', this)">
            <span class="filter-dot dot-blue"></span> Mendatang
        </button>
        <button class="filter-btn" data-filter="completed" onclick="filterEvents('completed', this)">
            <span class="filter-dot dot-gray"></span> Selesai
        </button>
    </div>

    <div class="events-grid" id="eventsGrid">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <?php
                    $status = $event['status'];
                    $filter_class = '';
                    if ($status === 'active') $filter_class = 'filter-active';
                    elseif ($status === 'upcoming' || $status === 'collecting' || $status === 'verifying') $filter_class = 'filter-upcoming';
                    else $filter_class = 'filter-completed';

                    $badge_class = 'badge-gray';
                    $badge_text = ucfirst($status);
                    if ($status === 'active') { $badge_class = 'badge-green'; $badge_text = 'Aktif'; }
                    elseif ($status === 'upcoming') { $badge_class = 'badge-blue'; $badge_text = 'Mendatang'; }
                    elseif ($status === 'completed') { $badge_class = 'badge-gray'; $badge_text = 'Selesai'; }
                    elseif ($status === 'collecting') { $badge_class = 'badge-yellow'; $badge_text = 'Pengumpulan'; }
                    elseif ($status === 'verifying') { $badge_class = 'badge-yellow'; $badge_text = 'Verifikasi'; }

                    $is_active_auction = ($status === 'active');
                    $banner = !empty($event['banner_image']) ? base_url('uploads/events/' . $event['banner_image']) : base_url('assets/images/default-banner.jpg');
                ?>
                <div class="event-card <?= $filter_class ?>" data-status="<?= $status ?>">
                    <div class="event-banner">
                        <img src="<?= $banner ?>" alt="<?= htmlspecialchars($event['name']) ?>" onerror="this.src='<?= base_url('assets/images/default-banner.jpg') ?>'">
                        <span class="event-badge <?= $badge_class ?>"><?= $badge_text ?></span>
                    </div>
                    <div class="event-card-body">
                        <h3 class="event-name"><?= htmlspecialchars($event['name']) ?></h3>
                        <div class="event-meta">
                            <span><i class="fas fa-box"></i> <?= $event['item_count'] ?? 0 ?> item</span>
                            <span><i class="fas fa-gavel"></i> <?= $event['bid_count'] ?? 0 ?> bid</span>
                        </div>
                        <?php if ($is_active_auction && !empty($event['auction_end'])): ?>
                            <div class="event-countdown" data-end="<?= $event['auction_end'] ?>">
                                <i class="fas fa-stopwatch"></i>
                                <span>Selesai dalam: <strong class="countdown-value">-</strong></span>
                            </div>
                        <?php elseif (!empty($event['auction_start'])): ?>
                            <div class="event-countdown event-countdown-upcoming" data-start="<?= $event['auction_start'] ?>">
                                <i class="fas fa-hourglass-start"></i>
                                <span>Mulai: <strong class="countdown-value">-</strong></span>
                            </div>
                        <?php endif; ?>
                        <a href="<?= site_url('bidders/event_bid/' . $event['id']) ?>" class="event-bid-btn <?= $is_active_auction ? '' : 'btn-disabled' ?>">
                            <?php if ($is_active_auction): ?>
                                <i class="fas fa-gavel"></i> Bid Sekarang
                            <?php elseif ($status === 'completed'): ?>
                                <i class="fas fa-check-circle"></i> Selesai
                            <?php else: ?>
                                <i class="fas fa-hourglass-half"></i> Belum Dimulai
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-gavel"></i>
                <h3>Belum Ada Lelang</h3>
                <p>Saat ini belum ada event lelang yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.events-page { max-width: 1200px; }
.page-header h1 { font-size: 1.6rem; font-weight: 700; color: #e6edf3; display: flex; align-items: center; gap: 10px; }
.page-header h1 i { color: #00d4ff; }

.filter-bar {
    display: flex;
    gap: 8px;
    margin: 24px 0;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 18px;
    border-radius: 8px;
    border: 1px solid #21262d;
    background: #161b22;
    color: #8b949e;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-btn:hover { border-color: #30363d; color: #e6edf3; }
.filter-btn.active { background: rgba(0,212,255,0.1); border-color: rgba(0,212,255,0.3); color: #00d4ff; }

.filter-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.dot-green { background: #3fb950; }
.dot-blue { background: #58a6ff; }
.dot-gray { background: #8b949e; }

.events-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.event-card {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    overflow: hidden;
    transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
}

.event-card:hover {
    transform: translateY(-4px);
    border-color: #30363d;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}

.event-banner {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.event-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.event-card:hover .event-banner img { transform: scale(1.05); }

.event-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-green { background: rgba(63,185,80,0.9); color: #fff; }
.badge-blue { background: rgba(88,166,255,0.9); color: #fff; }
.badge-yellow { background: rgba(210,153,34,0.9); color: #fff; }
.badge-gray { background: rgba(139,148,158,0.9); color: #fff; }
.badge-red { background: rgba(248,81,73,0.9); color: #fff; }

.event-card-body { padding: 20px; }

.event-name {
    font-size: 1.05rem;
    font-weight: 600;
    color: #e6edf3;
    margin-bottom: 10px;
    line-height: 1.3;
}

.event-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 12px;
}

.event-meta span {
    font-size: 0.8rem;
    color: #8b949e;
    display: flex;
    align-items: center;
    gap: 5px;
}

.event-meta span i { font-size: 0.72rem; }

.event-countdown {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    background: rgba(210,153,34,0.08);
    border: 1px solid rgba(210,153,34,0.15);
    border-radius: 8px;
    font-size: 0.82rem;
    color: #d29922;
    margin-bottom: 16px;
}

.event-countdown i { font-size: 0.9rem; }
.event-countdown strong { color: #f0c54d; }

.event-countdown-upcoming {
    background: rgba(88,166,255,0.08);
    border-color: rgba(88,166,255,0.15);
    color: #58a6ff;
}
.event-countdown-upcoming strong { color: #79c0ff; }

.event-bid-btn {
    display: block;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    background: linear-gradient(135deg, #00d4ff, #00b4d8);
    color: #0d1117;
}

.event-bid-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,212,255,0.3);
}

.event-bid-btn.btn-disabled {
    background: #21262d;
    color: #8b949e;
    cursor: not-allowed;
}

.event-bid-btn.btn-disabled:hover {
    transform: none;
    box-shadow: none;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #8b949e;
}
.empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.3; display: block; }
.empty-state h3 { font-size: 1.2rem; color: #e6edf3; margin-bottom: 8px; }
.empty-state p { font-size: 0.9rem; }

@media (max-width: 1024px) { .events-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .events-grid { grid-template-columns: 1fr; } }
</style>

<script>
function filterEvents(filter, btn) {
    document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');

    var cards = document.querySelectorAll('.event-card');
    cards.forEach(function(card) {
        var status = card.getAttribute('data-status');
        var show = false;
        if (filter === 'all') show = true;
        else if (filter === 'active' && status === 'active') show = true;
        else if (filter === 'upcoming' && ['upcoming','collecting','verifying'].indexOf(status) !== -1) show = true;
        else if (filter === 'completed' && (status === 'completed' || status === 'cancelled')) show = true;
        card.style.display = show ? '' : 'none';
    });
}

(function() {
    function updateCountdowns() {
        document.querySelectorAll('.event-countdown[data-end]').forEach(function(el) {
            var end = new Date(el.getAttribute('data-end')).getTime();
            var diff = end - Date.now();
            var val = el.querySelector('.countdown-value');
            if (diff <= 0) { val.textContent = 'Selesai'; el.style.color = '#f85149'; return; }
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            val.textContent = d > 0 ? d + 'h ' + h + 'j ' + m + 'm' : h + 'j ' + m + 'm ' + s + 'd';
        });

        document.querySelectorAll('.event-countdown-upcoming[data-start]').forEach(function(el) {
            var start = new Date(el.getAttribute('data-start')).getTime();
            var diff = start - Date.now();
            var val = el.querySelector('.countdown-value');
            if (diff <= 0) { val.textContent = 'Dimulai!'; location.reload(); return; }
            var d = Math.floor(diff / 86400000);
            var h = Math.floor((diff % 86400000) / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            val.textContent = d > 0 ? d + 'h ' + h + 'j ' + m + 'm' : h + 'j ' + m + 'm';
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);
})();
</script>
