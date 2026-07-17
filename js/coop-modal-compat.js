/**
 * Bootstrap 4 → 5 modal compatibility for DashLite.
 * Legacy markup uses data-dismiss / data-toggle; BS5 needs data-bs-*.
 */
(function () {
    function syncModalAttributes(root) {
        root = root || document;

        Array.prototype.forEach.call(root.querySelectorAll('[data-dismiss="modal"]'), function (el) {
            if (!el.getAttribute('data-bs-dismiss')) {
                el.setAttribute('data-bs-dismiss', 'modal');
            }
        });

        Array.prototype.forEach.call(root.querySelectorAll('[data-toggle="modal"]'), function (el) {
            if (!el.getAttribute('data-bs-toggle')) {
                el.setAttribute('data-bs-toggle', 'modal');
            }
            var target = el.getAttribute('data-target');
            if (target && !el.getAttribute('data-bs-target')) {
                el.setAttribute('data-bs-target', target);
            }
        });
    }

    function hideModal(modalEl) {
        if (!modalEl) {
            return;
        }

        // Prefer Bootstrap 5 API when available
        if (window.bootstrap && bootstrap.Modal) {
            var instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            instance.hide();
            return;
        }

        // jQuery Bootstrap plugin fallback
        if (window.jQuery && jQuery.fn.modal) {
            jQuery(modalEl).modal('hide');
            return;
        }

        // Manual fallback
        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.removeAttribute('aria-modal');
        document.body.classList.remove('modal-open');
        Array.prototype.forEach.call(document.querySelectorAll('.modal-backdrop'), function (bd) {
            bd.parentNode && bd.parentNode.removeChild(bd);
        });
    }

    function showModal(modalEl) {
        if (!modalEl) {
            return;
        }
        if (window.bootstrap && bootstrap.Modal) {
            var instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            instance.show();
            return;
        }
        if (window.jQuery && jQuery.fn.modal) {
            jQuery(modalEl).modal('show');
        }
    }

    function onDocClick(e) {
        var dismiss = e.target.closest ? e.target.closest('[data-dismiss="modal"], [data-bs-dismiss="modal"]') : null;
        if (dismiss) {
            e.preventDefault();
            var modal = dismiss.closest('.modal');
            hideModal(modal);
            return;
        }

        var opener = e.target.closest ? e.target.closest('[data-toggle="modal"], [data-bs-toggle="modal"]') : null;
        if (opener) {
            var targetSel = opener.getAttribute('data-bs-target') || opener.getAttribute('data-target');
            if (targetSel && targetSel.charAt(0) === '#') {
                var modalEl = document.querySelector(targetSel);
                if (modalEl) {
                    // Let native BS5 handle if present; otherwise open manually
                    if (!(window.bootstrap && bootstrap.Modal) && !(window.jQuery && jQuery.fn.modal)) {
                        e.preventDefault();
                        showModal(modalEl);
                    } else if (!opener.getAttribute('data-bs-toggle')) {
                        e.preventDefault();
                        showModal(modalEl);
                    }
                }
            }
        }
    }

    function boot() {
        syncModalAttributes(document);
        document.addEventListener('click', onDocClick, true);

        // Keep attributes in sync for dynamically inserted modals
        if (window.MutationObserver) {
            var obs = new MutationObserver(function (mutations) {
                for (var i = 0; i < mutations.length; i++) {
                    var nodes = mutations[i].addedNodes;
                    for (var j = 0; j < nodes.length; j++) {
                        if (nodes[j].nodeType === 1) {
                            syncModalAttributes(nodes[j]);
                        }
                    }
                }
            });
            obs.observe(document.body, { childList: true, subtree: true });
        }

        if (window.jQuery) {
            jQuery(document).on('shown.bs.modal', function (e) {
                if (e.target) {
                    syncModalAttributes(e.target);
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.coopSyncModalAttributes = syncModalAttributes;
})();
