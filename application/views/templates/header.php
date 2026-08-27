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
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .auth-page .auth-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .auth-card {
            width: 100%;
            max-width: 440px;
            background: rgba(20, 20, 30, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 40px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 0 40px rgba(124, 58, 237, 0.05);
            position: relative;
            overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        }
        .auth-card .auth-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: var(--text-primary);
        }
        .auth-card .auth-subtitle {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }
        .auth-card .form-group {
            margin-bottom: 18px;
        }
        .auth-card .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }
        .auth-card .form-group label i {
            margin-right: 4px;
            font-size: 0.78rem;
        }
        .auth-card .input-icon-wrapper {
            position: relative;
        }
        .auth-card .input-icon-wrapper .form-control {
            padding-left: 42px;
        }
        .auth-card .input-icon-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
            pointer-events: none;
        }
        .auth-card .input-icon-wrapper .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.9rem;
            transition: color var(--transition-fast);
        }
        .auth-card .input-icon-wrapper .toggle-pw:hover {
            color: var(--accent-primary-light);
        }
        .auth-card .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .auth-card .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent-primary);
            cursor: pointer;
        }
        .auth-card .form-check label {
            font-size: 0.82rem;
            color: var(--text-secondary);
            cursor: pointer;
            margin-bottom: 0;
        }
        .auth-card .btn-auth {
            width: 100%;
            padding: 13px;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-primary-dark));
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all var(--transition-smooth);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.35);
            margin-bottom: 16px;
        }
        .auth-card .btn-auth:hover {
            background: linear-gradient(135deg, var(--accent-primary-light), var(--accent-primary));
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.5);
            transform: translateY(-1px);
        }
        .auth-card .auth-link {
            text-align: center;
            font-size: 0.82rem;
            margin-bottom: 8px;
        }
        .auth-card .auth-link a {
            color: var(--accent-primary-light);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition-fast);
        }
        .auth-card .auth-link a:hover {
            color: var(--accent-primary);
            text-decoration: underline;
        }
        .auth-card .auth-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 20px 0;
        }
        .auth-card .auth-divider::before,
        .auth-card .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }
        .auth-card .auth-divider span {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .auth-card .auth-footer-text {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .auth-card .auth-footer-text a {
            color: var(--accent-primary-light);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-card .auth-footer-text a:hover {
            text-decoration: underline;
        }
        .auth-errors {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            color: #f87171;
        }
        .auth-errors ul {
            margin: 0;
            padding-left: 18px;
        }
        .auth-errors ul li {
            margin-bottom: 2px;
        }
        .auth-alert {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            margin-bottom: 18px;
            font-size: 0.84rem;
            line-height: 1.4;
            animation: alertSlideIn 0.25s ease;
        }
        .auth-alert i {
            margin-top: 2px;
            flex-shrink: 0;
        }
        .auth-alert-error {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
        }
        .auth-alert-success {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
        }
        @keyframes alertSlideIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-auth:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 6px;
            background: var(--bg-tertiary);
            overflow: hidden;
        }
        .password-strength .strength-bar {
            height: 100%;
            width: 0;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .password-strength .strength-text {
            font-size: 0.7rem;
            margin-top: 3px;
            color: var(--text-muted);
        }
        .role-selector {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
        }
        .role-option {
            flex: 1;
        }
        .role-option input[type="radio"] {
            display: none;
        }
        .role-option label.role-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 16px 12px;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-smooth);
            text-align: center;
            background: var(--bg-tertiary);
        }
        .role-option label.role-label:hover {
            border-color: rgba(124, 58, 237, 0.3);
            background: rgba(124, 58, 237, 0.05);
        }
        .role-option input[type="radio"]:checked + label.role-label {
            border-color: var(--accent-primary);
            background: rgba(124, 58, 237, 0.1);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
        }
        .role-option label.role-label .role-icon {
            font-size: 1.5rem;
            color: var(--text-muted);
            transition: color var(--transition-fast);
        }
        .role-option input[type="radio"]:checked + label.role-label .role-icon {
            color: var(--accent-primary-light);
        }
        .role-option label.role-label .role-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .role-option label.role-label .role-desc {
            font-size: 0.72rem;
            color: var(--text-muted);
        }
        .site-footer-simple {
            padding: 20px 24px;
            text-align: center;
            border-top: 1px solid var(--border-color);
            font-size: 0.78rem;
            color: var(--text-muted);
            background: var(--bg-secondary);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?= base_url('/') ?>" class="nav-logo">
            <i class="fas fa-gavel"></i>
            <span>OMERA AUCTION</span>
        </a>

        <div class="nav-menu" id="navMenu">
            <a href="<?= base_url('/') ?>" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="<?= base_url('about') ?>" class="nav-link">
                <i class="fas fa-info-circle"></i> About
            </a>
            <a href="<?= base_url('events/list') ?>" class="nav-link">
                <i class="fas fa-calendar-alt"></i> Event
            </a>
            <a href="<?= base_url('contact') ?>" class="nav-link">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>

        <div class="nav-actions">
            <?php if ($this->session->userdata('logged_in')): ?>
                <?php $role = $this->session->userdata('role'); ?>
                <a href="<?= base_url($role === 'admin' ? 'admin/dashboard' : $role . '/dashboard') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            <?php else: ?>
                <a href="<?= site_url('auth/login') ?>" class="btn btn-outline btn-sm">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </a>
                <a href="<?= site_url('auth/register') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Daftar
                </a>
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
            <a href="<?= base_url($role === 'admin' ? 'admin/dashboard' : $role . '/dashboard') ?>" class="mobile-link">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        <?php else: ?>
            <a href="<?= site_url('auth/login') ?>" class="mobile-link">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </a>
            <a href="<?= site_url('auth/register') ?>" class="mobile-link">
                <i class="fas fa-user-plus"></i> Daftar
            </a>
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

<div class="auth-page">
