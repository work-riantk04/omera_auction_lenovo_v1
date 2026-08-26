<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-header h1 {
        font-family: 'Orbitron', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .page-header h1 i { color: var(--accent-secondary); }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
        background: rgba(124, 58, 237, 0.05);
    }
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .notif-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 18px 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        transition: all 0.2s ease;
    }
    .notif-card:hover {
        background: var(--bg-hover);
    }
    .notif-card.unread {
        border-left: 3px solid var(--accent-primary);
        background: rgba(124, 58, 237, 0.04);
    }
    .notif-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.9rem;
    }
    .notif-icon.approved {
        background: rgba(16, 185, 129, 0.15);
        color: var(--success);
    }
    .notif-icon.rejected {
        background: rgba(239, 68, 68, 0.15);
        color: var(--danger);
    }
    .notif-icon.shipping {
        background: rgba(59, 130, 246, 0.15);
        color: var(--info);
    }
    .notif-icon.disbursement {
        background: rgba(168, 85, 247, 0.15);
        color: var(--accent-secondary);
    }
    .notif-icon.default {
        background: rgba(136, 136, 160, 0.15);
        color: var(--text-secondary);
    }
    .notif-body {
        flex: 1;
        min-width: 0;
    }
    .notif-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    .notif-card.unread .notif-title {
        color: var(--accent-secondary);
    }
    .notif-message {
        font-size: 0.82rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }
    .notif-time {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 6px;
    }
    .notif-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        flex-shrink: 0;
    }
    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--accent-primary);
        flex-shrink: 0;
    }
    .notif-card:not(.unread) .notif-dot {
        background: transparent;
    }
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
        opacity: 0.4;
    }
    .empty-state p {
        font-size: 0.9rem;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-bell"></i> Notifikasi</h1>
    <?php if (!empty($notifications)): ?>
        <a href="<?= site_url('titipers/notifications/mark_all') ?>" class="btn btn-outline" onclick="return confirm('Tandai semua notifikasi sebagai sudah dibaca?')">
            <i class="fas fa-check-double"></i> Tandai Semua Dibaca
        </a>
    <?php endif; ?>
</div>

<?php if (!empty($notifications)): ?>
    <div class="notifications-list">
        <?php foreach ($notifications as $notif): ?>
            <?php
            $notif_class = '';
            if (isset($notif['is_read']) && !$notif['is_read']) {
                $notif_class = 'unread';
            }
            $icon_class = 'default';
            $icon = 'fa-bell';
            $title_lower = strtolower($notif['title']);
            if (strpos($title_lower, 'approved') !== FALSE || strpos($title_lower, 'disbursement') !== FALSE) {
                $icon_class = strpos($title_lower, 'disbursement') !== FALSE ? 'disbursement' : 'approved';
                $icon = strpos($title_lower, 'disbursement') !== FALSE ? 'fa-money-bill-wave' : 'fa-check-circle';
            } elseif (strpos($title_lower, 'rejected') !== FALSE) {
                $icon_class = 'rejected';
                $icon = 'fa-times-circle';
            } elseif (strpos($title_lower, 'ship') !== FALSE) {
                $icon_class = 'shipping';
                $icon = 'fa-shipping-fast';
            }
            ?>
            <div class="notif-card <?= $notif_class ?>">
                <div class="notif-icon <?= $icon_class ?>"><i class="fas <?= $icon ?>"></i></div>
                <div class="notif-body">
                    <div class="notif-title"><?= $notif['title'] ?></div>
                    <div class="notif-message"><?= $notif['message'] ?></div>
                    <?php if (!empty($notif['created_at'])): ?>
                        <div class="notif-time"><i class="fas fa-clock" style="margin-right:4px;"></i> <?= date('d M Y H:i', strtotime($notif['created_at'])) ?></div>
                    <?php endif; ?>
                </div>
                <div class="notif-actions">
                    <div class="notif-dot"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-bell-slash"></i>
        <p>Belum ada notifikasi.</p>
    </div>
<?php endif; ?>
