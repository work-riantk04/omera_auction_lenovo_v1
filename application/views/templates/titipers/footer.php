            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
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
                var sidebar = document.getElementById('sidebar');
                var toggle = document.querySelector('.sidebar-toggle');
                if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && (!toggle || !toggle.contains(e.target))) {
                    sidebar.classList.remove('open');
                }
            });
        })();

        function pollNotifications() {
            fetch('<?= site_url("api/unread_count") ?>', {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                var badge = document.getElementById('notifCount');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.style.display = 'flex';
                    } else {
                        badge.textContent = '';
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(function() {});
        }

        pollNotifications();
        setInterval(pollNotifications, 30000);
    </script>
</body>
</html>
