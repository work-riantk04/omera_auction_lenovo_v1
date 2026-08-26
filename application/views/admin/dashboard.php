<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Welcome back, <?= $this->session->userdata('name') ?>!</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-events">
        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-info">
            <span class="stat-number"><?= number_format($total_events ?? 0) ?></span>
            <span class="stat-label">Total Events</span>
        </div>
    </div>
    <div class="stat-card stat-items">
        <div class="stat-icon"><i class="fas fa-box"></i></div>
        <div class="stat-info">
            <span class="stat-number"><?= number_format($total_items ?? 0) ?></span>
            <span class="stat-label">Total Items</span>
        </div>
    </div>
    <div class="stat-card stat-users">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <span class="stat-number"><?= number_format($total_users ?? 0) ?></span>
            <span class="stat-label">Total Users</span>
        </div>
    </div>
    <div class="stat-card stat-revenue">
        <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-info">
            <span class="stat-number">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></span>
            <span class="stat-label">Total Revenue</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h3 class="section-title"><i class="fas fa-bolt"></i> Quick Actions</h3>
    <div class="actions-grid">
        <a href="<?= site_url('admin/events_create') ?>" class="action-card">
            <i class="fas fa-plus-circle"></i>
            <span>Create Event</span>
        </a>
        <a href="<?= site_url('admin/items') ?>" class="action-card">
            <i class="fas fa-check-double"></i>
            <span>Verify Items</span>
        </a>
        <a href="<?= site_url('admin/invoices') ?>" class="action-card">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Invoices</span>
            <?php if (!empty($pending_invoices) && $pending_invoices > 0): ?>
                <span class="action-badge"><?= $pending_invoices ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= site_url('admin/shipping') ?>" class="action-card">
            <i class="fas fa-truck"></i>
            <span>Manage Shipping</span>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="activity-section">
    <div class="activity-panel">
        <h3 class="section-title"><i class="fas fa-calendar"></i> Recent Events</h3>
        <?php if (!empty($recent_events)): ?>
            <div class="activity-list">
                <?php foreach ($recent_events as $evt): ?>
                    <div class="activity-item">
                        <div class="activity-dot dot-<?= $evt['status'] ?>"></div>
                        <div class="activity-content">
                            <span class="activity-name"><?= htmlspecialchars($evt['name']) ?></span>
                            <span class="activity-meta"><?= date('d M Y', strtotime($evt['created_at'])) ?></span>
                        </div>
                        <span class="badge badge-<?= $evt['status'] ?>"><?= ucfirst($evt['status']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-state">No events yet.</p>
        <?php endif; ?>
    </div>

    <div class="activity-panel">
        <h3 class="section-title"><i class="fas fa-chart-line"></i> Overview</h3>
        <div class="overview-list">
            <div class="overview-item">
                <i class="fas fa-clock text-warning"></i>
                <span>Pending Invoices</span>
                <strong><?= number_format($pending_invoices ?? 0) ?></strong>
            </div>
            <div class="overview-item">
                <i class="fas fa-spinner text-info"></i>
                <span>Awaiting Items</span>
                <strong><?= number_format($total_items ?? 0) ?></strong>
            </div>
            <div class="overview-item">
                <i class="fas fa-check-circle text-success"></i>
                <span>Active Events</span>
                <strong><?= number_format($total_events ?? 0) ?></strong>
            </div>
        </div>
    </div>
</div>
