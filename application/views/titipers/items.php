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
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
        color: #fff;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px var(--accent-glow);
    }
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.75rem;
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
        background: rgba(124, 58, 237, 0.1);
    }
    .btn-success {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: var(--success);
    }
    .btn-success:hover {
        background: rgba(16, 185, 129, 0.25);
    }
    .btn-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--danger);
    }
    .btn-danger:hover {
        background: rgba(239, 68, 68, 0.2);
    }
    .btn-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: var(--info);
    }
    .btn-info:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    .items-table-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table thead {
        background: var(--bg-secondary);
    }
    .items-table th {
        padding: 14px 16px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }
    .items-table td {
        padding: 14px 16px;
        font-size: 0.85rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    .items-table tbody tr {
        transition: background 0.2s ease;
    }
    .items-table tbody tr:hover {
        background: var(--bg-hover);
    }
    .items-table tbody tr:last-child td {
        border-bottom: none;
    }
    .item-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .item-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-hover);
        flex-shrink: 0;
    }
    .item-cell-name {
        font-weight: 600;
        color: var(--text-primary);
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
    }
    .badge-available { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .badge-submitted { background: rgba(59, 130, 246, 0.15); color: var(--info); }
    .badge-approved { background: rgba(168, 85, 247, 0.15); color: var(--accent-secondary); }
    .badge-rejected { background: rgba(239, 68, 68, 0.15); color: var(--danger); }
    .badge-sold { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .badge-pending { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .actions-cell {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .price-text {
        font-weight: 600;
        color: var(--success);
    }
    .date-text {
        color: var(--text-muted);
        font-size: 0.8rem;
    }
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
        opacity: 0.4;
    }
    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    @media (max-width: 768px) {
        .items-table th:nth-child(4),
        .items-table td:nth-child(4),
        .items-table th:nth-child(5),
        .items-table td:nth-child(5) {
            display: none;
        }
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-box" style="color:var(--accent-secondary);margin-right:12px;"></i>Barang Saya</h1>
    <a href="<?= site_url('titipers/items_add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
</div>

<?php if (!empty($items)): ?>
    <div class="items-table-wrapper">
        <div class="table-responsive">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Event</th>
                        <th>Harga</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <div class="item-cell">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="item-thumb" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
                                    <?php else: ?>
                                        <div class="item-thumb" style="display:flex;align-items:center;justify-content:center;color:var(--text-muted);"><i class="fas fa-image"></i></div>
                                    <?php endif; ?>
                                    <span class="item-cell-name"><?= $item['name'] ?></span>
                                    <?php if ($item['status'] == 'rejected' && !empty($item['admin_note'])): ?>
                                        <div style="font-size:0.72rem;color:var(--danger);max-width:220px;"><i class="fas fa-comment-dots"></i> <?= htmlspecialchars($item['admin_note']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><span class="badge badge-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></td>
                            <td><?= !empty($item['event_name']) ? $item['event_name'] : '<span style="color:var(--text-muted);">-</span>' ?></td>
                            <td class="price-text">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></td>
                            <td class="date-text"><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                            <td>
                                <div class="actions-cell">
                                    <?php if ($item['status'] == 'available'): ?>
                                        <a href="<?= site_url('titipers/items_edit/' . $item['id']) ?>" class="btn btn-sm btn-outline" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="<?= site_url('titipers/items_delete/' . $item['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus barang ini?')"><i class="fas fa-trash"></i></a>
                                    <?php elseif ($item['status'] == 'rejected'): ?>
                                        <a href="<?= site_url('titipers/items_edit/' . $item['id']) ?>" class="btn btn-sm btn-info" title="Edit & Perbaiki"><i class="fas fa-edit"></i> Perbaiki</a>
                                    <?php elseif ($item['status'] == 'submitted'): ?>
                                        <span class="btn btn-sm btn-outline" style="opacity:0.5;cursor:default;"><i class="fas fa-clock"></i> Menunggu</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="empty-state" style="background:var(--bg-card);border:1px solid var(--border-color);border-radius:12px;">
        <i class="fas fa-box-open"></i>
        <p>Anda belum memiliki barang apapun.</p>
        <a href="<?= site_url('titipers/items_add') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang Pertama</a>
    </div>
<?php endif; ?>
