<div class="content gusers">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">people</i> <?php echo $this->lang->line('dash_allcstaffs_panel_title'); ?> ( <?php
                            $this->db->from('staff');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newstaff'); ?> <?php echo getCreateDate('staffid','staff'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtStaff table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_photo'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_name'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_position'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_phone'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_country'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_gender'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($staff as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <img class="committee img" src="<?php echo base_url(); ?>images/<?php if($row->profileimage){ echo "staff/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>">
                                        </td>
                                        <td><?php echo $row->fname . " " . $row->lname; ?></td>
                                        <td><?php echo $row->position; ?></td>
                                        <td><?php echo $row->phone; ?></td>
                                        <td><?php echo $row->country; ?></td>
                                        <td><?php echo $row->gender; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/staff/view/<?php echo $row->staffid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/staff/edit/<?php echo $row->staffid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/staff/delete/<?php echo $row->staffid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
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