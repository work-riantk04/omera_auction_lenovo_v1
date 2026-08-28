<div class="page-header">
    <h1 class="page-title"><i class="fas fa-users"></i> Manage Users</h1>
    <a href="<?= site_url('admin/users_create') ?>" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> Create User</a>
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
                                        <img src="<?= base_url('uploads/avatars/' . $usr['avatar']) ?>" alt="" class="user-avatar-sm" onerror="this.onerror=null;this.src='<?= base_url('assets/images/default-avatar.svg') ?>'">
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
                                <div class="action-buttons">
                                    <a href="<?= site_url('admin/users_edit/' . $usr['id']) ?>" class="btn btn-sm btn-outline" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="<?= site_url('admin/users_toggle/' . $usr['id']) ?>" style="display:inline">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <?php if ($usr['is_active']): ?>
                                            <input type="hidden" name="is_active" value="0">
                                            <button type="submit" class="btn btn-sm btn-warning" title="Deactivate"><i class="fas fa-ban"></i></button>
                                        <?php else: ?>
                                            <input type="hidden" name="is_active" value="1">
                                            <button type="submit" class="btn btn-sm btn-success" title="Activate"><i class="fas fa-check"></i></button>
                                        <?php endif; ?>
                                    </form>
                                    <?php if ($usr['role'] !== 'admin'): ?>
                                        <a href="<?= site_url('admin/users_delete/' . $usr['id']) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fas fa-trash"></i></a>
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
