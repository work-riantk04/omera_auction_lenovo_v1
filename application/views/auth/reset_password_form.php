<?= $this->load->view('templates/header', [], TRUE) ?>

    <div class="auth-body">
        <div class="auth-card card-3d">
            <h2 class="auth-title"><i class="fas fa-lock"></i> Buat Password Baru</h2>
            <p class="auth-subtitle">Masukkan password baru Anda di bawah ini</p>

            <?php if (validation_errors()): ?>
            <div class="auth-errors">
                <?= validation_errors('<ul><li>', '</li></ul>') ?>
            </div>
            <?php endif; ?>

            <?= form_open('auth/reset_password_process/' . $token) ?>
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password Baru</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="newPassword" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6" style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" onclick="togglePassword('newPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Konfirmasi Password Baru</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirmNewPassword" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required minlength="6" style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" onclick="togglePassword('confirmNewPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-sync-alt"></i> Reset Password
                </button>
            <?= form_close() ?>

            <div class="auth-footer-text">
                <a href="<?= site_url('auth/login') ?>"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
            </div>
        </div>
    </div>

<?= $this->load->view('templates/footer', [], TRUE) ?>
