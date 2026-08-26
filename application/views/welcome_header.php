<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Omera Auction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/three-d.css') ?>">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?= base_url('/') ?>" class="nav-logo">
            <i class="fas fa-gavel"></i>
            <span>OMERA AUCTION</span>
        </a>

        <div class="nav-menu" id="navMenu">
            <a href="<?= base_url('/') ?>" class="nav-link <?= ($this->uri->segment(1) == '' || $this->uri->segment(1) == NULL) ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="<?= base_url('about') ?>" class="nav-link <?= $this->uri->segment(1) == 'about' ? 'active' : '' ?>">
                <i class="fas fa-info-circle"></i> About
            </a>
            <a href="<?= base_url('events/list') ?>" class="nav-link <?= $this->uri->segment(1) == 'events' ? 'active' : '' ?>">
                <i class="fas fa-calendar-alt"></i> Event
            </a>
            <a href="<?= base_url('contact') ?>" class="nav-link <?= $this->uri->segment(1) == 'contact' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>

        <div class="nav-actions">
            <?php if ($this->session->userdata('logged_in')): ?>
                <div class="user-dropdown">
                    <button class="user-btn" id="userDropdownBtn">
                        <div class="user-avatar">
                            <?php if ($this->session->userdata('avatar')): ?>
                                <img src="<?= base_url('uploads/avatars/' . $this->session->userdata('avatar')) ?>" alt="Avatar">
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <span class="user-name"><?= $this->session->userdata('name') ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="dropdown-header">
                            <span class="dropdown-role"><?= ucfirst($this->session->userdata('role')) ?></span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <?php $role = $this->session->userdata('role'); ?>
                        <?php if ($role === 'admin'): ?>
                            <a href="<?= base_url('admin/dashboard') ?>" class="dropdown-item">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        <?php elseif ($role === 'titipers'): ?>
                            <a href="<?= base_url('titipers/dashboard') ?>" class="dropdown-item">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        <?php elseif ($role === 'bidders'): ?>
                            <a href="<?= base_url('bidders/dashboard') ?>" class="dropdown-item">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('auth/logout') ?>" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <button class="btn btn-outline btn-sm" onclick="openModal('loginModal')">Masuk</button>
                <button class="btn btn-primary btn-sm" onclick="openModal('registerModal')">Daftar</button>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <a href="<?= base_url('/') ?>" class="nav-logo">
            <i class="fas fa-gavel"></i>
            <span>OMERA AUCTION</span>
        </a>
        <button class="mobile-close" id="mobileCloseBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="mobile-menu-body">
        <a href="<?= base_url('/') ?>" class="mobile-link">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="<?= base_url('about') ?>" class="mobile-link">
            <i class="fas fa-info-circle"></i> About
        </a>
        <a href="<?= base_url('events/list') ?>" class="mobile-link">
            <i class="fas fa-calendar-alt"></i> Event
        </a>
        <a href="<?= base_url('contact') ?>" class="mobile-link">
            <i class="fas fa-envelope"></i> Contact Us
        </a>
        <div class="mobile-divider"></div>
        <?php if ($this->session->userdata('logged_in')): ?>
            <?php $role = $this->session->userdata('role'); ?>
            <?php if ($role === 'admin'): ?>
                <a href="<?= base_url('admin/dashboard') ?>" class="mobile-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            <?php elseif ($role === 'titipers'): ?>
                <a href="<?= base_url('titipers/dashboard') ?>" class="mobile-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            <?php elseif ($role === 'bidders'): ?>
                <a href="<?= base_url('bidders/dashboard') ?>" class="mobile-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            <?php endif; ?>
            <a href="<?= base_url('auth/logout') ?>" class="mobile-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        <?php else: ?>
            <button class="btn btn-outline btn-block" onclick="openModal('loginModal'); closeMobileMenu();">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
            <button class="btn btn-primary btn-block" onclick="openModal('registerModal'); closeMobileMenu();" style="margin-top: 8px;">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="flash-message flash-success" id="flashSuccess">
    <div class="flash-content">
        <i class="fas fa-check-circle"></i>
        <span><?= $this->session->flashdata('success') ?></span>
    </div>
    <button class="flash-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<div class="flash-message flash-error" id="flashError">
    <div class="flash-content">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
    <button class="flash-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
<?php endif; ?>

<div class="modal-overlay" id="loginModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-sign-in-alt"></i> Masuk</h3>
            <button class="modal-close" onclick="closeModal('loginModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <?= form_open('auth/login') ?>
                <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                <div class="form-group">
                    <label for="loginEmail"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="loginEmail" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-input">
                        <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('loginPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group text-right">
                    <a href="javascript:void(0)" onclick="closeModal('loginModal'); openModal('resetModal');" class="text-link">
                        Lupa Password?
                    </a>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            <?= form_close() ?>
            <div class="modal-footer-link">
                <p>Belum punya akun? <a href="javascript:void(0)" onclick="closeModal('loginModal'); openModal('registerModal');">Daftar</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="registerModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-user-plus"></i> Daftar</h3>
            <button class="modal-close" onclick="closeModal('registerModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <?= form_open('auth/register') ?>
                <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                <div class="form-group">
                    <label for="registerName"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" id="registerName" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="registerEmail" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                <div class="form-group">
                    <label for="registerPhone"><i class="fas fa-phone"></i> No. Telepon</label>
                    <input type="tel" id="registerPhone" name="phone" class="form-control" placeholder="Masukkan no. telepon" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-input">
                        <input type="password" id="registerPassword" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePassword('registerPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="registerConfirmPassword"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                    <div class="password-input">
                        <input type="password" id="registerConfirmPassword" name="confirm_password" class="form-control" placeholder="Ulangi password" required minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePassword('registerConfirmPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="registerRole"><i class="fas fa-users-cog"></i> Daftar Sebagai</label>
                    <select id="registerRole" name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="titipers">Titipers (Penjual)</option>
                        <option value="bidders">Bidders (Pembeli)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            <?= form_close() ?>
            <div class="modal-footer-link">
                <p>Sudah punya akun? <a href="javascript:void(0)" onclick="closeModal('registerModal'); openModal('loginModal');">Masuk</a></p>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="resetModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fas fa-key"></i> Reset Password</h3>
            <button class="modal-close" onclick="closeModal('resetModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <?= form_open('auth/reset_password') ?>
                <input type="hidden" name="<?= $csrf_token_name ?>" value="<?= $csrf_hash ?>">
                <p class="text-muted mb-3">Masukkan email Anda untuk menerima link reset password.</p>
                <div class="form-group">
                    <label for="resetEmail"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="resetEmail" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i> Kirim Link Reset
                </button>
            <?= form_close() ?>
            <div class="modal-footer-link">
                <p><a href="javascript:void(0)" onclick="closeModal('resetModal'); openModal('loginModal');">
                    <i class="fas fa-arrow-left"></i> Kembali ke login
                </a></p>
            </div>
        </div>
    </div>
</div>
