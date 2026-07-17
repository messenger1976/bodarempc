<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-bs-toggle="modal" data-target="#addPageModal" style="margin-top: -2px;"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_addpage_panel_title'); ?></a>
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allpages_panel_title'); ?> ( <?php
                            $this->db->from('page');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newpage'); ?> <?php echo getCreateDate('pageid','page'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_page_table">
                            <thead class="text-default">
                            <th  style="width:5%" ><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width:10%"><?php echo $this->lang->line('dash_gpanel_pagetitle'); ?></th>
                            <th style="width:10%"><?php echo $this->lang->line('dash_gpanel_pageslug'); ?></th>
                            <th style="width:40%"><?php echo $this->lang->line('dash_gpanel_pagecontent'); ?></th>
                            <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;
                                foreach ($pages as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->pagetitle; ?></td>
                                        <td><?php echo $row->pageslug; ?></td>
                                        <td><?php echo word_limiter(strip_tags($row->pagecontent), 20); ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/page/edit/<?php echo $row->pageid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/page/delete/<?php echo $row->pageid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Page Modal -->
                <div class="modal fade" id="addPageModal" tabindex="-1" role="dialog" aria-labelledby="addPageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addPageModalLabel"><i class="material-icons">note_add</i> <?php echo $this->lang->line('dash_addpage_panel_title'); ?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 360px;">
                                <form id="webPageAddForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/page/add" method="post">
                                    <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagetitle'); ?> (*)</label>
                                        <input id="title" name="title" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pageslug'); ?> (*)</label>
                                        <input id="slug" name="slug" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pagecontent'); ?></label>
                                        <textarea id="pagecontent" name="content" class="form-control" rows="6"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                                <button id="webPageAddSubmit" type="button" class="btn btn-primary"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_addpage_panel_title'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>