<?= $this->load->view('templates/header', [], TRUE) ?>

    <div class="auth-body">
        <div class="auth-card card-3d">
            <h2 class="auth-title"><i class="fas fa-key"></i> Reset Password</h2>
            <p class="auth-subtitle">Masukkan email Anda untuk menerima link reset password</p>

            <?php if (validation_errors()): ?>
            <div class="auth-errors">
                <?= validation_errors('<ul><li>', '</li></ul>') ?>
            </div>
            <?php endif; ?>

            <?= form_open('auth/reset_password') ?>
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email terdaftar" value="<?= set_value('email') ?>" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-paper-plane"></i> Kirim Link Reset
                </button>
            <?= form_close() ?>

            <div class="auth-footer-text">
                <a href="<?= site_url('auth/login') ?>"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
            </div>
        </div>
    </div>

<?= $this->load->view('templates/footer', [], TRUE) ?>
