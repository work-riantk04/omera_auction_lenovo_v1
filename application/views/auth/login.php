<div class="auth-body">
        <div class="auth-card card-3d">
            <h2 class="auth-title"><i class="fas fa-sign-in-alt"></i> Masuk ke Akun Anda</h2>
            <p class="auth-subtitle">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>

            <div id="loginAlert" class="auth-alert" style="display:none"></div>

            <form id="loginForm" method="POST" action="<?= site_url('auth/login') ?>" novalidate>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
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

                <button type="submit" class="btn-auth" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <div class="auth-link">
                <a href="<?= site_url('auth/reset_password') ?>">Lupa Password?</a>
            </div>

            <div class="auth-divider"><span>atau</span></div>

            <div class="auth-footer-text">
                Belum punya akun? <a href="<?= site_url('auth/register') ?>">Daftar sekarang</a>
            </div>
        </div>
    </div>

<script>
(function() {
    var form = document.getElementById('loginForm');
    var btn = document.getElementById('loginBtn');
    var alertBox = document.getElementById('loginAlert');
    var submitting = false;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (submitting) return;
        submitting = true;

        alertBox.style.display = 'none';

        var params = new URLSearchParams(new FormData(form));

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onreadystatechange = function() {
            if (xhr.readyState !== 4) return;

            submitting = false;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Masuk';

            if (xhr.status === 200) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.success) {
                        alertBox.className = 'auth-alert auth-alert-success';
                        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> Login berhasil, mengalihkan...';
                        alertBox.style.display = '';
                        setTimeout(function() { window.location.href = res.redirect; }, 800);
                    } else {
                        alertBox.className = 'auth-alert auth-alert-error';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + res.message;
                        alertBox.style.display = '';
                        form.querySelector('[name="password"]').value = '';
                        form.querySelector('[name="password"]').focus();
                    }
                } catch(ex) {
                    alertBox.className = 'auth-alert auth-alert-error';
                    alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan, silakan coba lagi.';
                    alertBox.style.display = '';
                }
            } else {
                alertBox.className = 'auth-alert auth-alert-error';
                alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> Terjadi kesalahan, silakan coba lagi.';
                alertBox.style.display = '';
            }
        };

        xhr.onerror = function() {
            submitting = false;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Masuk';
            alertBox.className = 'auth-alert auth-alert-error';
            alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i> Koneksi gagal, periksa jaringan Anda.';
            alertBox.style.display = '';
        };

        xhr.send(params.toString());
    });
})();
</script>
