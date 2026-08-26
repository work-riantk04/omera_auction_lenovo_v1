    <footer class="site-footer-simple">
        <p>&copy; <?= date('Y') ?> Omera Auction. All rights reserved.</p>
    </footer>
</div>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
    function togglePassword(fieldId, btn) {
        var input = document.getElementById(fieldId);
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
