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
    .event-info-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .event-info-icon {
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
    .event-info-details {
        flex: 1;
        min-width: 200px;
    }
    .event-info-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .event-info-meta {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 4px;
    }
    .event-info-meta span {
        margin-right: 16px;
    }
    .items-section {
        margin-bottom: 24px;
    }
    .items-section-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .items-section-title i { color: var(--accent-secondary); }
    .items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .item-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }
    .item-card:hover {
        border-color: var(--accent-primary);
        background: var(--bg-hover);
    }
    .item-card.selected {
        border-color: var(--accent-primary);
        background: rgba(124, 58, 237, 0.08);
        box-shadow: 0 0 0 2px var(--accent-glow);
    }
    .item-card input[type="checkbox"] {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 18px;
        height: 18px;
        accent-color: var(--accent-primary);
        cursor: pointer;
    }
    .item-thumb {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
        background: var(--bg-hover);
        flex-shrink: 0;
    }
    .item-thumb-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        background: var(--bg-hover);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        flex-shrink: 0;
    }
    .item-info {
        flex: 1;
        min-width: 0;
        padding-right: 24px;
    }
    .item-info-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .item-info-price {
        font-size: 0.8rem;
        color: var(--success);
        font-weight: 600;
        margin-top: 4px;
    }
    .item-info-status {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .select-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .select-actions .selected-count {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .select-actions .selected-count strong {
        color: var(--accent-secondary);
    }
    .select-btns {
        display: flex;
        gap: 8px;
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
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    .btn-outline:hover {
        border-color: var(--accent-primary);
        color: var(--accent-secondary);
    }
    .form-note {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 24px;
        font-size: 0.82rem;
        color: var(--warning);
        display: flex;
        align-items: center;
        gap: 10px;
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
        font-size: 2.5rem;
        margin-bottom: 12px;
        display: block;
        opacity: 0.4;
    }
    .empty-state p {
        font-size: 0.85rem;
        margin-bottom: 4px;
    }
    .form-error-list {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 24px;
        color: var(--danger);
        font-size: 0.85rem;
    }
</style>

<div class="page-header">
    <h1><i class="fas fa-paper-plane"></i> Submit ke Event</h1>
</div>

<?php if (validation_errors()): ?>
    <div class="form-error-list">
        <?= validation_errors() ?>
    </div>
<?php endif; ?>

<div class="event-info-card">
    <div class="event-info-icon"><i class="fas fa-calendar-alt"></i></div>
    <div class="event-info-details">
        <div class="event-info-name"><?= $event['name'] ?></div>
        <div class="event-info-meta">
            <span><i class="fas fa-info-circle"></i> Status: <?= ucfirst($event['status']) ?></span>
            <?php if (!empty($event['end_date'])): ?>
                <span><i class="fas fa-clock"></i> Deadline: <?= date('d M Y', strtotime($event['end_date'])) ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="form-note">
    <i class="fas fa-info-circle"></i>
    Hanya barang dengan status <strong style="margin:0 4px;">Available</strong> yang dapat disubmit ke event ini.
</div>

<?php if (!empty($available_items)): ?>
    <?= form_open('titipers/events_submit/' . $event['id'], ['id' => 'submitForm']) ?>
        <div class="select-actions">
            <span class="selected-count">Dipilih: <strong id="selectedCount">0</strong> barang</span>
            <div class="select-btns">
                <button type="button" class="btn btn-outline" onclick="selectAll()"><i class="fas fa-check-double"></i> Pilih Semua</button>
                <button type="button" class="btn btn-outline" onclick="deselectAll()"><i class="fas fa-times"></i> Batal Pilih</button>
            </div>
        </div>

        <div class="items-grid" id="itemsGrid">
            <?php foreach ($available_items as $item): ?>
                <label class="item-card" id="card-<?= $item['id'] ?>">
                    <input type="checkbox" name="items[]" value="<?= $item['id'] ?>" onchange="updateCount()">
                    <?php if (!empty($item['image'])): ?>
                        <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="item-thumb">
                    <?php else: ?>
                        <div class="item-thumb-placeholder"><i class="fas fa-image"></i></div>
                    <?php endif; ?>
                    <div class="item-info">
                        <div class="item-info-name"><?= $item['name'] ?></div>
                        <div class="item-info-price">Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></div>
                        <div class="item-info-status"><?= ucfirst($item['status']) ?></div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>

        <div style="margin-top:24px; display:flex; gap:12px;">
            <button type="submit" class="btn btn-primary" id="submitBtn"><i class="fas fa-paper-plane"></i> Submit Barang</button>
            <a href="<?= site_url('titipers/events') ?>" class="btn btn-outline">Kembali</a>
        </div>
    <?= form_close() ?>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p>Tidak ada barang available untuk disubmit.</p>
        <p style="margin-top:8px;"><a href="<?= site_url('titipers/items_add') ?>" style="color:var(--accent-secondary);">Tambah barang baru</a> terlebih dahulu.</p>
    </div>
<?php endif; ?>

<script>
function updateCount() {
    var checkboxes = document.querySelectorAll('input[name="items[]"]');
    var count = 0;
    checkboxes.forEach(function(cb) {
        var card = document.getElementById('card-' + cb.value);
        if (cb.checked) {
            count++;
            if (card) card.classList.add('selected');
        } else {
            if (card) card.classList.remove('selected');
        }
    });
    document.getElementById('selectedCount').textContent = count;
}

function selectAll() {
    document.querySelectorAll('input[name="items[]"]').forEach(function(cb) {
        cb.checked = true;
    });
    updateCount();
}

function deselectAll() {
    document.querySelectorAll('input[name="items[]"]').forEach(function(cb) {
        cb.checked = false;
    });
    updateCount();
}

document.getElementById('submitForm').addEventListener('submit', function(e) {
    var count = document.querySelectorAll('input[name="items[]"]:checked').length;
    if (count === 0) {
        e.preventDefault();
        alert('Pilih minimal satu barang untuk disubmit.');
    }
});
</script>
