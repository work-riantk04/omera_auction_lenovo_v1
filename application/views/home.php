<?php
$sn = isset($settings) ? $settings : array();
$st = function($key, $default = '') use ($sn) {
    return (isset($sn[$key]) && $sn[$key] !== '') ? $sn[$key] : $default;
};
?>
<section class="hero-section">
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-content">
        <h1 class="hero-title">
            <span class="hero-title-accent"><?= htmlspecialchars($st('home_hero_title_accent', 'Temukan')) ?></span> <?= htmlspecialchars($st('home_hero_title', 'Barang Langka Terbaik di')) ?>
            <span class="hero-highlight"><?= htmlspecialchars($st('home_hero_highlight', 'Omera Auction')) ?></span>
        </h1>
        <p class="hero-subtitle">
            <?= htmlspecialchars($st('home_hero_subtitle', 'Platform lelang online terpercaya yang menghubungkan Titipers (penjual) dengan Bidders (pembeli). Temukan barang unik dan langka dengan harga terbaik melalui sistem lelang yang transparan dan aman.')) ?>
        </p>
        <div class="hero-actions">
            <a href="<?= base_url('events/list') ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-gavel"></i> <?= htmlspecialchars($st('home_hero_btn_primary', 'Mulai Lelang')) ?>
            </a>
            <a href="<?= base_url('about') ?>" class="btn btn-outline btn-lg">
                <i class="fas fa-info-circle"></i> <?= htmlspecialchars($st('home_hero_btn_secondary', 'Pelajari Lebih Lanjut')) ?>
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number" data-count="<?= count($active_events) ?>">0</div>
                <div class="stat-label"><?= htmlspecialchars($st('home_stat_event_label', 'Event Aktif')) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="<?= $total_items ?? 0 ?>">0</div>
                <div class="stat-label"><?= htmlspecialchars($st('home_stat_item_label', 'Total Barang')) ?></div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="<?= $total_bidders ?? 0 ?>">0</div>
                <div class="stat-label"><?= htmlspecialchars($st('home_stat_bidder_label', 'Bidders')) ?></div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($carousel_events)): ?>
<section class="carousel-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-calendar-star"></i> <?= htmlspecialchars($st('home_carousel_title', 'Event Terbaru')) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($st('home_carousel_subtitle', 'Jangan lewatkan event lelang menarik dari kami')) ?></p>
        </div>
        <div class="carousel-wrapper">
            <div class="carousel" id="eventCarousel">
                <div class="carousel-track">
                    <?php foreach ($carousel_events as $index => $event): ?>
                    <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                        <a href="<?= base_url('event/detail/' . $event['id']) ?>" class="carousel-link">
                            <div class="carousel-image">
                                <?php if ($event['banner_image']): ?>
                                    <img src="<?= base_url('uploads/events/' . $event['banner_image']) ?>" alt="<?= htmlspecialchars($event['name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-event.php') ?>'">
                                <?php else: ?>
                                    <div class="carousel-placeholder">
                                        <i class="fas fa-gavel"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="carousel-overlay">
                                    <div class="carousel-info">
                                        <span class="badge badge-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                                        <h3><?= htmlspecialchars($event['name']) ?></h3>
                                        <p class="carousel-date">
                                            <i class="fas fa-clock"></i>
                                            <?= date('d M Y', strtotime($event['auction_start'])) ?> - <?= date('d M Y', strtotime($event['auction_end'])) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn carousel-prev" id="carouselPrev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-next" id="carouselNext">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="carousel-dots" id="carouselDots">
                    <?php foreach ($carousel_events as $index => $event): ?>
                    <button class="carousel-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="active-auctions-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-fire"></i> <?= htmlspecialchars($st('home_active_title', 'Lelang Aktif')) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($st('home_active_subtitle', 'Barang-barang yang sedang dilelang secara langsung')) ?></p>
        </div>

        <?php if (!empty($active_items)): ?>
        <div class="items-grid">
            <?php foreach ($active_items as $item): ?>
            <div class="item-card card-3d">
                <div class="item-image">
                    <?php if (!empty($item['image'])): ?>
                        <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
                    <?php else: ?>
                        <div class="item-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($item['highest_bid']) && $item['highest_bid'] > $item['starting_price']): ?>
                        <span class="item-badge hot"><i class="fas fa-fire"></i> Hot</span>
                    <?php endif; ?>
                </div>
                <div class="item-body">
                    <h4 class="item-name"><?= htmlspecialchars($item['name']) ?></h4>
                    <p class="item-event"><i class="fas fa-calendar"></i> <?= htmlspecialchars($item['event_name'] ?? '') ?></p>
                    <div class="item-prices">
                        <div class="price-row">
                            <span class="price-label">Harga Awal</span>
                            <span class="price-value starting">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Tertinggi Saat Ini</span>
                            <span class="price-value current">Rp <?= number_format($item['highest_bid'] ?? $item['starting_price'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="item-timer">
                        <i class="fas fa-hourglass-half"></i>
                        <span class="countdown" data-end="<?= $item['auction_end'] ?? '' ?>">Memuat...</span>
                    </div>
                </div>
                <div class="item-footer">
                    <a href="<?= base_url('event/detail/' . $item['event_id']) ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state card-3d">
            <div class="empty-icon">
                <i class="fas fa-gavel"></i>
            </div>
            <h3><?= htmlspecialchars($st('home_empty_title', 'Event Lelang Belum Tersedia')) ?></h3>
            <p><?= htmlspecialchars($st('home_empty_message', 'Saat ini belum ada event lelang yang sedang berlangsung. Silakan cek kembali nanti atau lihat event yang akan datang.')) ?></p>
            <a href="<?= base_url('events/list') ?>" class="btn btn-primary">
                <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($st('home_empty_btn', 'Lihat Semua Event')) ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
