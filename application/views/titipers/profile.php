<div class="page-header">
    <h1 class="page-title"><i class="fas fa-user-circle"></i> My Profile</h1>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= validation_errors() ?></div>
<?php endif; ?>

<div class="profile-grid">
    <!-- Profile Card -->
    <div class="profile-card card-3d">
        <div class="profile-avatar-section">
            <div class="profile-avatar">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" alt="Avatar" onerror="this.onerror=null;this.src='<?= base_url('assets/images/default-avatar.svg') ?>'">
                <?php else: ?>
                    <div class="avatar-placeholder"><i class="fas fa-user"></i></div>
                <?php endif; ?>
            </div>
            <h3><?= htmlspecialchars($user['name']) ?></h3>
            <span class="badge badge-role-<?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span>
            <span class="badge <?= $user['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
            </span>
        </div>
        <div class="profile-info-list">
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <span><?= htmlspecialchars($user['email']) ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <span><?= htmlspecialchars($user['phone'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span><?= htmlspecialchars($user['address'] ?? '-') ?></span>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar"></i>
                <span>Joined <?= date('d M Y', strtotime($user['created_at'])) ?></span>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="profile-form-card card-3d">
        <h3><i class="fas fa-edit"></i> Edit Profile</h3>
        <?= form_open_multipart('titipers/profile') ?>
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
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?= set_value('phone', $user['phone']) ?>">
                </div>
                <div class="form-group">
                    <label for="avatar"><i class="fas fa-camera"></i> Avatar</label>
                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                </div>
                <div class="form-group full-width">
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" class="form-control" rows="3"><?= set_value('address', $user['address']) ?></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        <?= form_close() ?>
    </div>

    <!-- Change Password Form -->
    <div class="profile-form-card card-3d">
        <h3><i class="fas fa-lock"></i> Change Password</h3>
        <?= form_open('titipers/profile') ?>
            <input type="hidden" name="change_password" value="1">
            <div class="form-grid">
                <div class="form-group">
                    <label for="new_password"><i class="fas fa-lock"></i> New Password *</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Min 6 characters" minlength="6" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repeat password" minlength="6" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Update Password</button>
            </div>
        <?= form_close() ?>
    </div>
</div>
