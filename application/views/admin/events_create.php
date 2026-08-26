<div class="page-header">
    <h1 class="page-title">Create Event</h1>
    <a href="<?= site_url('admin/events') ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Events</a>
</div>

<div class="form-card">
    <?= form_open_multipart('admin/events_create') ?>
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="name">Event Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name') ?>" required placeholder="Enter event name">
                <?= form_error('name', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group full-width">
                <label for="description">Description <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5" required placeholder="Describe the event..."><?= set_value('description') ?></textarea>
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
                <?= form_error('item_collection_deadline', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_start">Auction Start <span class="required">*</span></label>
                <input type="datetime-local" id="auction_start" name="auction_start" class="form-control" value="<?= set_value('auction_start') ?>" required>
                <?= form_error('auction_start', '<span class="form-error">', '</span>') ?>
            </div>

            <div class="form-group">
                <label for="auction_end">Auction End <span class="required">*</span></label>
                <input type="datetime-local" id="auction_end" name="auction_end" class="form-control" value="<?= set_value('auction_end') ?>" required>
                <?= form_error('auction_end', '<span class="form-error">', '</span>') ?>
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
</script>
