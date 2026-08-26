            </div>
        </main>
    </div>

    <script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        var sidebar = document.querySelector('.sidebar');
        var toggle = document.querySelector('.sidebar-toggle');
        if (sidebar && sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });

    (function pollNotifications() {
        fetch('<?= site_url("api/notifications_count") ?>', { credentials: 'same-origin' })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var badge = document.getElementById('notifCount');
                if (badge && data.status === 'success' && data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.classList.add('show');
                } else if (badge) {
                    badge.classList.remove('show');
                }
            })
            .catch(function() {})
            .then(function() {
                setTimeout(pollNotifications, 30000);
            });
    })();
    </script>
</body>
</html>
