<div class="content">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addGalleryModal" style="margin-top: -2px;"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_addgallery_panel_title'); ?></a>
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allgallery_panel_title'); ?> ( <?php
                            $this->db->from('gallery');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newgallery'); ?> <?php echo getCreateDate('galleryid','gallery'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_gallery_table">
                            <thead class="text-default">
                            <th style="width: 1%"><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width: 3%"><?php echo $this->lang->line('dash_gpanel_photo'); ?></th>
                            <th style="width: 5%"><?php echo $this->lang->line('dash_gpanel_title'); ?></th>
                            <th style="width: 4%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($gallery as $row) {
                                    $i++;
                                    ?>                                
                                    <tr data-id="<?php echo $row->galleryid; ?>" style="color: rgba(33, 33, 33, 0.70); font-weight: bold" class="parent-gallery">
                                        <td><?php echo $i; ?></td>               
                                        <td><img style="width: 80px;" src="<?php echo base_url(); ?>images/website/gallery/small/<?php echo $row->filename.'?cache='.rand(); ?>"></td>                                        
                                        <td><?php echo !empty($row->title) ? htmlspecialchars($row->title) : '—'; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/website/galleryedit/<?php echo $row->galleryid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>

                                            <a href="<?php echo base_url(); ?>dashboard/website/gallerydelete/<?php echo $row->galleryid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Gallery Modal -->
                <div class="modal fade" id="addGalleryModal" tabindex="-1" role="dialog" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addGalleryModalLabel"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_addgallery_panel_title'); ?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 320px;">
                                <form id="website_gallery_add_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/uploadgallery" method="post" enctype="multipart/form-data">
                                    <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                                    <div class="form-group label-floating">
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_addimage'); ?> (*)</p>
                                        <input type="file" id="gallery" name="userfile[]" class="form-control" multiple="multiple">
                                    </div>
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?></label>
                                        <input type="text" id="title" name="title" class="form-control">
                                        <span class="material-input"></span>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" form="website_gallery_add_form" class="btn btn-primary"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>