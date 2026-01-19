<div class="content">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addSliderModal" style="margin-top: -2px;"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_addslider_panel_title'); ?></a>
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allslider_panel_title'); ?> ( <?php
                            $this->db->from('slider');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newslider'); ?> <?php echo getCreateDate('sliderid','slider'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_slider_table">
                            <thead class="text-default">
                            <th style="width: 1%"><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            
                            <th style="width: 3%"><?php echo $this->lang->line('dash_gpanel_photo'); ?></th>
                            <th style="width: 12%"><?php echo $this->lang->line('dash_gpanel_subtitle'); ?></th>
                            <th style="width: 18%"><?php echo $this->lang->line('dash_gpanel_content'); ?></th>
                            <th style="width: 4%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($slider as $row) {
                                    $i++;
                                    ?>                                
                                    <tr data-id="<?php echo $row->sliderid; ?>" style="color: rgba(33, 33, 33, 0.70); font-weight: bold" class="parent-slider">
                                        <td><?php echo $i; ?></td>               
                                        <td><img style="width: 80px;" src="<?php echo base_url(); ?>images/website/slider/resize/<?php echo $row->filename; ?>"></td>                                        
                                        <td><?php echo !empty($row->subtitle) ? htmlspecialchars($row->subtitle) : '—'; ?></td>
                                        <td><?php echo !empty($row->content) ? character_limiter(strip_tags($row->content), 80) : '—'; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/website/slideredit/<?php echo $row->sliderid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>

                                            <a href="<?php echo base_url(); ?>dashboard/website/sliderdelete/<?php echo $row->sliderid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Slider Modal -->
                <div class="modal fade" id="addSliderModal" tabindex="-1" role="dialog" aria-labelledby="addSliderModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addSliderModalLabel"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_addslider_panel_title'); ?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 480px;">
                                <form id="website_slider_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/uploadslider" method="post" enctype="multipart/form-data">
                                    <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                                    <div class="form-group label-floating">
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_addslider'); ?> (*)</p>
                                        <input type="file" id="slider" name="userfile[]" class="form-control" multiple="multiple">
                                    </div>
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_subtitle'); ?></label>
                                        <input type="text" name="subtitle" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_buttontext'); ?></label>
                                                <input type="text" name="button_text" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_buttonlink'); ?></label>
                                                <input type="text" name="button_link" class="form-control">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_content'); ?></label>
                                        <textarea name="content" class="form-control" rows="4"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" form="website_slider_add_form" class="btn btn-primary"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>