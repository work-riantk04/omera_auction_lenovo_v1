<div class="page-header">
    <h1 class="page-title">Edit Event</h1>
    <a href="<?= site_url('admin/events') ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Events</a>
</div>

<div class="form-card">
    <?= form_open_multipart('admin/events_edit/' . $event['id']) ?>
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="name">Event Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name', $event['name']) ?>" required>
                <?= form_error('name', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group full-width">
                <label for="description">Description <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5" required><?= set_value('description', $event['description']) ?></textarea>
                <?= form_error('description', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group full-width">
                <label for="banner_image">Banner Image</label>
                <?php if (!empty($event['banner_image'])): ?>
                    <div class="current-image">
                        <img src="<?= base_url('uploads/events/' . $event['banner_image']) ?>" alt="Current banner">
                        <span class="image-label">Current banner</span>
                    </div>
                <?php endif; ?>
                <div class="file-upload">
                    <input type="file" id="banner_image" name="banner_image" accept="image/*" class="form-control" onchange="previewBanner(this)">
                    <div class="file-upload-preview" id="bannerPreview">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Click or drag to replace banner</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="item_collection_deadline">Item Collection Deadline</label>
                <input type="datetime-local" id="item_collection_deadline" name="item_collection_deadline" class="form-control" value="<?= set_value('item_collection_deadline', !empty($event['item_collection_deadline']) ? date('Y-m-d\TH:i', strtotime($event['item_collection_deadline'])) : '') ?>">
                <?= form_error('item_collection_deadline', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_start">Auction Start</label>
                <input type="datetime-local" id="auction_start" name="auction_start" class="form-control" value="<?= set_value('auction_start', !empty($event['auction_start']) ? date('Y-m-d\TH:i', strtotime($event['auction_start'])) : '') ?>">
                <?= form_error('auction_start', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_end">Auction End</label>
                <input type="datetime-local" id="auction_end" name="auction_end" class="form-control" value="<?= set_value('auction_end', !empty($event['auction_end']) ? date('Y-m-d\TH:i', strtotime($event['auction_end'])) : '') ?>">
                <?= form_error('auction_end', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <?php
                    $statuses = ['upcoming', 'collecting', 'verifying', 'active', 'completed', 'cancelled'];
                    foreach ($statuses as $st):
                        $selected = set_value('status', $event['status']) === $st ? 'selected' : '';
                    ?>
                        <option value="<?= $st ?>" <?= $selected ?>><?= ucfirst($st) ?></option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('status', '<span class="form-error">', '</span>') ?>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= site_url('admin/events') ?>" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Event</button>
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
</script>
