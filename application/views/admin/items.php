<div class="page-header">
    <h1 class="page-title"><i class="fas fa-box"></i> Items Verification</h1>
</div>

<div class="filter-panel">
    <div class="filter-panel-row">
        <div class="filter-search">
            <i class="fas fa-search"></i>
            <input type="text" id="filterSearch" placeholder="Search item name..." oninput="filterTable()">
        </div>
        <div class="filter-select-wrap">
            <i class="fas fa-calendar-alt"></i>
            <select id="filterEvent" onchange="filterTable()">
                <option value="">All Events</option>
                <?php foreach ($events as $evt): ?>
                    <option value="<?= htmlspecialchars($evt['name']) ?>"><?= htmlspecialchars($evt['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-meta">
            <span id="resultCount" class="filter-count"></span>
            <button type="button" class="filter-reset" id="filterReset" onclick="resetFilters()" style="display:none">
                <i class="fas fa-times"></i> Reset
            </button>
        </div>
    </div>
    <div class="filter-tabs" id="statusTabs">
        <button class="filter-tab active" data-filter="all">All</button>
        <button class="filter-tab" data-filter="available">Available</button>
        <button class="filter-tab" data-filter="submitted">Submitted</button>
        <button class="filter-tab" data-filter="approved">Approved</button>
        <button class="filter-tab" data-filter="rejected">Rejected</button>
        <button class="filter-tab" data-filter="sold">Sold</button>
    </div>
</div>

<div class="table-card">
    <?php if (!empty($items)): ?>
        <div class="table-responsive">
            <table class="data-table" id="itemsTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Event</th>
                        <th>Titipers</th>
                        <th>Starting Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr data-event="<?= htmlspecialchars($item['event_name'] ?? '') ?>" data-status="<?= $item['status'] ?>" data-name="<?= htmlspecialchars($item['name']) ?>">
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= base_url('uploads/items/' . $item['image']) ?>" alt="" class="table-thumb">
                                <?php else: ?>
                                    <div class="table-thumb-placeholder"><i class="fas fa-image"></i></div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                            <td><?= htmlspecialchars($item['category'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($item['event_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($item['titipers_name'] ?? '-') ?></td>
                            <td>Rp <?= number_format($item['starting_price'], 0, ',', '.') ?></td>
                            <td><span class="badge badge-<?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></td>
                            <td>
                                <a href="<?= site_url('admin/items_detail/' . $item['id']) ?>" class="btn btn-sm btn-outline" title="View Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="table-empty" id="emptyState" style="display:none">
            <i class="fas fa-search"></i>
            <p>No items match your filters.</p>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>No items found.</p>
        </div>
    <?php endif; ?>
</div>

<script>
var activeStatus = 'all';
var tableExists = document.getElementById('itemsTable');

if (tableExists) {
    document.querySelectorAll('#statusTabs .filter-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('#statusTabs .filter-tab').forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            activeStatus = this.dataset.filter;
            filterTable();
        });
    });
    filterTable();
}

function filterTable() {
    var search = (document.getElementById('filterSearch').value || '').toLowerCase().trim();
    var eventFilter = (document.getElementById('filterEvent').value || '').toLowerCase();
    var rows = document.querySelectorAll('#itemsTable tbody tr');
    var visible = 0;

    rows.forEach(function(row) {
        var nameMatch = !search || row.dataset.name.toLowerCase().indexOf(search) !== -1;
        var eventMatch = !eventFilter || row.dataset.event.toLowerCase().indexOf(eventFilter) !== -1;
        var statusMatch = activeStatus === 'all' || row.dataset.status === activeStatus;
        var show = nameMatch && eventMatch && statusMatch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('resultCount').textContent = visible + ' item' + (visible !== 1 ? 's' : '');

    var totalRows = rows.length;
    var hasFilters = search || eventFilter || activeStatus !== 'all';
    document.getElementById('filterReset').style.display = hasFilters ? '' : 'none';

    var emptyState = document.getElementById('emptyState');
    var tableWrapper = document.querySelector('#itemsTable').closest('.table-responsive');
    if (emptyState) {
        if (visible === 0 && totalRows > 0) {
            emptyState.style.display = '';
            tableWrapper.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            tableWrapper.style.display = '';
        }
    }
}

function resetFilters() {
    document.getElementById('filterSearch').value = '';
    document.getElementById('filterEvent').value = '';
    activeStatus = 'all';
    document.querySelectorAll('#statusTabs .filter-tab').forEach(function(t) { t.classList.remove('active'); });
    document.querySelector('#statusTabs .filter-tab[data-filter="all"]').classList.add('active');
    filterTable();
}
</script>
