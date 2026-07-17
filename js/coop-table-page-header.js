/**
 * Transform legacy card+table list pages into DashLite project-list header layout:
 *   .container-fluid > .nk-block-head.nk-block-head-sm > .nk-block-between
 *     left: title + "You have total N..."
 *     right: action tools (Add button when known)
 */
(function () {
    var ADD_ROUTES = {
        'user/allusers': { href: 'dashboard/user/adduser', label: 'Add User' },
        'user': { href: 'dashboard/user/adduser', label: 'Add User' },
        'member/allmembers': { href: 'dashboard/member/addmember', label: 'Add Member' },
        'member': { href: 'dashboard/member/addmember', label: 'Add Member' },
        'event/allevents': { href: 'dashboard/event/addevent', label: 'Add Event' },
        'event': { href: 'dashboard/event/addevent', label: 'Add Event' },
        'notice/allnotices': { href: 'dashboard/notice/addnotice', label: 'Add Notice' },
        'notice': { href: 'dashboard/notice/addnotice', label: 'Add Notice' },
        'speech/allspeech': { href: 'dashboard/speech/addspeech', label: 'Add Speech' },
        'speech': { href: 'dashboard/speech/addspeech', label: 'Add Speech' },
        'department/alldepartment': { href: 'dashboard/department/adddepartment', label: 'Add Department' },
        'department': { href: 'dashboard/department/adddepartment', label: 'Add Department' },
        'committee/allcommittee': { href: 'dashboard/committee/addcommittee', label: 'Add Committee' },
        'committee': { href: 'dashboard/committee/addcommittee', label: 'Add Committee' },
        'staff/allstaffs': { href: 'dashboard/staff/addstaff', label: 'Add Staff' },
        'staff': { href: 'dashboard/staff/addstaff', label: 'Add Staff' },
        'seminar/allseminar': { href: 'dashboard/seminar/addseminar', label: 'Add Seminar' },
        'seminar': { href: 'dashboard/seminar/addseminar', label: 'Add Seminar' },
        'board_of_directors/allboard_of_directors': { href: 'dashboard/board_of_directors/addboard_of_directors', label: 'Add Director' },
        'board_of_directors': { href: 'dashboard/board_of_directors/addboard_of_directors', label: 'Add Director' },
        'cooperative_officers/allcooperative_officers': { href: 'dashboard/cooperative_officers/addcooperative_officers', label: 'Add Officer' },
        'cooperative_officers': { href: 'dashboard/cooperative_officers/addcooperative_officers', label: 'Add Officer' },
        'clan/allclan': { href: 'dashboard/clan/addclan', label: 'Add Clan' },
        'clan': { href: 'dashboard/clan/addclan', label: 'Add Clan' },
        'chorus/allchorus': { href: 'dashboard/chorus/addchorus', label: 'Add Chorus' },
        'chorus': { href: 'dashboard/chorus/addchorus', label: 'Add Chorus' },
        'pastor/allpastor': { href: 'dashboard/pastor/addpastor', label: 'Add Pastor' },
        'pastor': { href: 'dashboard/pastor/addpastor', label: 'Add Pastor' },
        'school/allstudents': { href: 'dashboard/school/addstudent', label: 'Add Student' },
        'school': { href: 'dashboard/school/addstudent', label: 'Add Student' },
        'sermon/allsermons': { href: 'dashboard/sermon/addsermon', label: 'Add Sermon' },
        'sermon': { href: 'dashboard/sermon/addsermon', label: 'Add Sermon' },
        'prayer/allprayers': { href: 'dashboard/prayer/addprayer', label: 'Add Prayer' },
        'prayer': { href: 'dashboard/prayer/addprayer', label: 'Add Prayer' },
        'website/slider': { href: '#', label: 'Add Slider', modal: '#addSliderModal' },
        'website/gallery': { href: '#', label: 'Add Gallery', modal: '#addGalleryModal' },
        'menu': { href: '#', label: 'Add Menu', modal: '#addMenuModal' },
        'section': { href: '#', label: 'Add Section', modal: '#addSectionModal' },
        'page': { href: 'dashboard/page/addpage', label: 'Add Page' },
        'attendance': { href: 'dashboard/attendance/addtype', label: 'Add Type' },
        'funds': { href: 'dashboard/funds/addfunds', label: 'Add Funds' },
        'rolesetup': { href: null, label: null }
    };

    function baseUrl() {
        return (typeof window.baseurl === 'string' && window.baseurl) ? window.baseurl : '/';
    }

    function cleanText(str) {
        return String(str || '').replace(/\s+/g, ' ').trim();
    }

    function stripIcons(el) {
        if (!el) {
            return '';
        }
        var clone = el.cloneNode(true);
        Array.prototype.forEach.call(clone.querySelectorAll('i, em, .material-icons, .icon'), function (n) {
            n.parentNode && n.parentNode.removeChild(n);
        });
        return cleanText(clone.textContent);
    }

    function parseTitle(raw) {
        var title = cleanText(raw);
        var total = null;
        var m = title.match(/^(.*?)(?:\s*[\(\[]\s*(\d+)\s*[\)\]])?\s*$/);
        if (m) {
            title = cleanText(m[1]) || title;
            if (m[2]) {
                total = m[2];
            }
        }
        return { title: title, total: total };
    }

    function resolveAddAction() {
        var path = (window.location.pathname || '').replace(/\\/g, '/').toLowerCase();
        var parts = path.split('/').filter(Boolean);
        // expect .../dashboard/{controller}/{method}
        var dashIdx = parts.indexOf('dashboard');
        if (dashIdx < 0) {
            return null;
        }
        var controller = parts[dashIdx + 1] || '';
        var method = parts[dashIdx + 2] || '';
        var key = method ? (controller + '/' + method) : controller;
        if (ADD_ROUTES[key]) {
            return ADD_ROUTES[key];
        }
        if (ADD_ROUTES[controller]) {
            return ADD_ROUTES[controller];
        }
        return null;
    }

    function findExistingAddLink(card) {
        var scope = card.closest('.content') || document;
        var links = scope.querySelectorAll('a.btn, a[href*="add"], button[data-toggle="modal"], a[data-toggle="modal"], a[data-bs-toggle="modal"]');
        for (var i = 0; i < links.length; i++) {
            var a = links[i];
            if (a.closest('table, .tb-tnx-actions, .dropdown-menu')) {
                continue;
            }
            var text = cleanText(a.textContent).toLowerCase();
            var href = (a.getAttribute('href') || '').toLowerCase();
            if (
                text.indexOf('add') !== -1 ||
                href.indexOf('/add') !== -1 ||
                a.getAttribute('data-target') ||
                a.getAttribute('data-bs-target')
            ) {
                return a;
            }
        }
        return null;
    }

    function buildTools(addAction, existingAdd) {
        var toolsWrap = document.createElement('div');
        toolsWrap.className = 'nk-block-head-content';

        var toggleWrap = document.createElement('div');
        toggleWrap.className = 'toggle-wrap nk-block-tools-toggle';

        var toolsInner = document.createElement('div');
        toolsInner.className = 'toggle-expand-content';
        toolsInner.setAttribute('data-content', 'pageMenu');

        var ul = document.createElement('ul');
        ul.className = 'nk-block-tools g-3';

        var li = document.createElement('li');
        li.className = 'nk-block-tools-opt';

        var btn = document.createElement('a');
        btn.className = 'btn btn-primary';

        if (existingAdd) {
            btn.href = existingAdd.getAttribute('href') || '#';
            var label = stripIcons(existingAdd) || 'Add';
            var dt = existingAdd.getAttribute('data-target') || existingAdd.getAttribute('data-bs-target');
            if (dt) {
                btn.setAttribute('data-bs-toggle', 'modal');
                btn.setAttribute('data-toggle', 'modal');
                btn.setAttribute('data-target', dt);
                btn.setAttribute('data-bs-target', dt);
                btn.href = '#';
            }
            // Hide original add control to avoid duplicate buttons
            existingAdd.style.display = 'none';
            btn.innerHTML = '<em class="icon ni ni-plus"></em><span>' + label + '</span>';
        } else if (addAction && addAction.label) {
            if (addAction.modal) {
                btn.href = '#';
                btn.setAttribute('data-bs-toggle', 'modal');
                btn.setAttribute('data-toggle', 'modal');
                btn.setAttribute('data-target', addAction.modal);
                btn.setAttribute('data-bs-target', addAction.modal);
            } else if (addAction.href) {
                btn.href = baseUrl().replace(/\/?$/, '/') + addAction.href.replace(/^\//, '');
            } else {
                return null;
            }
            btn.innerHTML = '<em class="icon ni ni-plus"></em><span>' + addAction.label + '</span>';
        } else {
            return null;
        }

        li.appendChild(btn);
        ul.appendChild(li);
        toolsInner.appendChild(ul);
        toggleWrap.appendChild(toolsInner);
        toolsWrap.appendChild(toggleWrap);
        return toolsWrap;
    }

    function transformCard(card) {
        if (!card || card.dataset.nkHeadReady === '1') {
            return;
        }
        if (card.closest('.nk-sidebar')) {
            return;
        }

        var table = card.querySelector('table');
        if (!table) {
            return;
        }

        var header = card.querySelector('.card-header');
        if (!header) {
            return;
        }

        var titleEl = header.querySelector('.title, h4, h3, h2');
        var catEl = header.querySelector('.category, p');
        if (!titleEl) {
            return;
        }

        var parsed = parseTitle(stripIcons(titleEl));
        var subtitle = catEl ? cleanText(catEl.textContent) : '';
        if (parsed.total && !/total/i.test(subtitle)) {
            subtitle = 'You have total ' + parsed.total + (subtitle ? '. ' + subtitle : '.');
        } else if (!subtitle && parsed.total) {
            subtitle = 'You have total ' + parsed.total + '.';
        }

        var blockHead = document.createElement('div');
        blockHead.className = 'nk-block-head nk-block-head-sm coop-table-block-head';

        var between = document.createElement('div');
        between.className = 'nk-block-between g-3';

        var left = document.createElement('div');
        left.className = 'nk-block-head-content';
        left.innerHTML =
            '<h3 class="nk-block-title page-title"></h3>' +
            (subtitle ? '<div class="nk-block-des text-soft"><p></p></div>' : '');
        left.querySelector('.nk-block-title').textContent = parsed.title || 'Listing';
        if (subtitle) {
            left.querySelector('.nk-block-des p').textContent = subtitle;
        }

        between.appendChild(left);

        var existingAdd = findExistingAddLink(card);
        var tools = buildTools(resolveAddAction(), existingAdd);
        if (tools) {
            between.appendChild(tools);
        }

        blockHead.appendChild(between);

        // Insert header before the card, restyle card as content block
        card.parentNode.insertBefore(blockHead, card);
        header.style.display = 'none';
        card.classList.add('card-bordered', 'coop-table-card');
        card.dataset.nkHeadReady = '1';

        // Ensure outer content uses fluid container feel
        var content = card.closest('.content');
        if (content) {
            content.classList.add('coop-table-page');
            var fluid = content.querySelector(':scope > .container-fluid, :scope > .container-xl, :scope > .container');
            if (fluid) {
                fluid.classList.add('container-fluid');
            }
        }
    }

    function enhanceTablePageHeaders(root) {
        if (!document.body || !document.body.classList.contains('coop-dashlite')) {
            return;
        }
        root = root || document;
        var cards = root.querySelectorAll('.content .card, .nk-content .card');
        Array.prototype.forEach.call(cards, function (card) {
            if (card.querySelector('table') && card.querySelector('.card-header')) {
                transformCard(card);
            }
        });
    }

    function boot() {
        enhanceTablePageHeaders();
        setTimeout(enhanceTablePageHeaders, 300);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }

    window.coopEnhanceTablePageHeaders = enhanceTablePageHeaders;
})();
