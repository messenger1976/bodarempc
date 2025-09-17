<div class="content gusers">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addsermon_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="addSermonForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/sermon/addnewsermon" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">

                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>images/upload.png);">
                                        <style>
                                            /* Limit image width to avoid overflow the container */
                                            img {
                                              max-width: 100%; /* This rule is very important, please do not ignore this! */
                                            }
                                        </style>
                                        
                                        <img id="image" src="">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">													
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_spp'); ?></p>
                                        <input type="file" onchange="sermonFeaturePhoto()" name="profileimage" id="profileimage">
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
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                        <input type="text" name="sermontitle" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" name="sermondate" class="datepicker form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_time'); ?> (*)</label>
                                        <input type="text" name="sermontime" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_author'); ?> (*)</label>
                                        <input type="text" name="sermonauthor" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>

                                

                            </div>
                            
                            
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_location'); ?></label>
                                        <input type="text" name="sermonlocation" class="form-control">
                                        <span class="material-input"></span></div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_youtube'); ?></label>
                                        <input type="text" name="sermonyoutube" class="form-control">
                                        <span class="material-input"></span></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_soundcloud'); ?></label>
                                        <input type="text" name="sermonsoundcloud" class="form-control">
                                        <span class="material-input"></span></div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                        <textarea rows="5" type="text" id="sermondescription" name="sermondescription" class="form-control"></textarea>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <button id="addSermonSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addsermon_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>