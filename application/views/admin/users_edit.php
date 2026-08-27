<div class="page-header">
    <h1 class="page-title"><i class="fas fa-user-edit"></i> Edit User</h1>
    <a href="<?= site_url('admin/users') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Users</a>
</div>

<div class="form-card card-3d">
    <?php if (validation_errors()): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= validation_errors() ?></div>
    <?php endif; ?>

    <?= form_open('admin/users_edit/' . $user['id']) ?>
        <div class="form-grid">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name', $user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= set_value('email', $user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                <small class="text-muted">Leave empty to keep current password</small>
            </div>
            <div class="form-group">
                <label for="role"><i class="fas fa-users-cog"></i> Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="titipers" <?= $user['role'] === 'titipers' ? 'selected' : '' ?>>Titipers (Penjual)</option>
                    <option value="bidders" <?= $user['role'] === 'bidders' ? 'selected' : '' ?>>Bidders (Pembeli)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="is_active"><i class="fas fa-toggle-on"></i> Status *</label>
                <select id="is_active" name="is_active" class="form-control" required>
                    <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= !$user['is_active'] ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= set_value('phone', $user['phone']) ?>">
            </div>
            <div class="form-group full-width">
                <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                <textarea id="address" name="address" class="form-control" rows="3"><?= set_value('address', $user['address']) ?></textarea>
            </div>
        </div>

        <div class="user-meta-info">
            <div class="meta-item">
                <span class="meta-label">Joined:</span>
                <span class="meta-value"><?= date('d M Y H:i', strtotime($user['created_at'])) ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Last Updated:</span>
                <span class="meta-value"><?= date('d M Y H:i', strtotime($user['updated_at'])) ?></span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
            <a href="<?= site_url('admin/users') ?>" class="btn btn-outline">Cancel</a>
        </div>
    <?= form_close() ?>
</div>
