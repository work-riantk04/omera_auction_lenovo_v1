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

/* --- Carousel --- */
(function() {
    var carousel = document.getElementById('eventCarousel');
    if (!carousel) return;

    var slides = carousel.querySelectorAll('.carousel-slide');
    var dots = carousel.querySelectorAll('.carousel-dot');
    var prevBtn = document.getElementById('carouselPrev');
    var nextBtn = document.getElementById('carouselNext');
    var current = 0;
    var autoTimer = null;

    function showSlide(index) {
        slides.forEach(function(s, i) {
            s.style.display = (i === index) ? 'block' : 'none';
            s.classList.toggle('active', i === index);
        });
        dots.forEach(function(d, i) {
            d.classList.toggle('active', i === index);
        });
    }

    function next() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    function prev() {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    }

    if (nextBtn) nextBtn.addEventListener('click', function() { next(); resetAuto(); });
    if (prevBtn) prevBtn.addEventListener('click', function() { prev(); resetAuto(); });

    dots.forEach(function(dot, i) {
        dot.addEventListener('click', function() {
            current = i;
            showSlide(current);
            resetAuto();
        });
    });

    function resetAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(next, 5000);
    }

    showSlide(0);
    resetAuto();

    carousel.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    carousel.addEventListener('mouseleave', resetAuto);
})();

/* --- Universal Countdown (data-end) --- */
(function() {
    var elements = document.querySelectorAll('[data-end]');
    if (!elements.length) return;

    function pad(n) { return n < 10 ? '0' + n : String(n); }

    function updateAll() {
        var now = new Date().getTime();

        elements.forEach(function(el) {
            var endStr = el.getAttribute('data-end');
            if (!endStr) return;

            var end = new Date(endStr.replace(' ', 'T')).getTime();
            if (isNaN(end)) return;

            var diff = end - now;

            if (diff <= 0) {
                el.textContent = 'Selesai';
                return;
            }

            var days = Math.floor(diff / (86400000));
            var hours = Math.floor((diff % 86400000) / 3600000);
            var minutes = Math.floor((diff % 3600000) / 60000);
            var seconds = Math.floor((diff % 60000) / 1000);

            var txt;
            if (days > 0) {
                txt = days + 'h ' + pad(hours) + 'j ' + pad(minutes) + 'm ' + pad(seconds) + 'd';
            } else if (hours > 0) {
                txt = pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
            } else {
                txt = pad(minutes) + ':' + pad(seconds);
            }

            el.textContent = txt;
        });
    }

    updateAll();
    setInterval(updateAll, 1000);
})();

/* --- Number Roller (Matrix Style) --- */
(function() {
    var counters = document.querySelectorAll('.stat-number[data-count]');
    if (!counters.length) return;

    counters.forEach(function(el, elIndex) {
        var target = parseInt(el.getAttribute('data-count')) || 0;
        var frame = 0;
        var maxFrames = 22;
        var interval = 60;

        var timer = setTimeout(function() {
            var rolling = setInterval(function() {
                el.textContent = Math.floor(Math.random() * (target + 8));
                frame++;

                if (frame >= maxFrames) {
                    clearInterval(rolling);
                    el.textContent = target;
                }
            }, interval);
        }, 300 + (elIndex * 200));
    });
})();
</script>
</body>
</html>
