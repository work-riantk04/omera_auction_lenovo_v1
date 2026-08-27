<div class="page-header">
    <h1 class="page-title">Create Event</h1>
    <a href="<?= site_url('admin/events') ?>" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Events</a>
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= strip_tags(validation_errors()) ?></div>
<?php endif; ?>

<div class="form-card">
    <?= form_open_multipart('admin/events_create', ['id' => 'eventForm']) ?>
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="name">Event Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name') ?>" required placeholder="Enter event name">
                <span class="form-error-msg"></span>
                <?= form_error('name', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group full-width">
                <label for="description">Description <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5" required placeholder="Describe the event..."><?= set_value('description') ?></textarea>
                <span class="form-error-msg"></span>
                <?= form_error('description', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group full-width">
                <label for="banner_image">Banner Image</label>
                <div class="file-upload">
                    <input type="file" id="banner_image" name="banner_image" accept="image/*" class="form-control" onchange="previewBanner(this)">
                    <div class="file-upload-preview" id="bannerPreview">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Click or drag to upload banner</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="item_collection_deadline">Item Collection Deadline <span class="required">*</span></label>
                <input type="datetime-local" id="item_collection_deadline" name="item_collection_deadline" class="form-control" value="<?= set_value('item_collection_deadline') ?>" required>
                <span class="form-error-msg"></span>
                <?= form_error('item_collection_deadline', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_start">Auction Start <span class="required">*</span></label>
                <input type="datetime-local" id="auction_start" name="auction_start" class="form-control" value="<?= set_value('auction_start') ?>" required>
                <span class="form-error-msg"></span>
                <?= form_error('auction_start', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_end">Auction End <span class="required">*</span></label>
                <input type="datetime-local" id="auction_end" name="auction_end" class="form-control" value="<?= set_value('auction_end') ?>" required>
                <span class="form-error-msg"></span>
                <?= form_error('auction_end', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" class="form-control" required>
                    <option value="">-- Select Status --</option>
                    <?php
                    $statuses = ['upcoming' => 'Upcoming', 'collecting' => 'Collecting', 'verifying' => 'Verifying', 'active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
                    foreach ($statuses as $val => $label):
                    ?>
                        <option value="<?= $val ?>" <?= set_value('status') === $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form-error-msg"></span>
                <?= form_error('status', '<span class="form-error">', '</span>') ?>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= site_url('admin/events') ?>" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Event</button>
        </div>
    <?= form_close() ?>
</div>

<script>
function previewBanner(input) {
    var preview = document.getElementById('bannerPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

(function() {
    var form = document.getElementById('eventForm');
    if (!form) return;

    var requiredFields = [
        { name: 'name', label: 'Event Name' },
        { name: 'description', label: 'Description' },
        { name: 'item_collection_deadline', label: 'Item Collection Deadline' },
        { name: 'auction_start', label: 'Auction Start' },
        { name: 'auction_end', label: 'Auction End' },
        { name: 'status', label: 'Status' }
    ];

    form.addEventListener('submit', function(e) {
        var errors = [];
        var firstInvalid = null;

        requiredFields.forEach(function(field) {
            var el = form.elements[field.name];
            var group = el.closest('.form-group');
            var msg = group ? group.querySelector('.form-error-msg') : null;
            var val = el.value ? el.value.trim() : '';

            if (!val) {
                errors.push(field.label + ' is required');
                if (group) group.classList.add('has-error');
                if (msg) msg.textContent = field.label + ' is required';
                if (!firstInvalid) firstInvalid = el;
            } else {
                if (group) group.classList.remove('has-error');
                if (msg) msg.textContent = '';
            }
        });

        if (errors.length > 0) {
            e.preventDefault();
            showToast('Please fill in all required fields', 'error');
            if (firstInvalid) firstInvalid.focus();
            return false;
        }
    });

    form.addEventListener('change', function(e) {
        var el = e.target;
        var group = el.closest('.form-group');
        if (!group) return;
        if (el.value && el.value.trim()) {
            group.classList.remove('has-error');
            var msg = group.querySelector('.form-error-msg');
            if (msg) msg.textContent = '';
        }
    });

    function showToast(message, type) {
        var existing = document.querySelector('.toast-alert');
        if (existing) existing.remove();

        var toast = document.createElement('div');
        toast.className = 'toast-alert toast-' + type;
        toast.innerHTML = '<i class="fas fa-' + (type === 'error' ? 'exclamation-circle' : 'check-circle') + '"></i> ' + message;
        document.body.appendChild(toast);

        setTimeout(function() { toast.classList.add('show'); }, 10);
        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    }
})();
</script>
