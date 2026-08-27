/* ============================================================
   OMERA AUCTION - Main JavaScript
   ============================================================ */

(function () {
  'use strict';

  /* ----------------------------------------------------------
     COUNTDOWN TIMER
     ---------------------------------------------------------- */
  function initCountdowns() {
    var timers = document.querySelectorAll('[data-countdown]');
    timers.forEach(function (el) {
      var target = el.getAttribute('data-countdown');
      if (!target) return;
      updateCountdown(el, target);
      setInterval(function () {
        updateCountdown(el, target);
      }, 1000);
    });
  }

  function updateCountdown(el, datetimeStr) {
    var now = new Date().getTime();
    var target = new Date(datetimeStr).getTime();
    var diff = target - now;

    if (diff <= 0) {
      el.innerHTML = '<span class="countdown-expired">Auction Ended</span>';
      var parent = el.closest('.auction-card');
      if (parent) parent.classList.add('ended');
      return;
    }

    var days = Math.floor(diff / (1000 * 60 * 60 * 24));
    var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((diff % (1000 * 60)) / 1000);

    var isUrgent = diff < 1000 * 60 * 60;
    if (isUrgent) {
      el.classList.add('urgent');
    }

    el.innerHTML =
      '<div class="time-block"><div class="number">' + padZero(days) + '</div><div class="label">Days</div></div>' +
      '<div class="time-block"><div class="number">' + padZero(hours) + '</div><div class="label">Hrs</div></div>' +
      '<div class="time-block"><div class="number">' + padZero(minutes) + '</div><div class="label">Min</div></div>' +
      '<div class="time-block"><div class="number">' + padZero(seconds) + '</div><div class="label">Sec</div></div>';
  }

  function padZero(n) {
    return n < 10 ? '0' + n : String(n);
  }

  /* ----------------------------------------------------------
     AJAX BID
     ---------------------------------------------------------- */
  window.placeBid = function (auctionId, btn) {
    var input = document.getElementById('bid-amount-' + auctionId);
    if (!input) return;

    var amount = input.value.trim();
    if (!amount || isNaN(amount) || Number(amount) <= 0) {
      showToast('Please enter a valid bid amount.', 'danger');
      return;
    }

    if (!confirm('Are you sure you want to bid ' + formatCurrency(amount) + '?')) {
      return;
    }

    var originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing...';

    var formData = new FormData();
    formData.append('auction_id', auctionId);
    formData.append('amount', amount);

    fetch('index.php/api/bid', {
      method: 'POST',
      body: formData
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          showToast(data.message || 'Bid placed successfully!', 'success');
          input.value = '';
          if (data.new_price) {
            var priceEl = document.getElementById('current-price-' + auctionId);
            if (priceEl) priceEl.textContent = formatCurrency(data.new_price);
          }
          if (data.redirect) {
            setTimeout(function () { window.location.href = data.redirect; }, 1500);
          } else {
            setTimeout(function () { window.location.reload(); }, 1200);
          }
        } else {
          showToast(data.message || 'Failed to place bid.', 'danger');
        }
      })
      .catch(function () {
        showToast('Network error. Please try again.', 'danger');
      })
      .finally(function () {
        btn.disabled = false;
        btn.innerHTML = originalText;
      });
  };

  /* ----------------------------------------------------------
     MODAL FUNCTIONS
     ---------------------------------------------------------- */
  window.openModal = function (modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add('show');
      document.body.style.overflow = 'hidden';
    }
  };

  window.closeModal = function (modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove('show');
      document.body.style.overflow = '';
    }
  };

  function initModals() {
    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
      overlay.addEventListener('click', function (e) {
        if (e.target === overlay) {
          overlay.classList.remove('show');
          document.body.style.overflow = '';
        }
      });
    });

    document.querySelectorAll('[data-open-modal]').forEach(function (el) {
      el.addEventListener('click', function (e) {
        e.preventDefault();
        var id = el.getAttribute('data-open-modal');
        openModal(id);
      });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (el) {
      el.addEventListener('click', function (e) {
        e.preventDefault();
        var id = el.getAttribute('data-close-modal');
        closeModal(id);
      });
    });

    document.querySelectorAll('.modal-close').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var modal = btn.closest('.modal-overlay');
        if (modal) {
          modal.classList.remove('show');
          document.body.style.overflow = '';
        }
      });
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(function (m) {
          m.classList.remove('show');
        });
        document.body.style.overflow = '';
      }
    });
  }

  /* ----------------------------------------------------------
     FORM VALIDATION HELPERS
     ---------------------------------------------------------- */
  window.validateRequired = function (input) {
    var val = input.value.trim();
    if (!val) {
      input.classList.add('is-invalid');
      input.classList.remove('is-valid');
      return false;
    }
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    return true;
  };

  window.validateEmail = function (input) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(input.value.trim())) {
      input.classList.add('is-invalid');
      input.classList.remove('is-valid');
      return false;
    }
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    return true;
  };

  window.validateMinLength = function (input, min) {
    if (input.value.trim().length < min) {
      input.classList.add('is-invalid');
      input.classList.remove('is-valid');
      return false;
    }
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    return true;
  };

  window.validateForm = function (formId) {
    var form = document.getElementById(formId);
    if (!form) return false;

    var valid = true;
    form.querySelectorAll('[data-validate]').forEach(function (input) {
      var rules = input.getAttribute('data-validate').split(',');
      rules.forEach(function (rule) {
        rule = rule.trim();
        if (rule === 'required' && !validateRequired(input)) valid = false;
        if (rule === 'email' && !validateEmail(input)) valid = false;
        if (rule.startsWith('min:')) {
          var min = parseInt(rule.split(':')[1], 10);
          if (!validateMinLength(input, min)) valid = false;
        }
      });
    });

    return valid;
  };

  function initFormValidation() {
    document.querySelectorAll('[data-validate]').forEach(function (input) {
      input.addEventListener('blur', function () {
        var rules = input.getAttribute('data-validate').split(',');
        rules.forEach(function (rule) {
          rule = rule.trim();
          if (rule === 'required') validateRequired(input);
          if (rule === 'email') validateEmail(input);
          if (rule.startsWith('min:')) {
            validateMinLength(input, parseInt(rule.split(':')[1], 10));
          }
        });
      });

      input.addEventListener('input', function () {
        if (input.classList.contains('is-invalid')) {
          input.classList.remove('is-invalid');
        }
      });
    });
  }

  /* ----------------------------------------------------------
     NOTIFICATION POLLING
     ---------------------------------------------------------- */
  var notificationInterval = null;

  window.startNotificationPolling = function () {
    fetchNotificationCount();
    notificationInterval = setInterval(fetchNotificationCount, 30000);
  };

  window.stopNotificationPolling = function () {
    if (notificationInterval) {
      clearInterval(notificationInterval);
      notificationInterval = null;
    }
  };

  function fetchNotificationCount() {
    fetch('api/notifications_count')
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var countEl = document.querySelector('.notification-bell .badge-count');
        if (countEl) {
          var count = data.count || 0;
          countEl.textContent = count;
          countEl.style.display = count > 0 ? 'flex' : 'none';
        }
      })
      .catch(function () { });
  }

  function initNotificationDropdown() {
    var bell = document.querySelector('.notification-bell');
    if (!bell) return;

    bell.addEventListener('click', function (e) {
      e.stopPropagation();
      var dropdown = bell.querySelector('.notification-dropdown');
      if (dropdown) {
        dropdown.classList.toggle('show');
      }
    });

    document.addEventListener('click', function () {
      var dropdown = document.querySelector('.notification-dropdown.show');
      if (dropdown) dropdown.classList.remove('show');
    });
  }

  /* ----------------------------------------------------------
     SMOOTH SCROLL
     ---------------------------------------------------------- */
  window.smoothScrollTo = function (target, offset) {
    offset = offset || 80;
    var el = document.querySelector(target);
    if (el) {
      var top = el.getBoundingClientRect().top + window.pageYOffset - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    }
  };

  function initSmoothScrollLinks() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var href = link.getAttribute('href');
        if (href && href.length > 1) {
          e.preventDefault();
          smoothScrollTo(href);
        }
      });
    });
  }

  /* ----------------------------------------------------------
     CONFIRM DIALOGS FOR DANGEROUS ACTIONS
     ---------------------------------------------------------- */
  function initConfirmDialogs() {
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
      el.addEventListener('click', function (e) {
        var msg = el.getAttribute('data-confirm') || 'Are you sure?';
        if (!confirm(msg)) {
          e.preventDefault();
          e.stopPropagation();
        }
      });
    });
  }

  /* ----------------------------------------------------------
     AUTO-HIDE FLASH MESSAGES
     ---------------------------------------------------------- */
  function initFlashMessages() {
    document.querySelectorAll('.flash-message').forEach(function (el) {
      el.classList.add('auto-hide');
      setTimeout(function () {
        el.style.opacity = '0';
        el.style.transform = 'translateX(40px)';
        el.style.transition = 'all 0.3s ease';
        setTimeout(function () { el.remove(); }, 300);
      }, 5000);
    });

    document.querySelectorAll('.alert .alert-close').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var alert = btn.closest('.alert');
        if (alert) {
          alert.style.opacity = '0';
          alert.style.transform = 'translateX(20px)';
          alert.style.transition = 'all 0.2s ease';
          setTimeout(function () { alert.remove(); }, 200);
        }
      });
    });
  }

  /* ----------------------------------------------------------
     TOGGLE SIDEBAR ON MOBILE
     ---------------------------------------------------------- */
  window.toggleSidebar = function () {
    var sidebar = document.querySelector('.dashboard-sidebar');
    if (sidebar) {
      sidebar.classList.toggle('open');
    }
  };

  function initSidebarToggle() {
    var toggle = document.querySelector('.sidebar-toggle');
    if (toggle) {
      toggle.addEventListener('click', toggleSidebar);
    }

    document.addEventListener('click', function (e) {
      var sidebar = document.querySelector('.dashboard-sidebar.open');
      if (sidebar && !sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
        sidebar.classList.remove('open');
      }
    });
  }

  /* ----------------------------------------------------------
     IMAGE PREVIEW ON FILE UPLOAD
     ---------------------------------------------------------- */
  window.previewImage = function (input, previewId) {
    var preview = document.getElementById(previewId);
    if (!preview || !input.files || !input.files[0]) return;

    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  };

  function initImageUploads() {
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
      input.addEventListener('change', function () {
        var previewId = input.getAttribute('data-preview');
        previewImage(input, previewId);
      });
    });
  }

  /* ----------------------------------------------------------
     FORMAT CURRENCY TO IDR
     ---------------------------------------------------------- */
  window.formatCurrency = function (amount) {
    var num = parseInt(amount, 10);
    if (isNaN(num)) return 'Rp 0';
    var str = num.toString();
    var result = '';
    var count = 0;
    for (var i = str.length - 1; i >= 0; i--) {
      result = str[i] + result;
      count++;
      if (count % 3 === 0 && i !== 0) {
        result = '.' + result;
      }
    }
    return 'Rp ' + result;
  };

  /* ----------------------------------------------------------
     TOAST NOTIFICATIONS
     ---------------------------------------------------------- */
  window.showToast = function (message, type) {
    type = type || 'info';
    var container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      container.style.cssText = 'position:fixed;top:84px;right:20px;z-index:2500;display:flex;flex-direction:column;gap:8px;';
      document.body.appendChild(container);
    }

    var toast = document.createElement('div');
    var bgMap = {
      success: 'rgba(34,197,94,0.15)',
      danger: 'rgba(239,68,68,0.15)',
      warning: 'rgba(245,158,11,0.15)',
      info: 'rgba(59,130,246,0.15)'
    };
    var borderMap = {
      success: 'rgba(34,197,94,0.3)',
      danger: 'rgba(239,68,68,0.3)',
      warning: 'rgba(245,158,11,0.3)',
      info: 'rgba(59,130,246,0.3)'
    };

    toast.style.cssText =
      'padding:14px 20px;border-radius:10px;font-size:0.875rem;font-family:Inter,sans-serif;' +
      'backdrop-filter:blur(10px);border:1px solid ' + (borderMap[type] || borderMap.info) + ';' +
      'background:' + (bgMap[type] || bgMap.info) + ';color:#f1f5f9;' +
      'box-shadow:0 8px 32px rgba(0,0,0,0.3);animation:slideInRight 0.3s ease;min-width:280px;max-width:400px;';

    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(function () {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(40px)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(function () { toast.remove(); }, 300);
    }, 4000);
  };

  /* ----------------------------------------------------------
     NAVBAR SCROLL EFFECT
     ---------------------------------------------------------- */
  function initNavbarScroll() {
    var navbar = document.querySelector('.navbar');
    if (!navbar) return;

    window.addEventListener('scroll', function () {
      if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }

  /* ----------------------------------------------------------
     MOBILE NAVBAR TOGGLE
     ---------------------------------------------------------- */
  function initMobileNav() {
    var toggle = document.querySelector('.navbar-toggle');
    var menu = document.querySelector('.navbar-menu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
      menu.classList.toggle('show');
      var isOpen = menu.classList.contains('show');
      toggle.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
  }

  /* ----------------------------------------------------------
     QUICK BID BUTTONS
     ---------------------------------------------------------- */
  function initQuickBids() {
    document.querySelectorAll('.quick-bid-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var amount = btn.getAttribute('data-amount');
        var targetId = btn.getAttribute('data-target');
        var input = document.getElementById(targetId);
        if (input && amount) {
          input.value = amount;
          input.focus();
        }
      });
    });
  }

  /* ----------------------------------------------------------
     DRAG & DROP UPLOAD AREA
     ---------------------------------------------------------- */
  function initDragDropUpload() {
    document.querySelectorAll('.upload-area').forEach(function (area) {
      var input = area.querySelector('input[type="file"]');
      if (!input) return;

      area.addEventListener('dragover', function (e) {
        e.preventDefault();
        area.classList.add('dragover');
      });

      area.addEventListener('dragleave', function () {
        area.classList.remove('dragover');
      });

      area.addEventListener('drop', function (e) {
        e.preventDefault();
        area.classList.remove('dragover');
        if (e.dataTransfer.files.length) {
          input.files = e.dataTransfer.files;
          input.dispatchEvent(new Event('change'));
        }
      });

      area.addEventListener('click', function () {
        input.click();
      });
    });
  }

  /* ----------------------------------------------------------
     INITIALIZE ALL
     ---------------------------------------------------------- */
  function init() {
    initCountdowns();
    initModals();
    initFormValidation();
    initNotificationDropdown();
    initSmoothScrollLinks();
    initConfirmDialogs();
    initFlashMessages();
    initSidebarToggle();
    initImageUploads();
    initNavbarScroll();
    initMobileNav();
    initQuickBids();
    initDragDropUpload();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
