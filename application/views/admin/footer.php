            </div><!-- end content-wrapper -->
        </main>
    </div>

    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.admin-wrapper .sidebar').classList.toggle('open');
        }

        (function() {
            var dd = document.getElementById('userDropdown');
            if (dd) {
                dd.querySelector('.user-dropdown-toggle').addEventListener('click', function(e) {
                    e.stopPropagation();
                    dd.classList.toggle('open');
                });
            }

            document.addEventListener('click', function(e) {
                if (dd && !dd.contains(e.target)) {
                    dd.classList.remove('open');
                }
                var sidebar = document.querySelector('.admin-wrapper .sidebar');
                var toggle = document.querySelector('.sidebar-toggle');
                if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && toggle && !toggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });
        })();

        function loadNotifCount() {
            fetch('<?= site_url('api/notifications_count') ?>')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    var badge = document.getElementById('notifCount');
                    if (badge) {
                        badge.textContent = data.count || 0;
                        badge.style.display = data.count > 0 ? 'flex' : 'none';
                    }
                })
                .catch(function() {});
        }
        loadNotifCount();
        setInterval(loadNotifCount, 30000);
    </script>
</body>
</html>
