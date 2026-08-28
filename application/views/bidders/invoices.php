<div class="invoices-page">
    <div class="page-header">
        <h1><i class="fas fa-file-invoice"></i> Invoice</h1>
        <p style="color:#8b949e; margin-top:4px;">Kelola pembayaran untuk lelang yang Anda menangkan.</p>
    </div>

    <?php if (!empty($invoices)): ?>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Event</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                        <?php
                            $status = $inv['payment_status'];
                            $status_class = 'status-unpaid';
                            $status_text = 'Belum Bayar';
                            if ($status === 'paid') { $status_class = 'status-paid'; $status_text = 'Menunggu Verifikasi'; }
                            elseif ($status === 'verified') { $status_class = 'status-verified'; $status_text = 'Terkonfirmasi'; }
                            elseif ($status === 'rejected') { $status_class = 'status-rejected'; $status_text = 'Ditolak'; }
                        ?>
                        <tr>
                            <td><span class="invoice-id">#<?= str_pad($inv['id'], 5, '0', STR_PAD_LEFT) ?></span></td>
                            <td><?= htmlspecialchars($inv['event_name'] ?? '-') ?></td>
                            <td>
                                <div class="item-cell">
                                    <?php if (!empty($inv['item_image'])): ?>
                                        <img src="<?= base_url('uploads/items/' . $inv['item_image']) ?>" alt="" class="item-thumb" onerror="this.onerror=null;this.src='<?= base_url('assets/images/placeholder-item.php') ?>'">
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($inv['item_name'] ?? '-') ?></span>
                                </div>
                            </td>
                            <td><span class="amount-text">Rp <?= number_format($inv['win_amount'], 0, ',', '.') ?></span></td>
                            <td><span class="status-badge <?= $status_class ?>"><?= $status_text ?></span></td>
                            <td><span class="date-text"><?= date('d M Y', strtotime($inv['created_at'])) ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= site_url('bidders/invoices_detail/' . $inv['id']) ?>" class="btn-action btn-detail" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($status === 'unpaid'): ?>
                                        <a href="<?= site_url('bidders/invoices_detail/' . $inv['id']) ?>" class="btn-action btn-pay" title="Bayar">
                                            <i class="fas fa-credit-card"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-file-invoice"></i>
            <h3>Belum Ada Invoice</h3>
            <p>Anda belum memiliki invoice. Menangkan lelang untuk mendapatkan invoice.</p>
            <a href="<?= site_url('bidders/events') ?>" class="empty-cta"><i class="fas fa-gavel"></i> Ikuti Lelang</a>
        </div>
    <?php endif; ?>
</div>

<style>
.invoices-page { max-width: 1200px; }
.page-header h1 { font-size: 1.6rem; font-weight: 700; color: #e6edf3; display: flex; align-items: center; gap: 10px; }
.page-header h1 i { color: #00d4ff; }

.table-wrapper {
    background: #161b22;
    border: 1px solid #21262d;
    border-radius: 14px;
    overflow: hidden;
    margin-top: 24px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #0d1117;
}

.data-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #8b949e;
    border-bottom: 1px solid #21262d;
}

.data-table td {
    padding: 16px 20px;
    font-size: 0.88rem;
    color: #e6edf3;
    border-bottom: 1px solid #21262d;
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.15s;
}

.data-table tbody tr:hover {
    background: rgba(0,212,255,0.03);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.invoice-id {
    font-family: 'Orbitron', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: #00d4ff;
}

.item-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.item-thumb {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #21262d;
}

.amount-text {
    font-family: 'Orbitron', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #e6edf3;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-unpaid { background: rgba(248,81,73,0.12); color: #f85149; border: 1px solid rgba(248,81,73,0.2); }
.status-paid { background: rgba(210,153,34,0.12); color: #d29922; border: 1px solid rgba(210,153,34,0.2); }
.status-verified { background: rgba(63,185,80,0.12); color: #3fb950; border: 1px solid rgba(63,185,80,0.2); }
.status-rejected { background: rgba(248,81,73,0.12); color: #f85149; border: 1px solid rgba(248,81,73,0.2); }

.date-text { font-size: 0.82rem; color: #8b949e; }

.action-btns {
    display: flex;
    gap: 6px;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    text-decoration: none;
    transition: all 0.2s;
    border: 1px solid #21262d;
    background: #0d1117;
    color: #8b949e;
}

.btn-action:hover { border-color: #30363d; color: #e6edf3; }
.btn-detail:hover { border-color: #00d4ff; color: #00d4ff; background: rgba(0,212,255,0.08); }
.btn-pay:hover { border-color: #ffd700; color: #ffd700; background: rgba(255,215,0,0.08); }

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #8b949e;
}
.empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.3; display: block; }
.empty-state h3 { font-size: 1.2rem; color: #e6edf3; margin-bottom: 8px; }
.empty-state p { font-size: 0.9rem; margin-bottom: 24px; }

.empty-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #00d4ff, #00b4d8);
    color: #0d1117;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s;
}
.empty-cta:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,212,255,0.3); }

@media (max-width: 768px) {
    .table-wrapper { overflow-x: auto; }
    .data-table { min-width: 700px; }
}
</style>
