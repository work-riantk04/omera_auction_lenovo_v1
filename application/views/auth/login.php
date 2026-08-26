<?= $this->load->view('templates/header', [], TRUE) ?>

    <div class="auth-body">
        <div class="auth-card card-3d">
            <h2 class="auth-title"><i class="fas fa-sign-in-alt"></i> Masuk ke Akun Anda</h2>
            <p class="auth-subtitle">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>

            <?php if (validation_errors()): ?>
            <div class="auth-errors">
                <?= validation_errors('<ul><li>', '</li></ul>') ?>
            </div>
            <?php endif; ?>

            <?= form_open('auth/login') ?>
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="<?= set_value('email') ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Masukkan password" required style="padding-right: 42px;">
                        <button type="button" class="toggle-pw" onclick="togglePassword('loginPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            <?= form_close() ?>

            <div class="auth-link">
                <a href="<?= site_url('auth/reset_password') ?>">Lupa Password?</a>
            </div>

            <div class="auth-divider"><span>atau</span></div>

            <div class="auth-footer-text">
                Belum punya akun? <a href="<?= site_url('auth/register') ?>">Daftar sekarang</a>
            </div>
        </div>
    </div>

<?= $this->load->view('templates/footer', [], TRUE) ?>
