<div class="page-header">
    <h1 class="page-title">Users</h1>
</div>

<!-- Filter Tabs -->
<div class="filter-tabs">
    <button class="filter-tab active" data-filter="all">All</button>
    <button class="filter-tab" data-filter="admin">Admin</button>
    <button class="filter-tab" data-filter="titipers">Titipers</button>
    <button class="filter-tab" data-filter="bidders">Bidders</button>
</div>

<div class="table-card">
    <?php if (!empty($users)): ?>
        <div class="table-responsive">
            <table class="data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $usr): ?>
                        <tr data-role="<?= $usr['role'] ?>">
                            <td>
                                <div class="user-cell">
                                    <?php if (!empty($usr['avatar'])): ?>
                                        <img src="<?= base_url('uploads/avatars/' . $usr['avatar']) ?>" alt="" class="user-avatar-sm">
                                    <?php else: ?>
                                        <div class="user-avatar-placeholder"><i class="fas fa-user"></i></div>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($usr['name']) ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($usr['email']) ?></td>
                            <td><?= htmlspecialchars($usr['phone'] ?? '-') ?></td>
                            <td><span class="badge badge-role-<?= $usr['role'] ?>"><?= ucfirst($usr['role']) ?></span></td>
                            <td>
                                <?php if ($usr['is_active']): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y', strtotime($usr['created_at'])) ?></td>
                            <td>
                                <form method="POST" action="<?= site_url('admin/users_toggle/' . $usr['id']) ?>" style="display:inline">
                                    <?= csrf_field() ?>
                                    <?php if ($usr['is_active']): ?>
                                        <input type="hidden" name="is_active" value="0">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Deactivate"><i class="fas fa-ban"></i></button>
                                    <?php else: ?>
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn btn-sm btn-success" title="Activate"><i class="fas fa-check"></i></button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>No users found.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.filter-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.filter-tab').forEach(function(t) { t.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('#usersTable tbody tr').forEach(function(row) {
            if (filter === 'all' || row.dataset.role === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
