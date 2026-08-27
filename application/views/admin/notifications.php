<div class="page-header">
    <h1 class="page-title">Notifications</h1>
    <a href="<?= site_url('admin/notifications_mark_all') ?>" class="btn btn-outline btn-sm"><i class="fas fa-check-double"></i> Mark all as read</a>
</div>

<div class="notifications-list">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notif): ?>
            <div class="notification-item <?= $notif['is_read'] ? '' : 'unread' ?>" data-id="<?= $notif['id'] ?>">
                <div class="notification-icon">
                    <?php if (strpos($notif['title'], 'Approved') !== false || strpos($notif['title'], 'Verified') !== false): ?>
                        <i class="fas fa-check-circle text-success"></i>
                    <?php elseif (strpos($notif['title'], 'Rejected') !== false): ?>
                        <i class="fas fa-times-circle text-danger"></i>
                    <?php elseif (strpos($notif['title'], 'Shipping') !== false): ?>
                        <i class="fas fa-truck text-info"></i>
                    <?php elseif (strpos($notif['title'], 'Payment') !== false): ?>
                        <i class="fas fa-credit-card text-warning"></i>
                    <?php elseif (strpos($notif['title'], 'Disbursement') !== false): ?>
                        <i class="fas fa-money-bill-wave text-success"></i>
                    <?php else: ?>
                        <i class="fas fa-bell text-primary"></i>
                    <?php endif; ?>
                </div>
                <div class="notification-content">
                    <h4 class="notification-title"><?= htmlspecialchars($notif['title']) ?></h4>
                    <p class="notification-message"><?= htmlspecialchars($notif['message']) ?></p>
                    <span class="notification-time"><?= date('d M Y H:i', strtotime($notif['created_at'])) ?></span>
                </div>
                <?php if (!$notif['is_read']): ?>
                    <form method="POST" action="<?= site_url('admin/notifications_read/' . $notif['id']) ?>" class="notification-read-form">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <button type="submit" class="btn btn-sm btn-outline" title="Mark as read"><i class="fas fa-check"></i></button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <p>No notifications.</p>
        </div>
    <?php endif; ?>
</div>
