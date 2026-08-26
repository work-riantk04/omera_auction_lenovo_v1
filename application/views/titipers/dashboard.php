<style>
    .page-header {
        margin-bottom: 32px;
    }
    .page-header h1 {
        font-family: 'Orbitron', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }
    .page-header p {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
    }
    .stat-card.purple::before { background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary)); }
    .stat-card.green::before { background: var(--success); }
    .stat-card.orange::before { background: var(--warning); }
    .stat-card.red::before { background: var(--danger); }
    .stat-card:hover {
        border-color: var(--accent-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 16px;
    }
    .stat-card.purple .stat-icon { background: rgba(124, 58, 237, 0.15); color: var(--accent-secondary); }
    .stat-card.green .stat-icon { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .stat-card.orange .stat-icon { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .stat-card.red .stat-icon { background: rgba(239, 68, 68, 0.15); color: var(--danger); }
    .stat-card .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    .stat-card .stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .section-title {
        font-family: 'Orbitron', sans-serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title i {
        color: var(--accent-secondary);
    }
    .recent-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 40px;
    }
    .panel {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
    }
    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .panel-header h3 {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    .panel-header a {
        font-size: 0.8rem;
        color: var(--accent-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .panel-header a:hover {
        color: var(--accent-primary);
    }
    .item-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .item-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        border-radius: 8px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    .item-row:hover {
        border-color: var(--accent-primary);
    }
    .item-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-hover);
        flex-shrink: 0;
    }
    .item-details {
        flex: 1;
        min-width: 0;
    }
    .item-details .item-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .item-details .item-meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        flex-shrink: 0;
    }
    .badge-available { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .badge-submitted { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .badge-approved { background: rgba(168, 85, 247, 0.15); color: var(--accent-secondary); }
    .badge-rejected { background: rgba(239, 68, 68, 0.15); color: var(--danger); }
    .badge-sold { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .badge-pending { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .badge-collecting { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .badge-active { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .badge-completed { background: rgba(168, 85, 247, 0.15); color: var(--accent-secondary); }
    .empty-state {
        text-align: center;
        padding: 32px 16px;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 12px;
        display: block;
        opacity: 0.5;
    }
    .empty-state p {
        font-size: 0.85rem;
    }
    .earnings-card {
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.15), rgba(168, 85, 247, 0.08));
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .earnings-card .earn-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        flex-shrink: 0;
    }
    .earnings-card .earn-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .earnings-card .earn-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 2px;
    }
    @media (max-width: 768px) {
        .recent-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, <?= $this->session->userdata('name') ?>. Berikut ringkasan aktivitas Anda.</p>
</div>

<div class="earnings-card">
    <div class="earn-icon"><i class="fas fa-coins"></i></div>
    <div>
        <div class="earn-label">Total Pendapatan</div>
        <div class="earn-value">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fas fa-box"></i></div>
        <div class="stat-value"><?= $total_items ?></div>
        <div class="stat-label">Total Barang</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-value"><?= $active_items ?></div>
        <div class="stat-label">Barang Aktif</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-gavel"></i></div>
        <div class="stat-value"><?= $total_sold ?></div>
        <div class="stat-label">Terjual</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-truck"></i></div>
        <div class="stat-value"><?= $total_items - $active_items - $total_sold ?></div>
        <div class="stat-label">Menunggu Pengiriman</div>
    </div>
</div>

<div class="recent-grid">
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-box" style="color:var(--accent-secondary);margin-right:8px;"></i> Barang Terbaru</h3>
            <a href="<?= site_url('titipers/items') ?>">Lihat Semua</a>
        </div>
        <?php if (!empty($recent_items)): ?>
            <div class="item-list">
                <?php foreach ($recent_items as $item): ?>
                    <div class="item-row">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="item-thumb">
                        <?php else: ?>
                            <div class="item-thumb" style="display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:1.2rem;"><i class="fas fa-image"></i></div>
                        <?php endif; ?>
                        <div class="item-details">
                            <div class="item-name"><?= $item['name'] ?></div>
                            <div class="item-meta"><?= $item['event_name'] ? $item['event_name'] : 'Belum di event' ?></div>
                        </div>
                        <span class="badge badge-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Belum ada barang. <a href="<?= site_url('titipers/items_add') ?>" style="color:var(--accent-secondary);">Tambah barang baru</a></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-calendar-alt" style="color:var(--accent-secondary);margin-right:8px;"></i> Event Terkini</h3>
            <a href="<?= site_url('titipers/events') ?>">Lihat Semua</a>
        </div>
        <?php if (!empty($recent_items)): ?>
            <div class="item-list">
                <?php
                $event_seen = [];
                $event_count = 0;
                foreach ($recent_items as $item):
                    if (!empty($item['event_id']) && !in_array($item['event_id'], $event_seen)):
                        $event_seen[] = $item['event_id'];
                        $event_count++;
                ?>
                    <div class="item-row">
                        <div class="item-thumb" style="display:flex;align-items:center;justify-content:center;background:rgba(124,58,237,0.15);color:var(--accent-secondary);font-size:1rem;"><i class="fas fa-calendar-alt"></i></div>
                        <div class="item-details">
                            <div class="item-name"><?= $item['event_name'] ?></div>
                            <div class="item-meta">Item: <?= $item['name'] ?></div>
                        </div>
                        <span class="badge badge-submitted">Participating</span>
                    </div>
                <?php
                    endif;
                    if ($event_count >= 5) break;
                endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (empty($event_seen)): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>Belum mengikuti event apapun. <a href="<?= site_url('titipers/events') ?>" style="color:var(--accent-secondary);">Lihat events</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>
