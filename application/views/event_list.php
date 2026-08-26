<?php $title = 'Events'; ?>

<?php $this->load->view('welcome_header', ['title' => $title]); ?>

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
                            <img src="<?= base_url('uploads/events/' . $event['banner_image']) ?>" alt="<?= htmlspecialchars($event['name']) ?>">
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
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.event-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php $this->load->view('welcome_footer'); ?>
