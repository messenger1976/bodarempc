<div class="content gusers">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">notifications_active</i> <?php echo $this->lang->line('dash_allevents_panel_title'); ?> (<?php
                            $this->db->from('event');
                            echo $this->db->count_all_results();
                            ?>)</h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newevent'); ?> <?php echo getCreateDate('eventid','event'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtEvent table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_image'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_time'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_location'); ?></th>
                            <th>Status</th>
                            <th>Publish Window</th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($event as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php if ($row->eventimage) { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>images/event/feature/<?php echo $row->eventimage; ?>">
                                            <?php } else { ?>
                                                <img class="committee img" src="<?php echo base_url(); ?>images/thumb.jpg">
                                            <?php } ?>										
                                        </td>
                                        <td><?php echo $row->eventtitle; ?></td>
                                        <td><?php echo $row->eventdate; ?></td>
                                        <td><?php echo $row->eventtime; ?></td>
                                        <td><?php echo $row->eventlocation; ?></td>
                                        <td>
                                            <?php
                                            $now = time();
                                            $publishStart = strtotime($row->publish_start_at);
                                            $publishEnd = $row->publish_end_at ? strtotime($row->publish_end_at) : NULL;

                                            if ($row->status === 'draft') {
                                                $publicationLabel = 'Draft';
                                                $publicationClass = 'label-default';
                                            } elseif ($publishStart > $now) {
                                                $publicationLabel = 'Scheduled';
                                                $publicationClass = 'label-info';
                                            } elseif ($publishEnd !== NULL && $publishEnd <= $now) {
                                                $publicationLabel = 'Expired';
                                                $publicationClass = 'label-warning';
                                            } else {
                                                $publicationLabel = 'Published';
                                                $publicationClass = 'label-success';
                                            }
                                            ?>
                                            <span class="label <?php echo $publicationClass; ?>"><?php echo $publicationLabel; ?></span>
                                        </td>
                                        <td>
                                            <strong>Start:</strong> <?php echo date('M j, Y g:i A', $publishStart); ?><br>
                                            <strong>End:</strong> <?php echo $publishEnd ? date('M j, Y g:i A', $publishEnd) : 'No ending date'; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/event/view/<?php echo $row->eventid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/event/edit/<?php echo $row->eventid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/event/delete/<?php echo $row->eventid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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