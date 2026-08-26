<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Titipers - Omera Auction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: #1a1a25;
            --bg-hover: #22223a;
            --border-color: #2a2a3d;
            --text-primary: #e8e8f0;
            --text-secondary: #8888a0;
            --text-muted: #5a5a72;
            --accent-primary: #7c3aed;
            --accent-secondary: #a855f7;
            --accent-glow: rgba(124, 58, 237, 0.3);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body.dashboard-body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }

        .sidebar-header .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 3px;
        }

        .sidebar-header .logo-sub {
            display: block;
            font-size: 0.65rem;
            color: var(--text-muted);
            letter-spacing: 4px;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(168, 85, 247, 0.1));
            color: var(--accent-secondary);
            border: 1px solid rgba(124, 58, 237, 0.3);
        }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border-color);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--danger);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-footer a:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .sidebar-toggle {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 1.1rem;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: none;
        }

        .sidebar-toggle:hover {
            background: var(--bg-hover);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .notification-bell:hover { color: var(--text-primary); }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: var(--danger);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .notif-badge:empty,
        .notif-badge[data-count="0"] { display: none; }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .user-info span {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .content-wrapper {
            flex: 1;
            padding: 32px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--danger);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .content-wrapper { padding: 20px; }
            .topbar { padding: 12px 16px; }
        }
    </style>
</head>
<body class="dashboard-body">
    <div class="admin-wrapper">
        <aside class="sidebar sidebar-titipers" id="sidebar">
            <div class="sidebar-header">
                <h2 class="logo-text">OMERA</h2>
                <span class="logo-sub">TITIPERS</span>
            </div>
            <nav class="sidebar-nav">
                <a href="<?= site_url('titipers/dashboard') ?>" class="<?= ($this->router->fetch_method() == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?= site_url('titipers/items') ?>" class="<?= ($this->router->fetch_method() == 'items') ? 'active' : '' ?>">
                    <i class="fas fa-box"></i> Barang Saya
                </a>
                <a href="<?= site_url('titipers/events') ?>" class="<?= ($this->router->fetch_method() == 'events') ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
                <a href="<?= site_url('titipers/shipping') ?>" class="<?= ($this->router->fetch_method() == 'shipping') ? 'active' : '' ?>">
                    <i class="fas fa-truck"></i> Pengiriman
                </a>
                <a href="<?= site_url('titipers/notifications') ?>" class="<?= ($this->router->fetch_method() == 'notifications') ? 'active' : '' ?>">
                    <i class="fas fa-bell"></i> Notifikasi
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        <main class="main-content">
            <div class="topbar">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="topbar-right">
                    <a href="<?= site_url('titipers/notifications') ?>" class="notification-bell" id="notifBell">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge" id="notifCount"></span>
                    </a>
                    <div class="user-info">
                        <img src="<?= $this->session->userdata('avatar') ? base_url('uploads/avatars/'.$this->session->userdata('avatar')) : base_url('assets/images/default-avatar.png') ?>" alt="Avatar" class="user-avatar">
                        <span><?= $this->session->userdata('name') ?></span>
                    </div>
                </div>
            </div>
            <div class="content-wrapper">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
