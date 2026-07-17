/**
 * Convert legacy Material form markup to DashLite Form Elements (large).
 * Selects use DashLite Select2 (.form-select), not nice-select.
 * Safe to call repeatedly — never double-inits Select2.
 */
(function () {
    var CONTROL_SELECTOR = [
        'input.form-control',
        'select.form-control',
        'textarea.form-control',
        'select.select',
        'select',
        'input[type="text"]',
        'input[type="email"]',
        'input[type="password"]',
        'input[type="number"]',
        'input[type="tel"]',
        'input[type="url"]',
        'input[type="search"]',
        'input[type="date"]',
        'input[type="datetime-local"]',
        'input[type="time"]',
        'textarea'
    ].join(',');

    function shouldSkip(el) {
        if (!el || !el.closest) {
            return true;
        }
        if (el.closest('.nk-sidebar, .nk-header, .dataTables_wrapper, .dropdown-menu, .modal-search, .select2-container')) {
            return true;
        }
        if (el.type === 'hidden' || el.type === 'checkbox' || el.type === 'radio' || el.type === 'submit' || el.type === 'button' || el.type === 'file') {
            return true;
        }
        if (el.classList && el.classList.contains('btn')) {
            return true;
        }
        return false;
    }

    function destroyNiceSelect(select) {
        if (!select || !select.parentNode) {
            return;
        }
        var next = select.nextElementSibling;
        while (next && next.classList && next.classList.contains('nice-select')) {
            var remove = next;
            next = next.nextElementSibling;
            remove.parentNode.removeChild(remove);
        }
        select.style.display = '';
        select.classList.remove('select');
    }

    function cleanupSelect2Duplicates($el) {
        // Remove extra Select2 containers (double-init artifact)
        var parent = $el.parent();
        parent.find('> .select2-container').each(function (i) {
            if (i > 0) {
                jQuery(this).remove();
            }
        });
        // Also clean siblings after the select
        $el.nextAll('.select2-container').each(function (i) {
            if (i > 0) {
                jQuery(this).remove();
            }
        });
    }

    function ensureWrap(control) {
        if (control.parentElement && control.parentElement.classList.contains('form-control-wrap')) {
            return control.parentElement;
        }
        if (control.closest('.custom-file, .input-group, .form-control-select, .form-control-select-multiple, .select2-container')) {
            return null;
        }
        var wrap = document.createElement('div');
        wrap.className = 'form-control-wrap';
        control.parentNode.insertBefore(wrap, control);
        wrap.appendChild(control);
        return wrap;
    }

    function enhanceSelect(select) {
        if (shouldSkip(select) || select.tagName !== 'SELECT') {
            return;
        }
        destroyNiceSelect(select);

        select.classList.add('form-control', 'form-control-lg', 'form-select');
        select.classList.remove('select', 'js-select2');
        if (!select.getAttribute('data-ui')) {
            select.setAttribute('data-ui', 'lg');
        }
        if (!select.getAttribute('data-search') && select.options && select.options.length > 12) {
            select.setAttribute('data-search', 'on');
        }
        // Never allow clear button (causes white ghost box / doubled look)
        select.removeAttribute('data-clear');
        ensureWrap(select);
    }

    function initSelect2(root) {
        if (!window.jQuery || !jQuery.fn.select2) {
            return;
        }
        var $scope = root && root.nodeType ? jQuery(root) : jQuery(document);
        $scope.find('select.form-select').each(function () {
            var $el = jQuery(this);

            // Always strip nice-select leftovers
            $el.next('.nice-select').remove();

            if ($el.hasClass('select2-hidden-accessible')) {
                cleanupSelect2Duplicates($el);
                return;
            }

            // Remove any orphan containers before first init
            $el.nextAll('.select2-container').remove();

            var opts = {
                theme: 'default select2-lg',
                minimumResultsForSearch: ($el.attr('data-search') === 'on') ? 1 : Infinity,
                width: '100%',
                placeholder: $el.data('placeholder') || '',
                allowClear: false,
                dropdownParent: $el.closest('.modal').length ? $el.closest('.modal') : jQuery(document.body)
            };

            if (window.NioApp && typeof NioApp.Select2 === 'function') {
                // NioApp reads data-ui / data-search; force no clear
                $el.removeAttr('data-clear');
                NioApp.Select2($el, { allowClear: false });
            } else {
                $el.select2(opts);
            }

            cleanupSelect2Duplicates($el);
        });
    }

    function enhanceGroup(group) {
        group.classList.remove('label-floating', 'label-placeholder', 'is-empty', 'is-focused', 'is-filled');

        var labels = group.querySelectorAll('label.control-label, label.form-label');
        Array.prototype.forEach.call(labels, function (label) {
            label.classList.remove('control-label');
            label.classList.add('form-label');
        });

        Array.prototype.forEach.call(group.querySelectorAll('.material-input'), function (node) {
            node.parentNode && node.parentNode.removeChild(node);
        });

        Array.prototype.forEach.call(group.querySelectorAll('select'), enhanceSelect);

        var controls = group.querySelectorAll(CONTROL_SELECTOR);
        Array.prototype.forEach.call(controls, function (control) {
            if (shouldSkip(control) || control.tagName === 'SELECT') {
                return;
            }
            if (!control.classList.contains('form-control')) {
                control.classList.add('form-control');
            }
            control.classList.add('form-control-lg');
            ensureWrap(control);
        });

        Array.prototype.forEach.call(group.querySelectorAll('input[type="file"]'), function (file) {
            if (file.closest('.nk-sidebar, .dataTables_wrapper')) {
                return;
            }
            if (file.classList.contains('coop-file-input') || file.closest('.coop-media-upload')) {
                file.classList.remove('form-control', 'form-control-lg');
                return;
            }
            if (!file.classList.contains('custom-file-input')) {
                file.classList.add('form-control', 'form-control-lg');
            }
        });
    }

    function enhanceAdminForms(root) {
        if (!document.body || !document.body.classList.contains('coop-dashlite')) {
            return;
        }
        root = root || document;

        Array.prototype.forEach.call(root.querySelectorAll('.nice-select'), function (ns) {
            var prev = ns.previousElementSibling;
            if (prev && prev.tagName === 'SELECT') {
                prev.style.display = '';
            }
            ns.parentNode && ns.parentNode.removeChild(ns);
        });

        var groups = root.querySelectorAll('.card .form-group, .card-content .form-group, form .form-group');
        Array.prototype.forEach.call(groups, enhanceGroup);

        var orphans = root.querySelectorAll('.card select, form select, .nk-content select');
        Array.prototype.forEach.call(orphans, function (select) {
            if (!select.closest('.form-group')) {
                enhanceSelect(select);
            }
        });

        var orphanInputs = root.querySelectorAll('.card ' + CONTROL_SELECTOR + ', form ' + CONTROL_SELECTOR + ', .nk-content ' + CONTROL_SELECTOR);
        Array.prototype.forEach.call(orphanInputs, function (control) {
            if (shouldSkip(control) || control.tagName === 'SELECT' || control.closest('.form-group')) {
                return;
            }
            if (!control.classList.contains('form-control')) {
                control.classList.add('form-control');
            }
            control.classList.add('form-control-lg');
            ensureWrap(control);
        });

        initSelect2(root);
    }

    function boot() {
        enhanceAdminForms();
        // One delayed pass for late-rendered forms (modals / AJAX partials)
        setTimeout(enhanceAdminForms, 400);

        document.addEventListener('shown.bs.modal', function (e) {
            if (e.target) {
                enhanceAdminForms(e.target);
            }
        });
        if (window.jQuery) {
            jQuery(document).on('shown.bs.modal', function (e) {
                enhanceAdminForms(e.target);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.coopEnhanceAdminForms = enhanceAdminForms;
})();
