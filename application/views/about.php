<?php $title = 'About'; ?>

<?php
$sn = isset($settings) ? $settings : array();
$st = function($key, $default = '') use ($sn) {
    return (isset($sn[$key]) && $sn[$key] !== '') ? $sn[$key] : $default;
};
?>

<?php $this->load->view('welcome_header', ['title' => $title]); ?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><i class="fas fa-info-circle"></i> <?= htmlspecialchars($st('about_hero_title', 'About Us')) ?></h1>
        <p class="page-hero-subtitle"><?= htmlspecialchars($st('about_hero_subtitle', 'Mengenal lebih dekat platform lelang Omera Auction')) ?></p>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="about-intro card-3d">
            <div class="about-intro-content">
                <h2><?= htmlspecialchars($st('about_apa_title', 'Apa itu Omera Auction?')) ?> <span class="text-gradient"><?= htmlspecialchars($st('about_apa_brand', 'Omera Auction')) ?></span></h2>
                <p>
                    <?= nl2br(htmlspecialchars($st('about_desc1', 'Omera Auction adalah platform lelang online yang menghubungkan Titipers (penjual) dengan Bidders (pembeli) dalam suasana lelang yang transparan, mudah, dan terpercaya. Kami menyediakan wadah bagi siapa saja yang ingin menjual atau membeli barang langka dan unik melalui sistem lelang digital yang profesional.'))) ?>
                </p>
                <p>
                    <?= nl2br(htmlspecialchars($st('about_desc2', 'Dengan dukungan Admin yang mengelola setiap proses lelang, mulai dari verifikasi barang, pengelolaan event, hingga pemrosesan pembayaran dan pengiriman, Omera Auction memastikan setiap transaksi berjalan aman dan fair untuk semua pihak.'))) ?>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= htmlspecialchars($st('about_features_title', 'Mengapa Memilih Omera Auction?')) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($st('about_features_subtitle', 'Keunggulan yang kami tawarkan')) ?></p>
        </div>
        <div class="features-grid">
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3><?= htmlspecialchars($st('about_feature1_title', 'Lelang Transparan')) ?></h3>
                <p>
                    <?= nl2br(htmlspecialchars($st('about_feature1_desc', 'Setiap proses lelang dapat dipantau secara real-time. Harga bid, jumlah peserta, dan status lelang ditampilkan secara terbuka sehingga semua peserta mendapat informasi yang adil.'))) ?>
                </p>
            </div>
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-magic"></i>
                </div>
                <h3><?= htmlspecialchars($st('about_feature2_title', 'Proses Mudah')) ?></h3>
                <p>
                    <?= nl2br(htmlspecialchars($st('about_feature2_desc', 'Mendaftar, mengajukan barang, hingga melakukan penawaran semuanya dapat dilakukan dengan mudah melalui platform kami. Antarmuka yang intuitif membuat pengalaman lelang menyenangkan.'))) ?>
                </p>
            </div>
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3><?= htmlspecialchars($st('about_feature3_title', 'Aman & Terpercaya')) ?></h3>
                <p>
                    <?= nl2br(htmlspecialchars($st('about_feature3_desc', 'Transaksi diproses melalui sistem yang aman. Pembayaran, verifikasi, pengiriman, hingga pencairan dana dikelola oleh admin untuk menjamin keamanan setiap transaksi.'))) ?>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="workflow-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= htmlspecialchars($st('about_workflow_title', 'Bagaimana Cara Kerjanya?')) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($st('about_workflow_subtitle', 'Alur proses lelang di Omera Auction')) ?></p>
        </div>
        <div class="workflow-timeline">
            <div class="workflow-step card-3d">
                <div class="workflow-number">1</div>
                <div class="workflow-icon"><i class="fas fa-user-plus"></i></div>
                <h4><?= htmlspecialchars($st('about_workflow1_title', 'Daftar Akun')) ?></h4>
                <p><?= nl2br(htmlspecialchars($st('about_workflow1_desc', 'Daftar sebagai Titipers (penjual) atau Bidders (pembeli) dan lengkapi profil Anda.'))) ?></p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">2</div>
                <div class="workflow-icon"><i class="fas fa-box-open"></i></div>
                <h4><?= htmlspecialchars($st('about_workflow2_title', 'Ajukan Barang')) ?></h4>
                <p><?= nl2br(htmlspecialchars($st('about_workflow2_desc', 'Titipers mengajukan barang ke event lelang yang tersedia. Admin akan memverifikasi setiap barang.'))) ?></p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">3</div>
                <div class="workflow-icon"><i class="fas fa-gavel"></i></div>
                <h4><?= htmlspecialchars($st('about_workflow3_title', 'Lelang Dimulai')) ?></h4>
                <p><?= nl2br(htmlspecialchars($st('about_workflow3_desc', 'Bidders memberikan penawaran (bid) secara real-time saat event lelang aktif berlangsung.'))) ?></p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">4</div>
                <div class="workflow-icon"><i class="fas fa-trophy"></i></div>
                <h4><?= htmlspecialchars($st('about_workflow4_title', 'Menang & Bayar')) ?></h4>
                <p><?= nl2br(htmlspecialchars($st('about_workflow4_desc', 'Bidder tertinggi memenangkan lelang, melakukan pembayaran, dan barang dikirim oleh Titipers.'))) ?></p>
            </div>
        </div>
    </div>
</section>

<section class="roles-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><?= htmlspecialchars($st('about_roles_title', 'Peran Pengguna')) ?></h2>
            <p class="section-subtitle"><?= htmlspecialchars($st('about_roles_subtitle', 'Tiga peran utama dalam ekosistem Omera Auction')) ?></p>
        </div>
        <div class="roles-grid">
            <div class="role-card card-3d">
                <div class="role-icon titipers"><i class="fas fa-store"></i></div>
                <h3><?= htmlspecialchars($st('about_role1_title', 'Titipers')) ?></h3>
                <p><?= nl2br(htmlspecialchars($st('about_role1_desc', 'Penjual yang mengajukan barang untuk dilelang. Barang yang diajukan akan diverifikasi oleh admin sebelum masuk ke event lelang.'))) ?></p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role1_feat1', 'Ajukan barang ke event')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role1_feat2', 'Pantau status barang')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role1_feat3', 'Proses pengiriman')) ?></li>
                </ul>
            </div>
            <div class="role-card card-3d">
                <div class="role-icon bidders"><i class="fas fa-hand-holding-usd"></i></div>
                <h3><?= htmlspecialchars($st('about_role2_title', 'Bidders')) ?></h3>
                <p><?= nl2br(htmlspecialchars($st('about_role2_desc', 'Pembeli yang berpartisipasi dalam lelang dengan memberikan penawaran harga untuk barang yang diinginkan.'))) ?></p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role2_feat1', 'Ikut lelang barang')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role2_feat2', 'Bid secara real-time')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role2_feat3', 'Bayar & terima barang')) ?></li>
                </ul>
            </div>
            <div class="role-card card-3d">
                <div class="role-icon admin"><i class="fas fa-user-shield"></i></div>
                <h3><?= htmlspecialchars($st('about_role3_title', 'Admin')) ?></h3>
                <p><?= nl2br(htmlspecialchars($st('about_role3_desc', 'Pengelola platform yang mengawasi seluruh proses lelang dari awal hingga akhir.'))) ?></p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role3_feat1', 'Kelola event & barang')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role3_feat2', 'Verifikasi pembayaran')) ?></li>
                    <li><i class="fas fa-check"></i> <?= htmlspecialchars($st('about_role3_feat3', 'Proses pencairan dana')) ?></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('welcome_footer'); ?>
