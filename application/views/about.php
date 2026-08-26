<?php $title = 'About'; ?>

<?php $this->load->view('welcome_header', ['title' => $title]); ?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><i class="fas fa-info-circle"></i> About Us</h1>
        <p class="page-hero-subtitle">Mengenal lebih dekat platform lelang Omera Auction</p>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="about-intro card-3d">
            <div class="about-intro-content">
                <h2>Apa itu <span class="text-gradient">Omera Auction</span>?</h2>
                <p>
                    Omera Auction adalah platform lelang online yang menghubungkan <strong>Titipers</strong> (penjual)
                    dengan <strong>Bidders</strong> (pembeli) dalam suasana lelang yang transparan, mudah, dan terpercaya.
                    Kami menyediakan wadah bagi siapa saja yang ingin menjual atau membeli barang langka dan unik
                    melalui sistem lelang digital yang profesional.
                </p>
                <p>
                    Dengan dukungan <strong>Admin</strong> yang mengelola setiap proses lelang, mulai dari verifikasi barang,
                    pengelolaan event, hingga pemrosesan pembayaran dan pengiriman, Omera Auction memastikan
                    setiap transaksi berjalan aman dan fair untuk semua pihak.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Mengapa Memilih Omera Auction?</h2>
            <p class="section-subtitle">Keunggulan yang kami tawarkan</p>
        </div>
        <div class="features-grid">
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Lelang Transparan</h3>
                <p>
                    Setiap proses lelang dapat dipantau secara real-time. Harga bid, jumlah peserta,
                    dan status lelang ditampilkan secara terbuka sehingga semua peserta mendapat informasi yang adil.
                </p>
            </div>
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-magic"></i>
                </div>
                <h3>Proses Mudah</h3>
                <p>
                    Mendaftar, mengajukan barang, hingga melakukan penawaran semuanya dapat dilakukan
                    dengan mudah melalui platform kami. Antarmuka yang intuitif membuat pengalaman lelang menyenangkan.
                </p>
            </div>
            <div class="feature-card card-3d">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Aman & Terpercaya</h3>
                <p>
                    Transaksi diproses melalui sistem yang aman. Pembayaran, verifikasi, pengiriman,
                    hingga pencairan dana dikelola oleh admin untuk menjamin keamanan setiap transaksi.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="workflow-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Bagaimana Cara Kerjanya?</h2>
            <p class="section-subtitle">Alur proses lelang di Omera Auction</p>
        </div>
        <div class="workflow-timeline">
            <div class="workflow-step card-3d">
                <div class="workflow-number">1</div>
                <div class="workflow-icon"><i class="fas fa-user-plus"></i></div>
                <h4>Daftar Akun</h4>
                <p>Daftar sebagai Titipers (penjual) atau Bidders (pembeli) dan lengkapi profil Anda.</p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">2</div>
                <div class="workflow-icon"><i class="fas fa-box-open"></i></div>
                <h4>Ajukan Barang</h4>
                <p>Titipers mengajukan barang ke event lelang yang tersedia. Admin akan memverifikasi setiap barang.</p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">3</div>
                <div class="workflow-icon"><i class="fas fa-gavel"></i></div>
                <h4>Lelang Dimulai</h4>
                <p>Bidders memberikan penawaran (bid) secara real-time saat event lelang aktif berlangsung.</p>
            </div>
            <div class="workflow-connector"><i class="fas fa-arrow-right"></i></div>
            <div class="workflow-step card-3d">
                <div class="workflow-number">4</div>
                <div class="workflow-icon"><i class="fas fa-trophy"></i></div>
                <h4>Menang & Bayar</h4>
                <p>Bidder tertinggi memenangkan lelang, melakukan pembayaran, dan barang dikirim oleh Titipers.</p>
            </div>
        </div>
    </div>
</section>

<section class="roles-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Peran Pengguna</h2>
            <p class="section-subtitle">Tiga peran utama dalam ekosistem Omera Auction</p>
        </div>
        <div class="roles-grid">
            <div class="role-card card-3d">
                <div class="role-icon titipers"><i class="fas fa-store"></i></div>
                <h3>Titipers</h3>
                <p>Penjual yang mengajukan barang untuk dilelang. Barang yang diajukan akan diverifikasi oleh admin sebelum masuk ke event lelang.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Ajukan barang ke event</li>
                    <li><i class="fas fa-check"></i> Pantau status barang</li>
                    <li><i class="fas fa-check"></i> Proses pengiriman</li>
                </ul>
            </div>
            <div class="role-card card-3d">
                <div class="role-icon bidders"><i class="fas fa-hand-holding-usd"></i></div>
                <h3>Bidders</h3>
                <p>Pembeli yang berpartisipasi dalam lelang dengan memberikan penawaran harga untuk barang yang diinginkan.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Ikut lelang barang</li>
                    <li><i class="fas fa-check"></i> Bid secara real-time</li>
                    <li><i class="fas fa-check"></i> Bayar & terima barang</li>
                </ul>
            </div>
            <div class="role-card card-3d">
                <div class="role-icon admin"><i class="fas fa-user-shield"></i></div>
                <h3>Admin</h3>
                <p>Pengelola platform yang mengawasi seluruh proses lelang dari awal hingga akhir.</p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Kelola event & barang</li>
                    <li><i class="fas fa-check"></i> Verifikasi pembayaran</li>
                    <li><i class="fas fa-check"></i> Proses pencairan dana</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('welcome_footer'); ?>
