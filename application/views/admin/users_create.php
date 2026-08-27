<div class="page-header">
    <h1 class="page-title"><i class="fas fa-user-plus"></i> Create User</h1>
    <a href="<?= site_url('admin/users') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Users</a>
</div>

<div class="form-card card-3d">
    <?php if (validation_errors()): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= validation_errors() ?></div>
    <?php endif; ?>

    <?= form_open('admin/users_create') ?>
        <div class="form-grid">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" value="<?= set_value('name') ?>" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" value="<?= set_value('email') ?>" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Min 6 characters" minlength="6" required>
            </div>
            <div class="form-group">
                <label for="role"><i class="fas fa-users-cog"></i> Role *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin" <?= set_value('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="titipers" <?= set_value('role') === 'titipers' ? 'selected' : '' ?>>Titipers (Penjual)</option>
                    <option value="bidders" <?= set_value('role') === 'bidders' ? 'selected' : '' ?>>Bidders (Pembeli)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone number" value="<?= set_value('phone') ?>">
            </div>
            <div class="form-group full-width">
                <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Enter address"><?= set_value('address') ?></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create User</button>
            <a href="<?= site_url('admin/users') ?>" class="btn btn-outline">Cancel</a>
        </div>
    <?= form_close() ?>
</div>
