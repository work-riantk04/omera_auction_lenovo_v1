<?php $title = 'Events'; ?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><i class="fas fa-calendar-alt"></i> Events</h1>
        <p class="page-hero-subtitle">Semua event lelang yang tersedia di Omera Auction</p>
    </div>
</section>

<section class="events-section">
    <div class="container">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">
                <i class="fas fa-th"></i> Semua
            </button>
            <button class="filter-tab" data-filter="upcoming">
                <i class="fas fa-clock"></i> Akan Datang
            </button>
            <button class="filter-tab" data-filter="active">
                <i class="fas fa-play-circle"></i> Aktif
            </button>
            <button class="filter-tab" data-filter="completed">
                <i class="fas fa-check-circle"></i> Selesai
            </button>
        </div>

        <?php if (!empty($events)): ?>
        <div class="events-grid" id="eventsGrid">
            <?php foreach ($events as $event): ?>
            <div class="event-card card-3d" data-status="<?= $event['status'] ?>">
                <a href="<?= base_url('event/detail/' . $event['id']) ?>" class="event-card-link">
                    <div class="event-image">
                        <?php if ($event['banner_image']): ?>
                            <img src="<?= base_url('uploads/events/' . $event['banner_image']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-event.php') ?>'">
                        <?php else: ?>
                            <div class="event-placeholder">
                                <i class="fas fa-gavel"></i>
                            </div>
                        <?php endif; ?>
                        <span class="event-status-badge badge badge-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                    </div>
                    <div class="event-body">
                        <h3 class="event-name"><?= htmlspecialchars($event['name']) ?></h3>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="fas fa-box"></i>
                                <span><?= $event['item_count'] ?? 0 ?> Barang</span>
                            </div>
                            <?php if (isset($event['bid_count'])): ?>
                            <div class="event-meta-item">
                                <i class="fas fa-gavel"></i>
                                <span><?= $event['bid_count'] ?> Bids</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="event-dates">
                            <div class="event-date-item">
                                <i class="fas fa-play"></i>
                                <span>Mulai: <?= date('d M Y', strtotime($event['auction_start'])) ?></span>
                            </div>
                            <div class="event-date-item">
                                <i class="fas fa-stop"></i>
                                <span>Selesai: <?= date('d M Y', strtotime($event['auction_end'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="event-footer">
                        <span class="btn btn-outline btn-block btn-sm">
                            <i class="fas fa-arrow-right"></i> Lihat Detail
                        </span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if ($has_more): ?>
        <div class="load-more-wrap" style="text-align:center;margin-top:30px;">
            <button type="button" class="btn btn-outline btn-lg" id="loadMoreBtn">
                <i class="fas fa-sync-alt"></i> Load More
            </button>
        </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="empty-state card-3d">
            <div class="empty-icon">
                <i class="fas fa-calendar-times"></i>
            </div>
            <h3>Belum Ada Event</h3>
            <p>Saat ini belum ada event lelang yang tersedia. Silakan cek kembali nanti.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const BASE_URL = <?= json_encode(base_url()) ?>;
    const grid = document.getElementById('eventsGrid');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const tabs = document.querySelectorAll('.filter-tab');

    let currentFilter = 'all';
    let offset = <?= (int) count($events) ?>;

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(dateStr) {
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return '';
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return String(d.getDate()).padStart(2, '0') + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    function buildCard(event) {
        const image = event.banner_image
            ? '<img src="' + BASE_URL + 'uploads/events/' + escapeHtml(event.banner_image) + '" alt="' + escapeHtml(event.name) + '" onerror="this.onerror=null;this.src=\'' + BASE_URL + 'assets/images/placeholder-event.php\'">'
            : '<div class="event-placeholder"><i class="fas fa-gavel"></i></div>';

        let meta = '<div class="event-meta-item"><i class="fas fa-box"></i><span>' + (event.item_count || 0) + ' Barang</span></div>';
        if (event.bid_count != null) {
            meta += '<div class="event-meta-item"><i class="fas fa-gavel"></i><span>' + (event.bid_count || 0) + ' Bids</span></div>';
        }

        return '' +
            '<div class="event-card card-3d" data-status="' + escapeHtml(event.status) + '">' +
                '<a href="' + BASE_URL + 'event/detail/' + event.id + '" class="event-card-link">' +
                    '<div class="event-image">' + image +
                        '<span class="event-status-badge badge badge-' + escapeHtml(event.status) + '">' + escapeHtml(event.status.charAt(0).toUpperCase() + event.status.slice(1)) + '</span>' +
                    '</div>' +
                    '<div class="event-body">' +
                        '<h3 class="event-name">' + escapeHtml(event.name) + '</h3>' +
                        '<div class="event-meta">' + meta + '</div>' +
                        '<div class="event-dates">' +
                            '<div class="event-date-item"><i class="fas fa-play"></i><span>Mulai: ' + formatDate(event.auction_start) + '</span></div>' +
                            '<div class="event-date-item"><i class="fas fa-stop"></i><span>Selesai: ' + formatDate(event.auction_end) + '</span></div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="event-footer"><span class="btn btn-outline btn-block btn-sm"><i class="fas fa-arrow-right"></i> Lihat Detail</span></div>' +
                '</a>' +
            '</div>';
    }

    function applyFilter() {
        document.querySelectorAll('.event-card').forEach(function(card) {
            card.style.display = (currentFilter === 'all' || card.dataset.status === currentFilter) ? '' : 'none';
        });
    }

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            tabs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            applyFilter();
        });
    });

    <?php if ($has_more): ?>
    loadMoreBtn.addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

        fetch(BASE_URL + 'api/events/' + offset)
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.status === 'success' && data.data.length > 0) {
                    grid.insertAdjacentHTML('beforeend', data.data.map(buildCard).join(''));
                    offset += data.data.length;
                    applyFilter();
                    if (!data.has_more) {
                        btn.style.display = 'none';
                    }
                } else {
                    btn.style.display = 'none';
                }
            })
            .catch(function() { })
            .finally(function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt"></i> Load More';
            });
    });
    <?php endif; ?>
});
</script>

<?php $this->load->view('welcome_footer'); ?>
