<div class="content gusers">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">mail</i> <?php echo $this->lang->line('dash_allinquiry_panel_title'); ?> ( <?php echo (int) $counts['all']; ?> )</h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newinquiry'); ?> <?php echo getCreateDate('inquiryid', 'inquiry'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-12">
                                <form action="<?php echo base_url('dashboard/inquiry/fetchinbound'); ?>" method="post" style="display:inline-block;margin-right:8px;">
                                    <input type="hidden" name="redirect" value="dashboard/inquiry/allinquiries<?php echo $filter_status ? '?status=' . urlencode($filter_status) : ''; ?>">
                                    <button type="submit" class="btn btn-sm btn-info">
                                        <i class="material-icons" style="font-size:16px;vertical-align:middle;">sync</i>
                                        <?php echo $this->lang->line('dash_gpanel_fetch_email_replies'); ?>
                                    </button>
                                </form>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries'); ?>" class="btn btn-sm <?php echo empty($filter_status) ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_all'); ?> (<?php echo (int) $counts['all']; ?>)
                                </a>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries?status=new'); ?>" class="btn btn-sm <?php echo $filter_status === 'new' ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_status_new'); ?> (<?php echo (int) $counts['new']; ?>)
                                </a>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries?status=guest_replied'); ?>" class="btn btn-sm <?php echo $filter_status === 'guest_replied' ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_status_guest_replied'); ?> (<?php echo (int) $counts['guest_replied']; ?>)
                                </a>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries?status=read'); ?>" class="btn btn-sm <?php echo $filter_status === 'read' ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_status_read'); ?> (<?php echo (int) $counts['read']; ?>)
                                </a>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries?status=replied'); ?>" class="btn btn-sm <?php echo $filter_status === 'replied' ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_status_replied'); ?> (<?php echo (int) $counts['replied']; ?>)
                                </a>
                                <a href="<?php echo base_url('dashboard/inquiry/allinquiries?status=closed'); ?>" class="btn btn-sm <?php echo $filter_status === 'closed' ? 'btn-primary' : 'btn-default'; ?>">
                                    <?php echo $this->lang->line('dash_gpanel_status_closed'); ?> (<?php echo (int) $counts['closed']; ?>)
                                </a>
                            </div>
                        </div>

                        <table class="dtInquiry table table-hover">
                            <thead class="text-default">
                                <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_name'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_email'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_subject'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_status'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($inquiries as $row) {
                                    $i++;
                                    $statusStyle = 'background:#8091a7;color:#fff;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    if ($row->status === 'new') {
                                        $statusStyle = 'background:#e85347;color:#fff;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    } elseif ($row->status === 'guest_replied') {
                                        $statusStyle = 'background:#7e57c2;color:#fff;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    } elseif ($row->status === 'read') {
                                        $statusStyle = 'background:#f4bd0e;color:#1f2b3a;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    } elseif ($row->status === 'replied') {
                                        $statusStyle = 'background:#1ee0ac;color:#1f2b3a;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    } elseif ($row->status === 'closed') {
                                        $statusStyle = 'background:#09c2de;color:#fff;padding:3px 8px;border-radius:3px;font-size:12px;';
                                    }
                                    ?>
                                    <tr<?php echo in_array($row->status, array('new', 'guest_replied'), TRUE) ? ' style="font-weight:600;"' : ''; ?>>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo htmlspecialchars($row->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($row->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars(character_limiter($row->subject, 40), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><span style="<?php echo $statusStyle; ?>"><?php echo ucwords(str_replace('_', ' ', $row->status)); ?></span></td>
                                        <td><?php echo !empty($row->created_at) ? date('M j, Y g:i A', strtotime($row->created_at)) : $row->cdate; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/inquiry/view/<?php echo $row->inquiryid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/inquiry/delete/<?php echo $row->inquiryid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
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
