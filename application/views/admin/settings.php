<div class="page-header">
    <h1 class="page-title"><i class="fas fa-cog"></i> Configurasi Konten Redaksional</h1>
    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
</div>

<p class="text-muted" style="margin-bottom:20px;">
    Kelola teks redaksional yang tampil di halaman depan (Home), halaman Tentang (About), dan halaman Hubungi Kami (Contact).
    Perubahan akan langsung diterapkan pada situs.
</p>

<?php
function sv($key)
{
    $settings = isset($GLOBALS['__settings']) ? $GLOBALS['__settings'] : array();
    $defaults = isset($GLOBALS['__defaults']) ? $GLOBALS['__defaults'] : array();
    if (isset($settings[$key]) && $settings[$key] !== '') {
        return $settings[$key];
    }
    if (isset($defaults[$key])) {
        return $defaults[$key];
    }
    return '';
}
$GLOBALS['__settings'] = isset($settings) ? $settings : array();
$GLOBALS['__defaults'] = isset($defaults) ? $defaults : array();
?>

<div class="settings-tabs">
    <button type="button" class="settings-tab active" data-tab="tab-home"><i class="fas fa-home"></i> Halaman Depan</button>
    <button type="button" class="settings-tab" data-tab="tab-about"><i class="fas fa-info-circle"></i> Tentang Kami</button>
    <button type="button" class="settings-tab" data-tab="tab-contact"><i class="fas fa-envelope"></i> Hubungi Kami</button>
</div>

<!-- ============================ HOME ============================ -->
<div class="settings-panel active" id="tab-home">
    <?= form_open('admin/settings_save', ['class' => 'settings-form']) ?>
        <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">

        <div class="settings-section-title"><i class="fas fa-star"></i> Hero / Banner</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Utama (Kata Aksen)<span class="required">*</span></label>
                    <input type="text" name="home[home_hero_title_accent]" class="form-control" value="<?= htmlspecialchars(sv('home_hero_title_accent')) ?>">
                </div>
                <div class="form-group">
                    <label>Judul Utama (Bagian Tengah)<span class="required">*</span></label>
                    <input type="text" name="home[home_hero_title]" class="form-control" value="<?= htmlspecialchars(sv('home_hero_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Judul Utama (Bagian Sorotan)<span class="required">*</span></label>
                    <input type="text" name="home[home_hero_highlight]" class="form-control" value="<?= htmlspecialchars(sv('home_hero_highlight')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Subjudul / Deskripsi Hero<span class="required">*</span></label>
                    <textarea name="home[home_hero_subtitle]" class="form-control" rows="4"><?= htmlspecialchars(sv('home_hero_subtitle')) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Tombol Utama (Mulai Lelang)</label>
                    <input type="text" name="home[home_hero_btn_primary]" class="form-control" value="<?= htmlspecialchars(sv('home_hero_btn_primary')) ?>">
                </div>
                <div class="form-group">
                    <label>Tombol Sekunder (Pelajari)</label>
                    <input type="text" name="home[home_hero_btn_secondary]" class="form-control" value="<?= htmlspecialchars(sv('home_hero_btn_secondary')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-chart-line"></i> Statistik Hero</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Label Statistik - Event Aktif</label>
                    <input type="text" name="home[home_stat_event_label]" class="form-control" value="<?= htmlspecialchars(sv('home_stat_event_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Statistik - Total Barang</label>
                    <input type="text" name="home[home_stat_item_label]" class="form-control" value="<?= htmlspecialchars(sv('home_stat_item_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Statistik - Bidders</label>
                    <input type="text" name="home[home_stat_bidder_label]" class="form-control" value="<?= htmlspecialchars(sv('home_stat_bidder_label')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-calendar-star"></i> Section Event Terbaru (Carousel)</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Section</label>
                    <input type="text" name="home[home_carousel_title]" class="form-control" value="<?= htmlspecialchars(sv('home_carousel_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Section</label>
                    <input type="text" name="home[home_carousel_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('home_carousel_subtitle')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-fire"></i> Section Lelang Aktif</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Section</label>
                    <input type="text" name="home[home_active_title]" class="form-control" value="<?= htmlspecialchars(sv('home_active_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Section</label>
                    <input type="text" name="home[home_active_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('home_active_subtitle')) ?>">
                </div>
                <div class="form-group">
                    <label>Judul Kosong (Tidak Ada Event)</label>
                    <input type="text" name="home[home_empty_title]" class="form-control" value="<?= htmlspecialchars(sv('home_empty_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Tombol Kosong (Lihat Semua Event)</label>
                    <input type="text" name="home[home_empty_btn]" class="form-control" value="<?= htmlspecialchars(sv('home_empty_btn')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Pesan Kosong</label>
                    <textarea name="home[home_empty_message]" class="form-control" rows="3"><?= htmlspecialchars(sv('home_empty_message')) ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Halaman Depan</button>
        </div>
    <?= form_close() ?>
</div>

<!-- ============================ ABOUT ============================ -->
<div class="settings-panel" id="tab-about">
    <?= form_open('admin/settings_save', ['class' => 'settings-form']) ?>
        <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">

        <div class="settings-section-title"><i class="fas fa-bullhorn"></i> Hero Halaman</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Hero</label>
                    <input type="text" name="about[about_hero_title]" class="form-control" value="<?= htmlspecialchars(sv('about_hero_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Hero</label>
                    <input type="text" name="about[about_hero_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('about_hero_subtitle')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-book"></i> Intro / Apa itu Omera Auction</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Intro</label>
                    <input type="text" name="about[about_apa_title]" class="form-control" value="<?= htmlspecialchars(sv('about_apa_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Nama Brand (Sorotan)</label>
                    <input type="text" name="about[about_apa_brand]" class="form-control" value="<?= htmlspecialchars(sv('about_apa_brand')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Paragraf 1</label>
                    <textarea name="about[about_desc1]" class="form-control" rows="4"><?= htmlspecialchars(sv('about_desc1')) ?></textarea>
                </div>
                <div class="form-group full-width">
                    <label>Paragraf 2</label>
                    <textarea name="about[about_desc2]" class="form-control" rows="4"><?= htmlspecialchars(sv('about_desc2')) ?></textarea>
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-thumbs-up"></i> Keunggulan / Fitur</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Section</label>
                    <input type="text" name="about[about_features_title]" class="form-control" value="<?= htmlspecialchars(sv('about_features_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Section</label>
                    <input type="text" name="about[about_features_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('about_features_subtitle')) ?>">
                </div>
            </div>
        </div>
        <div class="form-card">
            <div class="settings-row">
                <div class="form-group">
                    <label>Fitur 1 - Judul</label>
                    <input type="text" name="about[about_feature1_title]" class="form-control" value="<?= htmlspecialchars(sv('about_feature1_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Fitur 1 - Deskripsi</label>
                    <textarea name="about[about_feature1_desc]" class="form-control" rows="3"><?= htmlspecialchars(sv('about_feature1_desc')) ?></textarea>
                </div>
            </div>
            <div class="settings-row">
                <div class="form-group">
                    <label>Fitur 2 - Judul</label>
                    <input type="text" name="about[about_feature2_title]" class="form-control" value="<?= htmlspecialchars(sv('about_feature2_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Fitur 2 - Deskripsi</label>
                    <textarea name="about[about_feature2_desc]" class="form-control" rows="3"><?= htmlspecialchars(sv('about_feature2_desc')) ?></textarea>
                </div>
            </div>
            <div class="settings-row">
                <div class="form-group">
                    <label>Fitur 3 - Judul</label>
                    <input type="text" name="about[about_feature3_title]" class="form-control" value="<?= htmlspecialchars(sv('about_feature3_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Fitur 3 - Deskripsi</label>
                    <textarea name="about[about_feature3_desc]" class="form-control" rows="3"><?= htmlspecialchars(sv('about_feature3_desc')) ?></textarea>
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-sitemap"></i> Cara Kerja / Alur</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Section</label>
                    <input type="text" name="about[about_workflow_title]" class="form-control" value="<?= htmlspecialchars(sv('about_workflow_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Section</label>
                    <input type="text" name="about[about_workflow_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('about_workflow_subtitle')) ?>">
                </div>
            </div>
        </div>
        <div class="form-card">
            <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="settings-row">
                <div class="form-group">
                    <label>Langkah <?= $i ?> - Judul</label>
                    <input type="text" name="about[about_workflow<?= $i ?>_title]" class="form-control" value="<?= htmlspecialchars(sv('about_workflow' . $i . '_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Langkah <?= $i ?> - Deskripsi</label>
                    <textarea name="about[about_workflow<?= $i ?>_desc]" class="form-control" rows="2"><?= htmlspecialchars(sv('about_workflow' . $i . '_desc')) ?></textarea>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="settings-section-title"><i class="fas fa-users"></i> Peran Pengguna</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Section</label>
                    <input type="text" name="about[about_roles_title]" class="form-control" value="<?= htmlspecialchars(sv('about_roles_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Section</label>
                    <input type="text" name="about[about_roles_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('about_roles_subtitle')) ?>">
                </div>
            </div>
        </div>
        <div class="form-card">
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="settings-row">
                <div class="form-group">
                    <label>Peran <?= $i ?> - Nama</label>
                    <input type="text" name="about[about_role<?= $i ?>_title]" class="form-control" value="<?= htmlspecialchars(sv('about_role' . $i . '_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Peran <?= $i ?> - Deskripsi</label>
                    <textarea name="about[about_role<?= $i ?>_desc]" class="form-control" rows="2"><?= htmlspecialchars(sv('about_role' . $i . '_desc')) ?></textarea>
                </div>
            </div>
            <div class="settings-row">
                <?php for ($f = 1; $f <= 3; $f++): ?>
                <div class="form-group">
                    <label>Peran <?= $i ?> - Poin <?= $f ?></label>
                    <input type="text" name="about[about_role<?= $i ?>_feat<?= $f ?>]" class="form-control" value="<?= htmlspecialchars(sv('about_role' . $i . '_feat' . $f)) ?>">
                </div>
                <?php endfor; ?>
            </div>
            <?php endfor; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Halaman Tentang</button>
        </div>
    <?= form_close() ?>
</div>

<!-- ============================ CONTACT ============================ -->
<div class="settings-panel" id="tab-contact">
    <?= form_open('admin/settings_save', ['class' => 'settings-form']) ?>
        <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">

        <div class="settings-section-title"><i class="fas fa-bullhorn"></i> Hero Halaman</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group">
                    <label>Judul Hero</label>
                    <input type="text" name="contact[contact_hero_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_hero_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Subjudul Hero</label>
                    <input type="text" name="contact[contact_hero_subtitle]" class="form-control" value="<?= htmlspecialchars(sv('contact_hero_subtitle')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-paper-plane"></i> Formulir Kontak</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Judul Formulir</label>
                    <input type="text" name="contact[contact_form_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Nama</label>
                    <input type="text" name="contact[contact_form_name_label]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_name_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Placeholder Nama</label>
                    <input type="text" name="contact[contact_form_name_placeholder]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_name_placeholder')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Email</label>
                    <input type="text" name="contact[contact_form_email_label]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_email_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Placeholder Email</label>
                    <input type="text" name="contact[contact_form_email_placeholder]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_email_placeholder')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Subjek</label>
                    <input type="text" name="contact[contact_form_subject_label]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_subject_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Placeholder Subjek</label>
                    <input type="text" name="contact[contact_form_subject_placeholder]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_subject_placeholder')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Pesan</label>
                    <input type="text" name="contact[contact_form_message_label]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_message_label')) ?>">
                </div>
                <div class="form-group">
                    <label>Placeholder Pesan</label>
                    <input type="text" name="contact[contact_form_message_placeholder]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_message_placeholder')) ?>">
                </div>
                <div class="form-group">
                    <label>Teks Tombol Kirim</label>
                    <input type="text" name="contact[contact_form_submit]" class="form-control" value="<?= htmlspecialchars(sv('contact_form_submit')) ?>">
                </div>
            </div>
        </div>

        <div class="settings-section-title"><i class="fas fa-address-card"></i> Informasi Kontak</div>
        <div class="form-card">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Judul Informasi Kontak</label>
                    <input type="text" name="contact[contact_info_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_info_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Alamat</label>
                    <input type="text" name="contact[contact_address_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_address_title')) ?>">
                </div>
                <div class="form-group full-width">
                    <label>Alamat</label>
                    <textarea name="contact[contact_address]" class="form-control" rows="2"><?= htmlspecialchars(sv('contact_address')) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Label Email</label>
                    <input type="text" name="contact[contact_email_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_email_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="contact[contact_email]" class="form-control" value="<?= htmlspecialchars(sv('contact_email')) ?>">
                </div>
                <div class="form-group">
                    <label>Label Telepon</label>
                    <input type="text" name="contact[contact_phone_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_phone_title')) ?>">
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="contact[contact_phone]" class="form-control" value="<?= htmlspecialchars(sv('contact_phone')) ?>">
                </div>
                <div class="form-group">
                    <label>Judul Sosial Media</label>
                    <input type="text" name="contact[contact_social_title]" class="form-control" value="<?= htmlspecialchars(sv('contact_social_title')) ?>">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Halaman Kontak</button>
        </div>
    <?= form_close() ?>
</div>

<style>
.settings-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border, #e2e8f0);
    padding-bottom: 12px;
}
.settings-tab {
    padding: 10px 18px;
    border: 1px solid var(--border, #e2e8f0);
    background: var(--card-bg, #fff);
    color: inherit;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all .2s;
}
.settings-tab.active {
    background: var(--primary, #6366f1);
    border-color: var(--primary, #6366f1);
    color: #fff;
}
.settings-panel { display: none; }
.settings-panel.active { display: block; }
.settings-section-title {
    font-size: 15px;
    font-weight: 700;
    margin: 24px 0 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text, #1e293b);
}
.settings-row {
    border-top: 1px dashed var(--border, #e2e8f0);
    padding-top: 14px;
    margin-top: 14px;
}
.settings-row:first-child { border-top: none; margin-top: 0; padding-top: 0; }
</style>

<script>
(function() {
    var tabs = document.querySelectorAll('.settings-tab');
    tabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var target = this.getAttribute('data-tab');
            document.querySelectorAll('.settings-tab').forEach(function(b) { b.classList.remove('active'); });
            document.querySelectorAll('.settings-panel').forEach(function(p) { p.classList.remove('active'); });
            this.classList.add('active');
            var panel = document.getElementById(target);
            if (panel) panel.classList.add('active');
        });
    });
})();
</script>
