<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">assessment</i> Analytics Reports</h4>
                        <p class="category">Financial, Membership, Compliance, and Cooperative Service Insights</p>
                    </div>
                    <div class="card-content">
                        <form class="form-inline" method="get" action="<?php echo base_url('dashboard/dashboard/reports'); ?>">
                            <div class="form-group">
                                <label for="year">Year:&nbsp;</label>
                                <input type="number" min="2000" max="2100" name="year" id="year" class="form-control" value="<?php echo (int) $report_year; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="material-icons">filter_list</i> Apply</button>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('dashboard/dashboard/reportsCsv?year=' . (int) $report_year); ?>">
                                <i class="material-icons">download</i> Export CSV
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green"><i class="material-icons">trending_up</i></div>
                    <div class="card-content">
                        <p class="category">Total Collections</p>
                        <h3 class="title"><?php echo globalCurrency() . number_format($kpi_collect_total, 2); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange"><i class="material-icons">trending_down</i></div>
                    <div class="card-content">
                        <p class="category">Total Spending</p>
                        <h3 class="title"><?php echo globalCurrency() . number_format($kpi_spend_total, 2); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue"><i class="material-icons">account_balance_wallet</i></div>
                    <div class="card-content">
                        <p class="category">Net Balance</p>
                        <h3 class="title"><?php echo globalCurrency() . number_format($kpi_balance_total, 2); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="purple"><i class="material-icons">groups</i></div>
                    <div class="card-content">
                        <p class="category">Total Members</p>
                        <h3 class="title"><?php echo (int) $kpi_member_total; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">show_chart</i> Financial Trend (<?php echo (int) $report_year; ?>)</h4>
                    </div>
                    <div class="card-content">
                        <div id="reportFinancialChart" class="ct-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">insights</i> Membership Growth by Month</h4>
                    </div>
                    <div class="card-content">
                        <div id="reportMemberChart" class="ct-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">storefront</i> Cooperative Products/Services Analysis</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Service Area</th>
                                    <th>Total Records</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Events</td><td><?php echo (int) $services_stats['events']; ?></td></tr>
                                <tr><td>Seminars</td><td><?php echo (int) $services_stats['seminars']; ?></td></tr>
                                <tr><td>Seminar Applicants</td><td><?php echo (int) $services_stats['applicants']; ?></td></tr>
                                <tr><td>Prayers</td><td><?php echo (int) $services_stats['prayers']; ?></td></tr>
                                <tr><td>Notices</td><td><?php echo (int) $services_stats['notices']; ?></td></tr>
                                <tr><td>Speeches</td><td><?php echo (int) $services_stats['speeches']; ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">verified_user</i> Compliance and Role Distribution</h4>
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
                                <?php foreach ($role_stats as $roleItem) { ?>
                                    <tr>
                                        <td><?php echo $roleItem->position; ?></td>
                                        <td><?php echo (int) $roleItem->total; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">receipt_long</i> Latest Funds Activity</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_funds as $item) { ?>
                                    <tr>
                                        <td><?php echo isset($item->fundsdate) ? $item->fundsdate : '-'; ?></td>
                                        <td><?php echo isset($item->fundstype) ? $item->fundstype : '-'; ?></td>
                                        <td><?php echo globalCurrency() . number_format((float) (isset($item->fundsamount) ? $item->fundsamount : 0), 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">volunteer_activism</i> Latest Donations</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Source</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_donations as $item) { ?>
                                    <tr>
                                        <td><?php echo isset($item->donationdate) ? $item->donationdate : '-'; ?></td>
                                        <td><?php echo isset($item->donationsource) ? $item->donationsource : '-'; ?></td>
                                        <td><?php echo globalCurrency() . number_format((float) (isset($item->donationamount) ? $item->donationamount : 0), 2); ?></td>
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
window.addEventListener('load', function () {
    if (typeof Chartist === 'undefined') {
        return;
    }

    Chartist.Line('#reportFinancialChart', {
        labels: <?php echo json_encode($month_labels); ?>,
        series: [
            <?php echo json_encode($collect_series); ?>,
            <?php echo json_encode($spend_series); ?>
        ]
    }, {
        fullWidth: true,
        chartPadding: { right: 30 }
    });

    Chartist.Bar('#reportMemberChart', {
        labels: <?php echo json_encode($month_labels); ?>,
        series: [<?php echo json_encode($member_growth_series); ?>]
    }, {
        axisY: { onlyInteger: true },
        height: '250px'
    });
});
</script>
