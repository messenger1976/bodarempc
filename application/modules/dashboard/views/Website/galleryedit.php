<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_updategallery_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($gallery as $row): ?>
                        <form id="website_gallery_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/editgallery" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">
                                    
                                    <!-- Wrap the image or canvas element with a block element (container) -->
                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>images/website/gallery/large/<?php echo $row->filename; ?>);">
                                        <img id="image" src="">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    
                                    <input type="hidden" name="galleryid" id="galleryid" value="<?php echo $row->galleryid;?>">
                                    <input type="hidden" name="filename" id="filename" value="<?php echo $row->filename;?>">

                                    <div class="form-group label-floating">													
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_updategallery_panel_title'); ?></p>
                                        <input type="file" onchange="gallerybanner()" name="galleryimage" id="galleryimage" class="form-control">
                                        <input type="hidden" name="x" id="x">
                                        <input type="hidden" name="y" id="y">
                                        <input type="hidden" name="width" id="width">
                                        <input type="hidden" name="height" id="height">
                                    </div>
                                </div>
                            </div>


                            


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?></label>
                                        <input type="text" id="title" name="title" class="form-control" value="<?php echo $row->title;?>">
                                        <span class="material-input"></span></div>
                                </div>
                                
                                
                                
                                
                            </div>

                            <button id="website_gallery_submit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_update_now'); ?></button>                            
                        </form>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>