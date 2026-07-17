<div class="content">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-bs-toggle="modal" data-target="#addSectionModal" style="margin-top: -2px;"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_addsection_panel_title'); ?></a>
                        <h4 class="title"><i class="material-icons">line_style</i> <?php echo $this->lang->line('dash_allsection_panel_title'); ?> ( <?php
                        $this->db->from('section');
                        echo $this->db->count_all_results();
                        ?> ) </h4>
                    <p class="category"><?php echo $this->lang->line('dash_gpanel_newsection'); ?>  <?php echo getCreateDate('sectionid','section'); ?></p>
                </div>
                <div class="card-content table-responsive">
                    <table class="table table-hover sorted_table">
                        <thead class="text-default">
                        <th style="width:5%" ><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_subtitle'); ?></th>
                        <th style="width:30%"><?php echo $this->lang->line('dash_gpanel_content'); ?></th>
                        <th style="width:5%"><?php echo 'Status'; ?></th>
                        <th style="width:20%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                        </thead>
                        <tbody>

                            <?php
                            $i = 0;
                            foreach ($section as $row) {
                                $i++;
                                ?>
                            
                                <tr data-id="<?php echo $row->sectionid; ?>">
                                    <td><?php echo $i; ?></td>                                        
                                    <td><?php echo $row->title; ?></td>  
                                    <td><?php echo $row->subtitle; ?></td>                                  
                                    <td><?php echo word_limiter(strip_tags($row->content), 20); ?></td>
                                    <td><?php echo $row->status==1?'Enabled':'Disabled'; ?></td>   
                                    <td>
                                        <a href="<?php echo base_url(); ?>dashboard/section/edit/<?php echo $row->sectionid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                        <a href="<?php echo base_url(); ?>dashboard/section/delete/<?php echo $row->sectionid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

                <!-- Add Section Modal -->
                <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addSectionModalLabel"><i class="material-icons">line_style</i> <?php echo $this->lang->line('dash_addsection_panel_title'); ?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 520px;">
                                <form id="addSectionForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/section/addnewsection" method="post" enctype="multipart/form-data">
                                    <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>images/upload.png);">
                                                <img id="image" src="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group label-floating">
                                                <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_sbi'); ?></p>
                                                <input type="file" onchange="sectionbanner()" name="profileimage" id="profileimage">
                                                <input type="hidden" name="x" id="x">
                                                <input type="hidden" name="y" id="y">
                                                <input type="hidden" name="width" id="width">
                                                <input type="hidden" name="height" id="height">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                                <input type="text" id="title" name="title" class="form-control" required>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo 'Sub-title'; ?></label>
                                                <input type="text" id="subtitle" name="subtitle" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_removebackground'); ?></label>
                                                <select class="select form-control" id="removebackground" name="removebackground">
                                                    <option value=""><?php echo $this->lang->line('dash_gpanel_removebackground'); ?></option>
                                                    <option value="Delete">Yes</option>
                                                    <option value="Keep">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_status'); ?></label>
                                                <select class="select form-control" id="selectstatus" name="selectstatus" required>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_shortcode'); ?></label>
                                                <input type="text" id="shortcode" name="shortcode" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_shortcode'); ?></label>
                                                <select class="select form-control" id="selectshortcode" name="selectshortcode">
                                                    <option value=""><?php echo $this->lang->line('dash_gpanel_selectshortcode'); ?></option>
                                                    <option value="group, committee, desc, committeeid, 4">Committee</option>
                                                    <option value="group, member, desc, memberid, 4">Member</option>
                                                    <option value="group, pastor, desc, pastorid, 4">Pastor</option>
                                                    <option value="group, chorus, desc, chorusid, 4">Chorus</option>
                                                    <option value="group, clan, desc, clanid, 4">Clan</option>
                                                    <option value="group, sundayschool, desc, sschoolid, 4">Student</option>
                                                    <option value="group, staff, desc, staffid, 4">Staff</option>
                                                    <option value="speech, speech, desc, speechid, 4">Speech</option>
                                                    <option value="event, seminar, desc, seminarid, 4">Seminar</option>
                                                    <option value="event, sermon, desc, sermonid, 4">Sermon</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_content'); ?></label>
                                                <textarea id="content" name="content" class="form-control"></textarea>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_link'); ?> (*)</label>
                                                <input type="text" id="link" name="link" class="form-control" required>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_btn_text'); ?></label>
                                                <input type="text" id="btntext" name="btntext" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                                <button id="addSectionSubmit" type="button" class="btn btn-primary"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addsection_panel_title'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>