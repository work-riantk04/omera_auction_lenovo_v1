<?php $title = 'Contact Us'; ?>

<?php
$sn = isset($settings) ? $settings : array();
$st = function($key, $default = '') use ($sn) {
    return (isset($sn[$key]) && $sn[$key] !== '') ? $sn[$key] : $default;
};
?>

<?php $this->load->view('welcome_header', ['title' => $title, 'csrf_token_name' => $csrf_token_name, 'csrf_hash' => $csrf_hash]); ?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title"><i class="fas fa-envelope"></i> <?= htmlspecialchars($st('contact_hero_title', 'Contact Us')) ?></h1>
        <p class="page-hero-subtitle"><?= htmlspecialchars($st('contact_hero_subtitle', 'Hubungi kami untuk pertanyaan, saran, atau kerja sama')) ?></p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-wrapper card-3d">
                <h3><i class="fas fa-paper-plane"></i> <?= htmlspecialchars($st('contact_form_title', 'Kirim Pesan')) ?></h3>
                <?= form_open('contact/submit', ['class' => 'contact-form']) ?>
                    <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                    <div class="form-group">
                        <label for="contactName"><i class="fas fa-user"></i> <?= htmlspecialchars($st('contact_form_name_label', 'Nama Lengkap')) ?></label>
                        <input type="text" id="contactName" name="name" class="form-control" placeholder="<?= htmlspecialchars($st('contact_form_name_placeholder', 'Masukkan nama lengkap')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contactEmail"><i class="fas fa-envelope"></i> <?= htmlspecialchars($st('contact_form_email_label', 'Email')) ?></label>
                        <input type="email" id="contactEmail" name="email" class="form-control" placeholder="<?= htmlspecialchars($st('contact_form_email_placeholder', 'Masukkan email')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contactSubject"><i class="fas fa-tag"></i> <?= htmlspecialchars($st('contact_form_subject_label', 'Subjek')) ?></label>
                        <input type="text" id="contactSubject" name="subject" class="form-control" placeholder="<?= htmlspecialchars($st('contact_form_subject_placeholder', 'Masukkan subjek')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contactMessage"><i class="fas fa-comment-dots"></i> <?= htmlspecialchars($st('contact_form_message_label', 'Pesan')) ?></label>
                        <textarea id="contactMessage" name="message" class="form-control" rows="5" placeholder="<?= htmlspecialchars($st('contact_form_message_placeholder', 'Tuliskan pesan Anda...')) ?>" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> <?= htmlspecialchars($st('contact_form_submit', 'Kirim Pesan')) ?>
                    </button>
                <?= form_close() ?>
            </div>

            <div class="contact-info-wrapper">
                <div class="contact-info-card card-3d">
                    <h3><i class="fas fa-address-card"></i> <?= htmlspecialchars($st('contact_info_title', 'Informasi Kontak')) ?></h3>
                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4><?= htmlspecialchars($st('contact_address_title', 'Alamat')) ?></h4>
                                <p><?= nl2br(htmlspecialchars($st('contact_address', 'Jl. Contoh No. 123<br>Jakarta, Indonesia'))) ?></p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4><?= htmlspecialchars($st('contact_email_title', 'Email')) ?></h4>
                                <p><?= htmlspecialchars($st('contact_email', 'info@omera-auction.com')) ?></p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-info-text">
                                <h4><?= htmlspecialchars($st('contact_phone_title', 'Telepon')) ?></h4>
                                <p><?= htmlspecialchars($st('contact_phone', '+62 xxx xxxx xxxx')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-social card-3d">
                    <h4><?= htmlspecialchars($st('contact_social_title', 'Ikuti Kami')) ?></h4>
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
