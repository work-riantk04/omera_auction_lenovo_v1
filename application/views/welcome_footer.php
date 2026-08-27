<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <p>&copy; 2024 Omera Auction. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
(function() {
    var btn = document.getElementById('userDropdownBtn');
    var wrapper = btn ? btn.closest('.user-dropdown') : null;
    var menu = document.getElementById('userDropdown');

    if (btn && wrapper) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            wrapper.classList.toggle('show');
        });
    }

    document.addEventListener('click', function(e) {
        if (wrapper && !wrapper.contains(e.target)) {
            wrapper.classList.remove('show');
        }
    });
})();
</script>
</body>
</html>
