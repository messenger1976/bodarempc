<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-bs-toggle="modal" data-target="#addMenuModal" style="margin-top: -2px;"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_addmenu_panel_title'); ?></a>
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allmenus_panel_title'); ?> ( <?php
                            $this->db->from('menu');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newmenu'); ?> <?php echo getCreateDate('menuid','menu'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_menu_table">
                            <thead class="text-default">
                            <th style="width: 1%"><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width: 5%"><?php echo $this->lang->line('dash_gpanel_menutitle'); ?></th>
                            <th style="width: 10%"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></th>
                            <th style="width: 8%">Image</th>
                            <th style="width: 4%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($parentmenu as $row) {
                                    $i++;
                                    ?>                                
                                    <tr data-id="<?php echo $row->menuid; ?>" style="color: rgba(33, 33, 33, 0.70); font-weight: bold" class="parent-menu">
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->menuname; ?></td>
                                        <td><?php
                                            $menulink = $row->menulink;
                                            echo character_limiter($menulink, 5);
                                            ?></td>
                                        <td>
                                            <?php if (!empty($row->menuimage)): ?>
                                                <img src="<?php echo base_url(); ?>images/website/menu/<?php echo $row->menuimage; ?>" alt="Menu Image" style="max-width: 60px; max-height: 60px; border: 1px solid #ddd; padding: 2px;">
                                            <?php else: ?>
                                                <span style="color: #999;">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/menu/edit/<?php echo $row->menuid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/menu/delete/<?php echo $row->menuid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>

                                    <?php
                                    $this->db->where('menuparentid', $row->menuid);
                                    $this->db->order_by('subserialid', "asc");
                                    $cmquery = $this->db->get('menu');


                                    //$cmquery = $this->db->get_where('menu', array('serialid' => $row->menuid));
                                    $j = 0;
                                    foreach ($cmquery->result() as $cm) {
                                        $j++;
                                        ?>
                                        <tr data-id="<?php echo $cm->menuid . "," . $row->menuid . "," . $j; ?>" class="child-menu">
                                            <td style="margin-left: 10px"> - <?php echo $i . "." . $j; ?></td>                                        
                                            <td><?php echo $cm->menuname; ?></td>
                                            <td><?php
                                                $menulink = $cm->menulink;
                                                echo character_limiter($menulink, 5);
                                                ?></td>
                                            <td>
                                                <?php if (!empty($cm->menuimage)): ?>
                                                    <img src="<?php echo base_url(); ?>images/website/menu/<?php echo $cm->menuimage; ?>" alt="Menu Image" style="max-width: 60px; max-height: 60px; border: 1px solid #ddd; padding: 2px;">
                                                <?php else: ?>
                                                    <span style="color: #999;">No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/menu/edit/<?php echo $cm->menuid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/menu/delete/<?php echo $cm->menuid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Add Menu Modal -->
                <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addMenuModalLabel"><i class="material-icons">list</i> <?php echo $this->lang->line('dash_addmenu_panel_title'); ?></h4>
                            </div>
                            <div class="modal-body" style="min-height: 480px;">
                                <form id="menuAddForm" class="form-horizontal" enctype="multipart/form-data">
                                    <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuname'); ?> (*)</label>
                                        <input id="menuname" name="menuname" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuparent'); ?></label>
                                        <select class="select form-control" id="menuparent" name="menuparent">
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_smenuparent'); ?></option>
                                            <?php foreach ($menus as $row): ?>
                                                <option value="<?php echo $row->menuid; ?>"><?php echo $row->menuname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menupage'); ?> Menu Page</label>
                                        <select class="select form-control" id="menupage" name="menupage">
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_smenupage'); ?></option>
                                            <?php foreach ($pages as $row): ?>
                                                <option value="<?php echo $row->pageslug; ?>"><?php echo $row->pagetitle; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></label>
                                        <input id="menulink" name="menulink" type="text" class="form-control">
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Menu Image</label>
                                        <div id="menuAddDropzone" class="dropzone" style="border: 2px dashed #ccc; padding: 20px; border-radius: 4px; background-color: #fafafa; min-height: 100px; display: flex; align-items: center; justify-content: center;">
                                            <div class="dz-message" style="text-align: center;">
                                                <div><i class="material-icons" style="font-size: 48px; display: block; margin-bottom: 10px;">image</i></div>
                                                <span>Drop image here or click to upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                                <button id="menuAddSubmit" type="button" class="btn btn-primary"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_addmenu_panel_title'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //echo $pagination;       ?>
            </div>


        </div>
    </div>
</div>

<!-- Dropzone.js CSS from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">

<!-- Dropzone.js JS from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript">
    // Wait for jQuery and Dropzone to be available
    if (typeof Dropzone === 'undefined') {
        console.error('Dropzone.js not loaded properly');
    } else {
        console.log('Dropzone.js loaded successfully');
    }

    // Configure Dropzone
    Dropzone.autoDiscover = false;
    
    var menuAddDropzone;

    // Initialize Add Menu Dropzone when modal opens
    $(document).on('shown.bs.modal', '#addMenuModal', function() {
        // Check if dropzone already initialized
        if (menuAddDropzone) {
            return;
        }
        
        // Check if element exists
        if (!$('#menuAddDropzone').length) {
            console.error('Dropzone element #menuAddDropzone not found');
            return;
        }
        
        menuAddDropzone = new Dropzone("#menuAddDropzone", {
            url: "<?php echo base_url(); ?>dashboard/menu/add",
            maxFilesize: 5, // 5 MB
            acceptedFiles: ".jpg,.jpeg,.png,.gif",
            uploadMultiple: false,
            maxFiles: 1,
            paramName: "menuimage",
            autoQueue: false,
            autoDiscover: false,
            addRemoveLinks: true,
            dictDefaultMessage: "Drop image here or click to upload",
            init: function() {
                var dz = this;
                
                console.log('Add Menu Dropzone initialized');
                
                this.on("addedfile", function(file) {
                    console.log('File added:', file.name);
                    if (dz.files.length > 1) {
                        dz.removeFile(dz.files[0]);
                    }
                });

                this.on("error", function(file, errorMessage) {
                    console.error('Dropzone error:', errorMessage);
                    alert('Image Upload Error: ' + errorMessage);
                });

                this.on("removedfile", function(file) {
                    console.log('File removed:', file.name);
                });
            }
        });
    });

    // Reset dropzone when modal closes
    $(document).on('hidden.bs.modal', '#addMenuModal', function() {
        if (menuAddDropzone) {
            menuAddDropzone.destroy();
            menuAddDropzone = null;
        }
    });

    // Handle Add Menu Submit
    $(document).on('click', '#menuAddSubmit', function(e) {
        e.preventDefault();
        
        if (!menuAddDropzone) {
            alert('Dropzone not initialized');
            return false;
        }
        
        console.log('Add Menu submit clicked');
        console.log('Dropzone files:', menuAddDropzone.files.length);
        
        var menuname = $('#menuname').val().trim();
        
        if (!menuname) {
            alert('Menu Name is required');
            return false;
        }
        
        var formData = new FormData();
        formData.append('menuname', $('#menuname').val());
        formData.append('menuparent', $('#menuparent').val());
        formData.append('menupage', $('#menupage').val());
        formData.append('menulink', $('#menulink').val());
        
        // Append file if selected
        if (menuAddDropzone.files.length > 0) {
            var file = menuAddDropzone.files[0];
            console.log('Appending file:', file.name, 'Size:', file.size);
            formData.append('menuimage', file);
        } else {
            console.log('No file selected');
        }
        
        $.ajax({
            url: "<?php echo base_url(); ?>dashboard/menu/add",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                if (response.success) {
                    alert(response.success);
                    location.reload();
                } else if (response.errorFormValidation) {
                    alert('Validation Error: ' + response.errorFormValidation);
                } else if (response.menuimage_error) {
                    alert('Image Upload Error: ' + response.menuimage_error);
                } else if (response.notsuccess) {
                    alert(response.notsuccess);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                alert('Error: ' + error + '\n\nCheck console for details');
            }
        });
        
        return false;
    });
</script>