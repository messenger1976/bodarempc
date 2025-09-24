<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_updateslider_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($slider as $row): ?>
                        <form id="website_slider_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/editslider" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">
                                    
                                    <!-- Wrap the image or canvas element with a block element (container) -->
                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>images/website/slider/<?php echo $row->filename; ?>);">
                                        <img id="image" src="">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    
                                    <input type="hidden" name="sliderid" id="sliderid" value="<?php echo $row->sliderid;?>">
                                    <input type="hidden" name="filename" id="filename" value="<?php echo $row->filename;?>">

                                    <div class="form-group label-floating">													
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_updateslider'); ?></p>
                                        <input type="file" onchange="sliderbanner()" name="sliderimage" id="sliderimage" class="form-control">
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
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_subtitle'); ?></label>
                                        <input type="text" id="subtitle" name="subtitle" class="form-control" value="<?php echo $row->subtitle;?>">
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">                                        
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_buttontext'); ?></label>                                        
                                        <input type="text" id="button_text" name="button_text" class="form-control" value="<?php echo $row->button_text; ?>">
                                        <span class="material-input"></span>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_buttonlink'); ?></label>
                                        <input type="text" id="button_link" name="button_link" class="form-control" value="<?php echo $row->button_link; ?>">
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_content'); ?></label>
                                            <textarea id="content" name="content" type="text" class="form-control"><?php echo $row->content; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <button id="website_slider_submit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_update_now'); ?></button>                            
                        </form>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>