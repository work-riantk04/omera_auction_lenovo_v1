<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Bidders - Omera Auction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body.dashboard-body {
            font-family: 'Inter', sans-serif;
            background: #0d1117;
            color: #e6edf3;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #161b22;
            border-right: 1px solid #21262d;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-bidders .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #21262d;
            background: linear-gradient(135deg, #161b22 0%, #1a1f2e 100%);
        }

        .sidebar-bidders .logo-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #00d4ff, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 3px;
        }

        .sidebar-bidders .logo-sub {
            display: block;
            font-size: 0.65rem;
            letter-spacing: 4px;
            color: #8b949e;
            margin-top: 2px;
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
            border-radius: 8px;
            color: #8b949e;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            background: #21262d;
            color: #e6edf3;
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(0,212,255,0.15), rgba(0,180,216,0.08));
            color: #00d4ff;
            border: 1px solid rgba(0,212,255,0.2);
        }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid #21262d;
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #f85149;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-footer a:hover {
            background: rgba(248,81,73,0.1);
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #161b22;
            border-bottom: 1px solid #21262d;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: #e6edf3;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .sidebar-toggle:hover {
            background: #21262d;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .notification-bell:hover {
            background: #21262d;
        }

        .notification-bell i {
            font-size: 1.1rem;
            color: #8b949e;
        }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #f85149;
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
            display: none;
        }

        .notif-badge.show {
            display: flex;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .user-dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-dropdown-toggle .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #21262d;
        }

        .user-dropdown-toggle .user-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #e6edf3;
        }

        .user-dropdown-toggle .fa-chevron-down {
            font-size: 0.7rem;
            color: #8b949e;
            transition: transform 0.2s;
        }

        .user-dropdown.open .fa-chevron-down {
            transform: rotate(180deg);
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            min-width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            z-index: 1000;
            overflow: hidden;
        }

        .user-dropdown.open .user-dropdown-menu {
            display: block;
        }

        .user-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #e6edf3;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background 0.15s;
        }

        .user-dropdown-menu a:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-dropdown-menu a i {
            width: 18px;
            text-align: center;
            font-size: 0.85rem;
        }

        .user-dropdown-menu .dropdown-divider {
            height: 1px;
            background: #30363d;
            margin: 4px 0;
        }

        .user-dropdown-menu .text-danger {
            color: #f85149;
        }

        .content-wrapper {
            flex: 1;
            padding: 32px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: rgba(63,185,80,0.12);
            border: 1px solid rgba(63,185,80,0.3);
            color: #3fb950;
        }

        .alert-danger {
            background: rgba(248,81,73,0.12);
            border: 1px solid rgba(248,81,73,0.3);
            color: #f85149;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
            }
            .content-wrapper {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body class="dashboard-body">
    <div class="admin-wrapper">
        <aside class="sidebar sidebar-bidders">
            <div class="sidebar-header">
                <h2 class="logo-text">OMERA</h2>
                <span class="logo-sub">BIDDERS</span>
            </div>
            <nav class="sidebar-nav">
                <a href="<?= site_url('bidders/dashboard') ?>" class="<?= ($this->router->fetch_method() == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?= site_url('bidders/events') ?>" class="<?= ($this->router->fetch_method() == 'events' || $this->router->fetch_method() == 'event_bid') ? 'active' : '' ?>">
                    <i class="fas fa-gavel"></i> Lelang
                </a>
                <a href="<?= site_url('bidders/invoices') ?>" class="<?= ($this->router->fetch_method() == 'invoices' || $this->router->fetch_method() == 'invoices_detail') ? 'active' : '' ?>">
                    <i class="fas fa-file-invoice"></i> Invoice
                </a>
                <a href="<?= site_url('bidders/notifications') ?>" class="<?= ($this->router->fetch_method() == 'notifications') ? 'active' : '' ?>">
                    <i class="fas fa-bell"></i> Notifikasi
                </a>
                <a href="<?= site_url('bidders/profile') ?>" class="<?= ($this->router->fetch_method() == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user-circle"></i> Profile
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
                    <div class="notification-bell" id="notifBell" onclick="location.href='<?= site_url('bidders/notifications') ?>'">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge" id="notifCount"></span>
                    </div>
                    <div class="user-dropdown" id="userDropdown">
                        <button class="user-dropdown-toggle">
                            <img src="<?= $this->session->userdata('avatar') ? base_url('uploads/avatars/'.$this->session->userdata('avatar')) : base_url('assets/images/default-avatar.svg') ?>" alt="Avatar" class="user-avatar" onerror="this.onerror=null;this.src='<?= base_url('assets/images/default-avatar.svg') ?>'">
                            <span class="user-name"><?= $this->session->userdata('name') ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown-menu">
                            <a href="<?= site_url('bidders/dashboard') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            <a href="<?= site_url('bidders/profile') ?>"><i class="fas fa-user-circle"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= site_url('auth/logout') ?>" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
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
