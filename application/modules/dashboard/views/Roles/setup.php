<?php
$roleClassMap = array(
    'Super Admin' => 'role-level-super-admin',
    'Admin' => 'role-level-admin',
    'Manager' => 'role-level-manager',
    'Staff' => 'role-level-staff',
    'Viewer' => 'role-level-viewer',
);
$roleSummaryMap = array(
    'Super Admin' => 'Full access: users, roles, backups, website, reports',
    'Admin' => 'Admin access: users, backups, website, reports',
    'Manager' => 'Operations access: finance, members, events, reports',
    'Staff' => 'Execution access: members, events, notices, reports',
    'Viewer' => 'Read-only access: reports and dashboard overview',
);
?>

<div class="content">
    <div class="container-fluid">

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">admin_panel_settings</i> Users and Roles Setup</h4>
                        <p class="category">Simple role model: Super Admin, Admin, Manager, Staff, Viewer</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Total Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($roleStats as $item) { ?>
                                    <tr>
                                        <td>
                                            <span class="role-chip-badge role-matrix-badge <?php echo isset($roleClassMap[$item->position]) ? $roleClassMap[$item->position] : 'role-level-viewer'; ?>">
                                                <?php echo $item->position; ?>
                                            </span>
                                        </td>
                                        <td><?php echo (int) $item->total; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">groups</i> Assign Roles</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="role-legend-wrap">
                            <span class="role-legend-label">Role Color Legend:</span>
                            <span class="role-chip-badge role-matrix-badge role-level-super-admin">Super Admin</span>
                            <span class="role-chip-badge role-matrix-badge role-level-admin">Admin</span>
                            <span class="role-chip-badge role-matrix-badge role-level-manager">Manager</span>
                            <span class="role-chip-badge role-matrix-badge role-level-staff">Staff</span>
                            <span class="role-chip-badge role-matrix-badge role-level-viewer">Viewer</span>
                        </div>

                        <form method="get" action="<?php echo base_url('dashboard/rolesetup'); ?>" class="role-filter-bar">
                            <div class="role-filter-field">
                                <label>Name</label>
                                <input type="text" name="q" class="form-control" placeholder="Search name" value="<?php echo htmlspecialchars($filters['q'], ENT_QUOTES); ?>">
                            </div>
                            <div class="role-filter-field">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Search email" value="<?php echo htmlspecialchars($filters['email'], ENT_QUOTES); ?>">
                            </div>
                            <div class="role-filter-field">
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="">All Roles</option>
                                    <?php foreach ($roles as $role) { ?>
                                        <option value="<?php echo $role; ?>" <?php echo ($filters['role'] === $role) ? 'selected' : ''; ?>><?php echo $role; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="role-filter-actions">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="material-icons">search</i> Filter
                                </button>
                                <a href="<?php echo base_url('dashboard/rolesetup'); ?>" class="btn btn-default btn-sm">
                                    <i class="material-icons">clear</i> Clear
                                </a>
                            </div>
                        </form>

                        <p class="role-result-count">
                            <?php if ($totalUsers > 0) { ?>
                                Showing <?php echo (int) $showingFrom; ?>&ndash;<?php echo (int) $showingTo; ?> of <?php echo (int) $totalUsers; ?> users
                            <?php } else { ?>
                                No users match the current filters.
                            <?php } ?>
                        </p>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Current Role</th>
                                    <th>Last Changed By</th>
                                    <th>Last Changed At</th>
                                    <th>Change Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) {
                                    $lastChange = isset($roleChanges[(int) $user->userid]) ? $roleChanges[(int) $user->userid] : null;
                                ?>
                                    <tr>
                                        <td><?php echo $user->fname . ' ' . $user->lname; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td>
                                            <span class="role-chip-badge role-matrix-badge <?php echo isset($roleClassMap[$user->position]) ? $roleClassMap[$user->position] : 'role-level-viewer'; ?>">
                                                <?php echo $user->position; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($lastChange && $lastChange['changed_by'] !== '') { ?>
                                                <?php echo htmlspecialchars($lastChange['changed_by'], ENT_QUOTES); ?>
                                            <?php } else { ?>
                                                <span class="role-audit-empty">Never</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($lastChange && $lastChange['changed_at'] !== '') { ?>
                                                <?php echo htmlspecialchars($lastChange['changed_at'], ENT_QUOTES); ?>
                                            <?php } else { ?>
                                                <span class="role-audit-empty">&mdash;</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <form method="post" action="<?php echo base_url('dashboard/rolesetup/update'); ?>" class="form-inline">
                                                <input type="hidden" name="userid" value="<?php echo (int) $user->userid; ?>">
                                                <input type="hidden" name="return_filters[q]" value="<?php echo htmlspecialchars($filters['q'], ENT_QUOTES); ?>">
                                                <input type="hidden" name="return_filters[email]" value="<?php echo htmlspecialchars($filters['email'], ENT_QUOTES); ?>">
                                                <input type="hidden" name="return_filters[role]" value="<?php echo htmlspecialchars($filters['role'], ENT_QUOTES); ?>">
                                                <select name="position" class="form-control role-select" data-original-role="<?php echo $user->position; ?>" required>
                                                    <?php foreach ($roles as $role) { ?>
                                                        <option value="<?php echo $role; ?>" <?php echo ($role === $user->position) ? 'selected' : ''; ?>><?php echo $role; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="material-icons">save</i> Save
                                                </button>
                                                <span class="role-help-text"><?php echo isset($roleSummaryMap[$user->position]) ? $roleSummaryMap[$user->position] : $roleSummaryMap['Viewer']; ?></span>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (empty($users)) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center role-audit-empty">No users found.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <?php if (!empty($pagination)) { ?>
                            <div class="role-pagination-wrap"><?php echo $pagination; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">rule</i> Role Capability Matrix</h4>
                        <p class="category">Reference of what each role can access in this release.</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th><span class="role-chip-badge role-matrix-badge role-level-super-admin">Super Admin</span></th>
                                    <th><span class="role-chip-badge role-matrix-badge role-level-admin">Admin</span></th>
                                    <th><span class="role-chip-badge role-matrix-badge role-level-manager">Manager</span></th>
                                    <th><span class="role-chip-badge role-matrix-badge role-level-staff">Staff</span></th>
                                    <th><span class="role-chip-badge role-matrix-badge role-level-viewer">Viewer</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($capabilityMatrix as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['module']; ?></td>
                                        <td><?php echo $row['Super Admin']; ?></td>
                                        <td><?php echo $row['Admin']; ?></td>
                                        <td><?php echo $row['Manager']; ?></td>
                                        <td><?php echo $row['Staff']; ?></td>
                                        <td><?php echo $row['Viewer']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var roleSummaryMap = {
            "Super Admin": "Full access: users, roles, backups, website, reports",
            "Admin": "Admin access: users, backups, website, reports",
            "Manager": "Operations access: finance, members, events, reports",
            "Staff": "Execution access: members, events, notices, reports",
            "Viewer": "Read-only access: reports and dashboard overview"
        };

        var selects = document.querySelectorAll('.role-select');
        if (!selects.length) {
            return;
        }

        for (var i = 0; i < selects.length; i++) {
            (function (selectEl) {
                var form = selectEl.closest('form');
                var helpText = form ? form.querySelector('.role-help-text') : null;
                var originalRole = selectEl.getAttribute('data-original-role') || selectEl.value;

                var renderPreview = function () {
                    var selectedRole = selectEl.value;
                    if (helpText) {
                        helpText.textContent = roleSummaryMap[selectedRole] || roleSummaryMap['Viewer'];
                    }
                    if (selectedRole !== originalRole) {
                        selectEl.classList.add('role-pending-change');
                    } else {
                        selectEl.classList.remove('role-pending-change');
                    }
                };

                renderPreview();
                selectEl.addEventListener('change', renderPreview);

                if (form) {
                    form.addEventListener('submit', function (event) {
                        if (selectEl.value === originalRole) {
                            event.preventDefault();
                            alert('No role change detected for this user.');
                            return false;
                        }
                        return true;
                    });
                }
            })(selects[i]);
        }
    })();
</script>
