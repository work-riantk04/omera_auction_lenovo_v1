            </div><!-- end content-wrapper -->
        </main>
    </div>

    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.admin-wrapper').classList.toggle('sidebar-collapsed');
        }

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
