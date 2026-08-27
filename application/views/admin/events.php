<div class="page-header">
    <h1 class="page-title">Events</h1>
    <a href="<?= site_url('admin/events_create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Create Event</a>
</div>

<!-- Filter Tabs -->
<div class="filter-tabs">
    <button class="filter-tab active" data-filter="all">All</button>
    <button class="filter-tab" data-filter="upcoming">Upcoming</button>
    <button class="filter-tab" data-filter="collecting">Collecting</button>
    <button class="filter-tab" data-filter="active">Active</button>
    <button class="filter-tab" data-filter="completed">Completed</button>
</div>

<!-- Events Table -->
<div class="table-card">
    <?php if (!empty($events)): ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Status</th>
                        <th>Items</th>
                        <th>Bids</th>
                        <th>Collection Deadline</th>
                        <th>Auction Dates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $evt): ?>
                        <tr data-status="<?= $evt['status'] ?>">
                            <td>
                                <div class="event-name-cell">
                                    <?php if (!empty($evt['banner_image'])): ?>
                                        <img src="<?= base_url('uploads/events/' . $evt['banner_image']) ?>" alt="" class="table-thumb">
                                    <?php else: ?>
                                        <div class="table-thumb-placeholder"><i class="fas fa-calendar"></i></div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($evt['name']) ?></span>
                                </div>
                            </td>
                            <td><span class="badge badge-<?= $evt['status'] ?>"><?= ucfirst($evt['status']) ?></span></td>
                            <td><?= number_format($evt['item_count'] ?? 0) ?></td>
                            <td><?= number_format($evt['bid_count'] ?? 0) ?></td>
                            <td>
                                <?php if (!empty($evt['item_collection_deadline'])): ?>
                                    <?= date('d M Y H:i', strtotime($evt['item_collection_deadline'])) ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($evt['auction_start']) && !empty($evt['auction_end'])): ?>
                                    <?= date('d M', strtotime($evt['auction_start'])) ?> - <?= date('d M Y', strtotime($evt['auction_end'])) ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= site_url('admin/events_edit/' . $evt['id']) ?>" class="btn btn-sm btn-outline" title="Edit"><i class="fas fa-edit"></i></a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"><i class="fas fa-exchange-alt"></i></button>
                                        <div class="dropdown-menu">
                                            <?php
                                            $statuses = ['upcoming', 'collecting', 'verifying', 'active', 'completed', 'cancelled'];
                                            foreach ($statuses as $st):
                                                if ($st === $evt['status']) continue;
                                            ?>
                                                <form method="POST" action="<?= site_url('admin/events_status/' . $evt['id']) ?>">
                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                    <input type="hidden" name="status" value="<?= $st ?>">
                                                    <button type="submit" class="dropdown-item"><i class="fas fa-arrow-right"></i> <?= ucfirst($st) ?></button>
                                                </form>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <p>No events found.</p>
            <a href="<?= site_url('admin/events_create') ?>" class="btn btn-primary">Create Your First Event</a>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.filter-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.filter-tab').forEach(function(t) { t.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('.data-table tbody tr').forEach(function(row) {
            if (filter === 'all' || row.dataset.status === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
