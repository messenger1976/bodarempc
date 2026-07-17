<?php
$user_position = $this->session->userdata('user_position');
if ($user_position == 'Super Admin') {
    $user_position = 'Admin';
}
$role_label = $this->session->userdata('user_position') ? $this->session->userdata('user_position') : 'Viewer';
?>
<div class="content">
    <div class="container-fluid">

        <div class="coop-page-hero">
            <div>
                <h2>Cooperative Dashboard</h2>
                <p>Welcome back. You are signed in as <strong><?php echo htmlspecialchars($role_label, ENT_QUOTES); ?></strong>.</p>
            </div>
            <div class="coop-actions">
                <a href="<?php echo base_url('dashboard/dashboard/reports'); ?>" class="btn btn-primary btn-sm">
                    <i class="material-icons">assessment</i> Analytics Reports
                </a>
            </div>
        </div>

        <?php if ($user_position == "Admin") { ?>

        <div class="coop-kpi-grid">
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">group</i></span>
                <span class="kpi-label"><?php echo $this->lang->line('dash_total_user'); ?></span>
                <span class="kpi-value"><?php echo (int) $user; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">diversity_3</i></span>
                <span class="kpi-label"><?php echo $this->lang->line('dash_total_committee'); ?></span>
                <span class="kpi-value"><?php echo (int) $committee; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">groups</i></span>
                <span class="kpi-label"><?php echo $this->lang->line('dash_total_member'); ?></span>
                <span class="kpi-value"><?php echo (int) $member; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">account_balance_wallet</i></span>
                <span class="kpi-label">Net Balance</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) ($fundsCollect - $fundsSpend), 2); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <div class="gIconColor card-header card-header-icon" data-background-color="blue">
                        <i class="material-icons">timeline</i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title"><?php echo $this->lang->line('dash_finchart'); ?></h4>
                    </div>
                    <div id="simpleBarChart" class="ct-chart"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">dashboard</i> Administration Quick Actions</h4>
                    </div>
                    <div class="card-content coop-actions">
                        <a href="<?php echo base_url('dashboard/dashboard/reports'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">assessment</i> Analytics Reports</a>
                        <a href="<?php echo base_url('dashboard/rolesetup'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">admin_panel_settings</i> Roles Setup</a>
                        <a href="<?php echo base_url('dashboard/setting/backup'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">backup</i> Backup Settings</a>
                        <a href="<?php echo base_url('dashboard/user/allusers'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">people</i> Manage Users</a>
                    </div>
                </div>
            </div>
        </div>

        <?php } elseif ($user_position == "Manager") { ?>

        <div class="coop-kpi-grid">
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">groups</i></span>
                <span class="kpi-label">Total Members</span>
                <span class="kpi-value"><?php echo (int) $member; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">badge</i></span>
                <span class="kpi-label">Total Staff</span>
                <span class="kpi-value"><?php echo (int) $staff; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">account_balance_wallet</i></span>
                <span class="kpi-label">Total Collections</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) $fundsCollect, 2); ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">payments</i></span>
                <span class="kpi-label">Monthly Spend</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) $mFundsSpend, 2); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">insights</i> Manager Quick Actions</h4>
                    </div>
                    <div class="card-content coop-actions">
                        <a href="<?php echo base_url('dashboard/dashboard/reports'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">assessment</i> View Reports</a>
                        <a href="<?php echo base_url('dashboard/member/allmembers'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">groups</i> Members</a>
                        <a href="<?php echo base_url('dashboard/event/allevents'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">event</i> Events</a>
                        <a href="<?php echo base_url('dashboard/notice/allnotices'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">campaign</i> Notices</a>
                    </div>
                </div>
            </div>
        </div>

        <?php } elseif ($user_position == "Staff") { ?>

        <div class="coop-kpi-grid">
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">groups</i></span>
                <span class="kpi-label">Total Members</span>
                <span class="kpi-value"><?php echo (int) $member; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">event_note</i></span>
                <span class="kpi-label">Monthly Collection</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) $mFundsCollect, 2); ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">favorite</i></span>
                <span class="kpi-label">Monthly Donations</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) $mDonation, 2); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">bolt</i> Staff Quick Actions</h4>
                    </div>
                    <div class="card-content coop-actions">
                        <a href="<?php echo base_url('dashboard/member/addmember'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">person_add</i> Add Member</a>
                        <a href="<?php echo base_url('dashboard/event/addevent'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">event</i> Add Event</a>
                        <a href="<?php echo base_url('dashboard/notice/addnotice'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">campaign</i> Add Notice</a>
                        <a href="<?php echo base_url('dashboard/dashboard/reports'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">assessment</i> Reports</a>
                    </div>
                </div>
            </div>
        </div>

        <?php } else { ?>

        <div class="coop-kpi-grid">
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">visibility</i></span>
                <span class="kpi-label">Reports Access</span>
                <span class="kpi-value" style="font-size:22px;">Enabled</span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">groups</i></span>
                <span class="kpi-label">Total Members</span>
                <span class="kpi-value"><?php echo (int) $member; ?></span>
            </div>
            <div class="coop-kpi">
                <span class="kpi-icon"><i class="material-icons">account_balance_wallet</i></span>
                <span class="kpi-label">Current Balance</span>
                <span class="kpi-value" style="font-size:20px;"><?php echo globalCurrency(); ?><?php echo number_format((float) ($fundsCollect - $fundsSpend), 2); ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">info</i> Viewer Overview</h4>
                    </div>
                    <div class="card-content">
                        <p style="margin:0;color:#64748b;">You have read-only access. Open Analytics Reports for cooperative trends and summaries.</p>
                        <div class="coop-actions" style="margin-top:12px;">
                            <a href="<?php echo base_url('dashboard/dashboard/reports'); ?>" class="btn btn-primary btn-sm"><i class="material-icons">assessment</i> Open Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>
    </div>
</div>
