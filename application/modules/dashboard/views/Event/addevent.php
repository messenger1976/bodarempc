<div class="content gusers">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addevent_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="addEventForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/event/addnewevent" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-offset-0 col-md-12">

                                    <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>images/upload.png);">
                                        <img id="image" src="">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">													
                                        <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_spp'); ?></p>
                                        <input type="file" onchange="eventFeaturePhoto()" name="profileimage" id="profileimage">
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
                                        <input type="text" id="eventtitle" name="eventtitle" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" id="eventdate" name="eventdate" class="datepicker form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_time'); ?> (*)</label>
                                        <input type="text" id="eventtime" name="eventtime" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_location'); ?> (*)</label>
                                        <input type="text" id="eventlocation" name="eventlocation" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Status (*)</label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="draft" selected>Draft</option>
                                            <option value="published">Publish</option>
                                        </select>
                                        <small class="text-muted">Draft events are never shown on the public website.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Publish Start (*)</label>
                                        <input type="datetime-local" id="publish_start_at" name="publish_start_at" class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                                        <small class="text-muted">The event becomes visible at this date and time when published.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Publish End</label>
                                        <input type="datetime-local" id="publish_end_at" name="publish_end_at" class="form-control" disabled>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="no_publish_end" checked> No ending date
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                        <textarea rows="5" type="text" id="eventdescription" name="eventdescription" class="form-control"></textarea>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <button id="addEventSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">person_add</i> <?php echo $this->lang->line('dash_addevent_panel_title'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('no_publish_end').addEventListener('change', function () {
                var endDate = document.getElementById('publish_end_at');
                endDate.disabled = this.checked;
                if (this.checked) {
                    endDate.value = '';
                }
            });
        </script>