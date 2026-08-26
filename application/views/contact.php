<?php $title = 'Contact Us'; ?>

<?php $this->load->view('welcome_header', ['title' => $title, 'csrf_token_name' => $csrf_token_name, 'csrf_hash' => $csrf_hash]); ?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><i class="fas fa-envelope"></i> Contact Us</h1>
        <p class="page-hero-subtitle">Hubungi kami untuk pertanyaan, saran, atau kerja sama</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-wrapper card-3d">
                <h3><i class="fas fa-paper-plane"></i> Kirim Pesan</h3>
                <?= form_open('contact/submit', ['class' => 'contact-form']) ?>
                    <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                    <div class="form-group">
                        <label for="contactName"><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" id="contactName" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="contactEmail"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="contactEmail" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="contactSubject"><i class="fas fa-tag"></i> Subjek</label>
                        <input type="text" id="contactSubject" name="subject" class="form-control" placeholder="Masukkan subjek" required>
                    </div>
                    <div class="form-group">
                        <label for="contactMessage"><i class="fas fa-comment-dots"></i> Pesan</label>
                        <textarea id="contactMessage" name="message" class="form-control" rows="5" placeholder="Tuliskan pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                <?= form_close() ?>
            </div>

            <div class="contact-info-wrapper">
                <div class="contact-info-card card-3d">
                    <h3><i class="fas fa-address-card"></i> Informasi Kontak</h3>
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Alamat</h4>
                                <p>Jl. Contoh No. 123<br>Jakarta, Indonesia</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Email</h4>
                                <p>info@omera-auction.com</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4>Telepon</h4>
                                <p>+62 xxx xxxx xxxx</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-social card-3d">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('welcome_footer'); ?>
