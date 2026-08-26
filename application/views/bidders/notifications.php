<div class="notifications-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1><i class="fas fa-bell"></i> Notifikasi</h1>
            <p style="color:#8b949e; margin-top:4px;">Pembaruan terbaru tentang aktivitas lelang Anda.</p>
        </div>
        <?php if (!empty($notifications)): ?>
            <button class="btn-mark-all" id="markAllBtn" onclick="markAllRead()">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        <?php endif; ?>
    </div>

    <div class="notif-list" id="notifList">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notif): ?>
                <?php
                    $is_read = $notif['is_read'];
                    $icon = 'fa-bell';
                    $icon_color = '#8b949e';
                    $title = $notif['title'];

                    $title_lower = strtolower($title);
                    if (strpos($title_lower, 'bid') !== false || strpos($title_lower, 'outbid') !== false) {
                        $icon = 'fa-gavel';
                        $icon_color = '#00d4ff';
                    } elseif (strpos($title_lower, 'invoice') !== false || strpos($title_lower, 'payment') !== false) {
                        $icon = 'fa-file-invoice';
                        $icon_color = '#ffd700';
                    } elseif (strpos($title_lower, 'verified') !== false || strpos($title_lower, 'confirm') !== false) {
                        $icon = 'fa-check-circle';
                        $icon_color = '#3fb950';
                    } elseif (strpos($title_lower, 'ship') !== false || strpos($title_lower, 'deliver') !== false) {
                        $icon = 'fa-truck';
                        $icon_color = '#bc8cff';
                    } elseif (strpos($title_lower, 'reject') !== false || strpos($title_lower, 'fail') !== false) {
                        $icon = 'fa-times-circle';
                        $icon_color = '#f85149';
                    }
                ?>
                <div class="notif-item <?= $is_read ? '' : 'notif-unread' ?>" id="notif-<?= $notif['id'] ?>" data-id="<?= $notif['id'] ?>">
                    <div class="notif-icon" style="background:<?= $icon_color ?>20; color:<?= $icon_color ?>;">
                        <i class="fas <?= $icon ?>"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-header">
                            <h4 class="notif-title"><?= htmlspecialchars($notif['title']) ?></h4>
                            <?php if (!$is_read): ?>
                                <span class="unread-dot"></span>
                            <?php endif; ?>
                        </div>
                        <p class="notif-message"><?= htmlspecialchars($notif['message']) ?></p>
                        <span class="notif-time"><i class="fas fa-clock"></i> <?= date('d M Y H:i', strtotime($notif['created_at'])) ?></span>
                    </div>
                    <?php if (!empty($notif['link'])): ?>
                        <a href="<?= site_url($notif['link']) ?>" class="notif-action" title="Lihat">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h3>Tidak Ada Notifikasi</h3>
                <p>Anda belum memiliki notifikasi baru.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.notifications-page { max-width: 800px; }

.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.page-header h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #e6edf3;
    display: flex;
    align-items: center;
    gap: 10px;
}
.page-header h1 i { color: #00d4ff; }

.btn-mark-all {
    padding: 8px 18px;
    border-radius: 8px;
    border: 1px solid #21262d;
    background: #161b22;
    color: #8b949e;
    font-size: 0.82rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-mark-all:hover { border-color: #3fb950; color: #3fb950; background: rgba(63,185,80,0.08); }

.notif-list {
    margin-top: 24px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.notif-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px 20px;
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 12px;
    transition: all 0.2s;
    cursor: default;
}

.notif-item:hover {
    border-color: #30363d;
    background: #1a1f2e;
}

.notif-unread {
    border-left: 3px solid #00d4ff;
    background: rgba(0,212,255,0.03);
}

.notif-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.notif-content { flex: 1; min-width: 0; }

.notif-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.notif-title {
    font-size: 0.92rem;
    font-weight: 600;
    color: #e6edf3;
}

.unread-dot {
    width: 8px;
    height: 8px;
    background: #00d4ff;
    border-radius: 50%;
    flex-shrink: 0;
}

.notif-message {
    font-size: 0.84rem;
    color: #8b949e;
    line-height: 1.5;
    margin-bottom: 6px;
}

.notif-time {
    font-size: 0.72rem;
    color: #484f58;
    display: flex;
    align-items: center;
    gap: 4px;
}

.notif-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b949e;
    text-decoration: none;
    font-size: 0.75rem;
    transition: all 0.2s;
    flex-shrink: 0;
    margin-top: 4px;
    border: 1px solid transparent;
}
.notif-action:hover { color: #00d4ff; border-color: rgba(0,212,255,0.2); background: rgba(0,212,255,0.08); }

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #8b949e;
}
.empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.3; display: block; }
.empty-state h3 { font-size: 1.2rem; color: #e6edf3; margin-bottom: 8px; }
</style>

<script>
function markAllRead() {
    var unread = document.querySelectorAll('.notif-unread');
    unread.forEach(function(el) {
        var id = el.getAttribute('data-id');
        fetch('<?= site_url("api/mark_notification_read/") ?>' + id, { credentials: 'same-origin' })
            .then(function(r) { return r.json(); })
            .then(function() {
                el.classList.remove('notif-unread');
                var dot = el.querySelector('.unread-dot');
                if (dot) dot.remove();
            });
    });
    var badge = document.getElementById('notifCount');
    if (badge) badge.classList.remove('show');
}

document.querySelectorAll('.notif-unread').forEach(function(el) {
    el.addEventListener('click', function() {
        if (this.classList.contains('notif-unread')) {
            var id = this.getAttribute('data-id');
            fetch('<?= site_url("api/mark_notification_read/") ?>' + id, { credentials: 'same-origin' })
                .then(function(r) { return r.json(); })
                .then(function() {
                    el.classList.remove('notif-unread');
                    var dot = el.querySelector('.unread-dot');
                    if (dot) dot.remove();
                });
        }
    });
});
</script>
