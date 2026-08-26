<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Admin - Omera Auction</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
</head>
<body class="dashboard-body">
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2 class="logo-text">OMERA</h2>
                <span class="logo-sub">ADMIN</span>
            </div>
            <nav class="sidebar-nav">
                <a href="<?= site_url('admin/dashboard') ?>" class="<?= ($this->router->fetch_class() == 'admin' && $this->router->fetch_method() == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?= site_url('admin/events') ?>" class="<?= strpos($this->router->fetch_method(), 'event') === 0 ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
                <a href="<?= site_url('admin/items') ?>" class="<?= $this->router->fetch_method() == 'items' ? 'active' : '' ?>">
                    <i class="fas fa-box"></i> Items
                </a>
                <a href="<?= site_url('admin/invoices') ?>" class="<?= $this->router->fetch_method() == 'invoices' ? 'active' : '' ?>">
                    <i class="fas fa-file-invoice"></i> Invoices
                </a>
                <a href="<?= site_url('admin/shipping') ?>" class="<?= $this->router->fetch_method() == 'shipping' ? 'active' : '' ?>">
                    <i class="fas fa-truck"></i> Shipping
                </a>
                <a href="<?= site_url('admin/disbursements') ?>" class="<?= $this->router->fetch_method() == 'disbursements' ? 'active' : '' ?>">
                    <i class="fas fa-money-bill-wave"></i> Disbursements
                </a>
                <a href="<?= site_url('admin/users') ?>" class="<?= $this->router->fetch_method() == 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="<?= site_url('admin/notifications') ?>" class="<?= $this->router->fetch_method() == 'notifications' ? 'active' : '' ?>">
                    <i class="fas fa-bell"></i> Notifications
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <div class="topbar">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="topbar-right">
                    <a href="<?= site_url('admin/notifications') ?>" class="notification-bell" id="notifBell">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge" id="notifCount"></span>
                    </a>
                    <div class="user-info">
                        <img src="<?= $this->session->userdata('avatar') ? base_url('uploads/avatars/' . $this->session->userdata('avatar')) : base_url('assets/images/default-avatar.png') ?>" alt="Avatar" class="user-avatar">
                        <span><?= $this->session->userdata('name') ?></span>
                    </div>
                </div>
            </div>
            <div class="content-wrapper">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
