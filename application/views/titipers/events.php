<style>
    .page-header {
        margin-bottom: 32px;
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
    .page-header p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-top: 6px;
    }
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 20px;
    }
    .event-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .event-card:hover {
        border-color: var(--accent-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    .event-card-header {
        padding: 20px 20px 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .event-card-body {
        padding: 12px 20px 20px;
    }
    .event-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .event-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }
    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    .event-meta-item i {
        width: 16px;
        text-align: center;
        color: var(--accent-secondary);
        font-size: 0.75rem;
    }
    .event-stats {
        display: flex;
        gap: 16px;
        padding: 14px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 16px;
    }
    .event-stat {
        text-align: center;
        flex: 1;
    }
    .event-stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .event-stat-label {
        font-size: 0.68rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-top: 2px;
    }
    .event-card-footer {
        padding: 0 20px 20px;
        display: flex;
        gap: 10px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .badge-collecting { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .badge-upcoming, .badge-active { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .badge-completed { background: rgba(168, 85, 247, 0.15); color: var(--accent-secondary); }
    .badge-cancelled { background: rgba(239, 68, 68, 0.15); color: var(--danger); }
    .badge-verifying { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
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
    .btn-primary {
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        color: #fff;
        flex: 1;
        justify-content: center;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px var(--accent-glow);
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
    }
    .btn-disabled {
        opacity: 0.4;
        cursor: default;
        pointer-events: none;
    }
    .empty-state {
        text-align: center;
        padding: 64px 24px;
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
    .deadline-urgent {
        color: var(--danger) !important;
        font-weight: 600;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-calendar-alt"></i> Events</h1>
    <p>Daftar event lelang yang tersedia. Submit barang Anda ke event yang sedang mengumpulkan barang.</p>
</div>

<?php if (!empty($events)): ?>
    <div class="events-grid">
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <div class="event-card-header">
                    <span class="badge badge-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                </div>
                <div class="event-card-body">
                    <div class="event-name"><?= $event['name'] ?></div>
                    <?php if (!empty($event['description'])): ?>
                        <div class="event-desc"><?= $event['description'] ?></div>
                    <?php endif; ?>
                    <div class="event-meta">
                        <?php if (!empty($event['start_date'])): ?>
                            <div class="event-meta-item">
                                <i class="fas fa-calendar-plus"></i>
                                Mulai: <?= date('d M Y', strtotime($event['start_date'])) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($event['end_date'])): ?>
                            <?php
                            $is_urgent = ($event['status'] == 'collecting' && strtotime($event['end_date']) < strtotime('+3 days'));
                            ?>
                            <div class="event-meta-item <?= $is_urgent ? 'deadline-urgent' : '' ?>">
                                <i class="fas fa-calendar-minus"></i>
                                Deadline: <?= date('d M Y', strtotime($event['end_date'])) ?>
                                <?php if ($is_urgent && $event['status'] == 'collecting'): ?>
                                    <span style="font-size:0.7rem; color:var(--danger);">(Segera berakhir!)</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($event['auction_start'])): ?>
                            <div class="event-meta-item">
                                <i class="fas fa-gavel"></i>
                                Lelang: <?= date('d M Y H:i', strtotime($event['auction_start'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="event-stats">
                        <div class="event-stat">
                            <div class="event-stat-value"><?= isset($event['item_count']) ? $event['item_count'] : 0 ?></div>
                            <div class="event-stat-label">Items</div>
                        </div>
                        <div class="event-stat">
                            <div class="event-stat-value"><?= isset($event['bid_count']) ? $event['bid_count'] : 0 ?></div>
                            <div class="event-stat-label">Bids</div>
                        </div>
                    </div>
                </div>
                <div class="event-card-footer">
                    <?php if ($event['status'] == 'collecting'): ?>
                        <a href="<?= site_url('titipers/events_submit/' . $event['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Barang
                        </a>
                    <?php elseif ($event['status'] == 'active'): ?>
                        <span class="btn btn-primary btn-disabled">
                            <i class="fas fa-gavel"></i> Sedang Berlangsung
                        </span>
                    <?php elseif ($event['status'] == 'completed'): ?>
                        <span class="btn btn-outline btn-disabled" style="opacity:0.5;">
                            <i class="fas fa-check-circle"></i> Selesai
                        </span>
                    <?php else: ?>
                        <span class="btn btn-outline btn-disabled" style="opacity:0.5;">
                            <i class="fas fa-clock"></i> Menunggu
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-calendar-times"></i>
        <p>Belum ada event yang tersedia saat ini.</p>
    </div>
<?php endif; ?>
