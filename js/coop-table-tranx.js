/**
 * Style admin tables like DashLite "Transaction List - With Action"
 * and convert action button cells into a more-h dropdown.
 */
(function () {
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function cleanLabel(text) {
        return String(text || '').replace(/\s+/g, ' ').trim();
    }

    function labelFromLink(link) {
        // Exclude icon ligature text (e.g. Material Icons "add", "clear")
        var clone = link.cloneNode(true);
        Array.prototype.forEach.call(
            clone.querySelectorAll('i, em, .material-icons, .icon'),
            function (icon) {
                icon.parentNode && icon.parentNode.removeChild(icon);
            }
        );
        return cleanLabel(clone.textContent);
    }

    function convertActionCell(td, links) {
        if (td.querySelector('.tb-tnx-actions')) {
            return;
        }

        var items = [];
        Array.prototype.forEach.call(links, function (link) {
            var label = labelFromLink(link);
            if (!label) {
                if (link.classList.contains('btn-danger') || link.classList.contains('delete')) {
                    label = 'Remove';
                } else if (link.classList.contains('btn-warning')) {
                    label = 'Edit';
                } else if (link.classList.contains('btn-primary') || link.classList.contains('btn-success')) {
                    label = 'View';
                } else {
                    label = 'Action';
                }
            }
            items.push({
                href: link.getAttribute('href') || '#',
                label: label,
                isDelete: link.classList.contains('delete') || /delete|remove/i.test(label)
            });
        });

        if (!items.length) {
            return;
        }

        td.classList.add('tb-tnx-action');
        td.innerHTML = '';

        var wrap = document.createElement('div');
        wrap.className = 'dropdown tb-tnx-actions';

        var toggle = document.createElement('a');
        toggle.href = '#';
        toggle.className = 'text-soft dropdown-toggle btn btn-icon btn-trigger';
        toggle.setAttribute('data-bs-toggle', 'dropdown');
        toggle.setAttribute('data-toggle', 'dropdown');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '<em class="icon ni ni-more-h"></em>';
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
        });

        var menu = document.createElement('div');
        menu.className = 'dropdown-menu dropdown-menu-end dropdown-menu-right dropdown-menu-xs';

        var list = document.createElement('ul');
        list.className = 'link-list-plain';

        items.forEach(function (item) {
            var li = document.createElement('li');
            var a = document.createElement('a');
            a.href = item.href;
            a.textContent = item.label;
            if (item.isDelete) {
                a.className = 'delete';
            }
            li.appendChild(a);
            list.appendChild(li);
        });

        menu.appendChild(list);
        wrap.appendChild(toggle);
        wrap.appendChild(menu);
        td.appendChild(wrap);
    }

    function enhanceTable(table) {
        if (!table || table.closest('.nk-sidebar')) {
            return;
        }

        table.classList.add('table-tranx');

        var headRow = table.querySelector('thead tr');
        if (headRow) {
            headRow.classList.add('tb-tnx-head');
            var ths = headRow.children;
            if (ths.length) {
                ths[0].classList.add('tb-tnx-id');
                var lastTh = ths[ths.length - 1];
                if (/action/i.test(cleanLabel(lastTh.textContent)) || ths.length > 1) {
                    lastTh.classList.add('tb-tnx-action');
                }
            }
        }

        var rows = table.querySelectorAll('tbody > tr');
        Array.prototype.forEach.call(rows, function (tr) {
            // Skip empty / DataTables placeholder rows
            if (tr.querySelector('td.dataTables_empty')) {
                return;
            }

            tr.classList.add('tb-tnx-item');
            var tds = tr.children;
            if (!tds.length) {
                return;
            }

            tds[0].classList.add('tb-tnx-id');
            if (!tds[0].querySelector('img, a, span, input, select, button, em') && cleanLabel(tds[0].textContent)) {
                var span = document.createElement('span');
                span.textContent = cleanLabel(tds[0].textContent);
                tds[0].textContent = '';
                tds[0].appendChild(span);
            }

            var last = tds[tds.length - 1];
            if (last.querySelector('.tb-tnx-actions')) {
                last.classList.add('tb-tnx-action');
                return;
            }
            var links = last.querySelectorAll('a.btn, button.btn');
            if (links.length >= 1) {
                convertActionCell(last, links);
            }
        });
    }

    function enhanceAdminTables(root) {
        if (!document.body || !document.body.classList.contains('coop-dashlite')) {
            return;
        }
        root = root || document;
        var tables = root.querySelectorAll('.card .table, .card-content table.table, .dataTables_wrapper table.table');
        Array.prototype.forEach.call(tables, enhanceTable);
    }

    function boot() {
        enhanceAdminTables();
        // DataTables redraws rows — re-apply after draws
        if (window.jQuery) {
            jQuery(document).on('draw.dt', function (e) {
                var table = e.target;
                if (table && table.nodeName === 'TABLE') {
                    enhanceTable(table);
                } else {
                    enhanceAdminTables();
                }
            });
        }
        // Catch late DataTables init
        setTimeout(enhanceAdminTables, 400);
        setTimeout(enhanceAdminTables, 1200);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.coopEnhanceAdminTables = enhanceAdminTables;
})();
