<?= $this->load->view('templates/header', [], TRUE) ?>

    <div class="auth-body">
        <div class="auth-card card-3d" style="max-width: 500px;">
            <h2 class="auth-title"><i class="fas fa-user-plus"></i> Buat Akun Baru</h2>
            <p class="auth-subtitle">Daftar untuk mulai menggunakan Omera Auction</p>

            <?php if (validation_errors()): ?>
            <div class="auth-errors">
                <?= validation_errors('<ul><li>', '</li></ul>') ?>
            </div>
            <?php endif; ?>

            <?= form_open('auth/register') ?>
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama Lengkap</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="<?= set_value('name') ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="<?= set_value('email') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-phone"></i> No. Telepon</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-phone"></i></span>
                        <input type="tel" name="phone" class="form-control" placeholder="Masukkan no. telepon" value="<?= set_value('phone') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="regPassword" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6" oninput="checkPasswordStrength(this.value)" style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" onclick="togglePassword('regPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Konfirmasi Password</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="regConfirmPassword" name="confirm_password" class="form-control" placeholder="Ulangi password" required minlength="6" style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" onclick="togglePassword('regConfirmPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-users-cog"></i> Daftar Sebagai</label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" name="role" id="roleTitipers" value="titipers" <?= set_value('role') === 'titipers' ? 'checked' : '' ?>>
                            <label for="roleTitipers" class="role-label">
                                <span class="role-icon"><i class="fas fa-store"></i></span>
                                <span class="role-name">Titipers</span>
                                <span class="role-desc">Jual barang lewat lelang</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="roleBidders" value="bidders" <?= set_value('role') === 'bidders' ? 'checked' : '' ?>>
                            <label for="roleBidders" class="role-label">
                                <span class="role-icon"><i class="fas fa-gavel"></i></span>
                                <span class="role-name">Bidders</span>
                                <span class="role-desc">Ikut serta dalam lelang</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="terms" name="terms" value="1" required>
                    <label for="terms">Saya menyetujui syarat & ketentuan</label>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            <?= form_close() ?>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="<?= site_url('auth/login') ?>">Masuk</a>
            </div>
        </div>
    </div>

<script>
function checkPasswordStrength(password) {
    var bar = document.getElementById('strengthBar');
    var text = document.getElementById('strengthText');
    if (!bar || !text) return;

    var strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    var levels = [
        { width: '0%', color: 'transparent', label: '' },
        { width: '20%', color: '#ef4444', label: 'Sangat lemah' },
        { width: '40%', color: '#f59e0b', label: 'Lemah' },
        { width: '60%', color: '#f59e0b', label: 'Sedang' },
        { width: '80%', color: '#22c55e', label: 'Kuat' },
        { width: '100%', color: '#22c55e', label: 'Sangat kuat' }
    ];

    var level = levels[strength];
    bar.style.width = level.width;
    bar.style.background = level.color;
    text.textContent = level.label;
    text.style.color = level.color;
}
</script>

<?= $this->load->view('templates/footer', [], TRUE) ?>
