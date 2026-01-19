<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_updatemenu_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content"> 
                        <form id="menuUpdateForm" class="form-horizontal" enctype="multipart/form-data">
                            <?php foreach ($individual as $row): ?>
                                <input type="hidden" name="menuid" value="<?php echo $row->menuid; ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuname'); ?> (*)</label>
                                            <input id="menuname" name="menuname" type="text" class="form-control" value="<?php echo $row->menuname; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">                                    
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuparent'); ?></label>
                                            <select class="select form-control" id="menuparent" name="menuparent">
                                                <option value=""><?php echo $this->lang->line('dash_gpanel_smenuparent'); ?></option>
                                                <?php foreach ($menus as $mrow){ ?>
                                                    <option value="<?php echo $mrow->menuid; ?>"><?php echo $mrow->menuname; ?></option>
                                                <?php } ?>   
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-12">                                    
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menupage'); ?></label>
                                            <select class="select form-control" id="menupage" name="menupage">
                                                <option value=""><?php echo $this->lang->line('dash_gpanel_smenupage'); ?></option>
                                                <?php foreach ($pages as $prow){ ?>
                                                    <option value="<?php echo $prow->pageslug; ?>"><?php echo $prow->pagetitle; ?></option>
                                                <?php } ?>                                                
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></label>
                                            <input id="menulink" name="menulink" type="text" class="form-control" value="<?php echo $row->menulink; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Menu Image</label>
                                            <?php if (!empty($row->menuimage)): ?>
                                                <div style="margin-bottom: 15px;">
                                                    <img src="<?php echo base_url(); ?>images/website/menu/<?php echo $row->menuimage; ?>" alt="Menu Image" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                    <p style="font-size: 12px; color: #666;">Current Image</p>
                                                </div>
                                            <?php endif; ?>
                                            <div id="menuEditDropzone" class="dropzone" style="border: 2px dashed #ccc; padding: 20px; border-radius: 4px; background-color: #fafafa; min-height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <div class="dz-message" style="text-align: center;">
                                                    <div><i class="material-icons" style="font-size: 48px; display: block; margin-bottom: 10px;">image</i></div>
                                                    <span>Drop image here or click to upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?php echo base_url(); ?>dashboard/menu" class="btn btn-default pull-right" style="margin-right: 8px;">Cancel</a>
                                    <button id="menuUpdateSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_updatemenu_panel_title'); ?></button>
                                    <div class="clearfix"></div>
                                </div>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dropzone.js CSS from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">

<!-- Dropzone.js JS from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript">
    // Configure Dropzone
    Dropzone.autoDiscover = false;
    
    var menuEditDropzone;

    // Initialize Edit Menu Dropzone on Document Ready
    $(document).ready(function() {
        // Check if element exists before initializing
        if (!$('#menuEditDropzone').length) {
            console.error('Dropzone element #menuEditDropzone not found');
        } else {
            menuEditDropzone = new Dropzone("#menuEditDropzone", {
                url: "<?php echo base_url(); ?>dashboard/menu/update",
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
                    
                    console.log('Edit Menu Dropzone initialized');
                    
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
        }

        // Handle Update Menu Submit
        $(document).on('click', '#menuUpdateSubmit', function(e) {
            e.preventDefault();
            
            console.log('Update Menu submit clicked');
            
            if (!menuEditDropzone) {
                console.error('Dropzone not initialized');
                alert('Error: Dropzone not initialized. Please refresh the page.');
                return false;
            }
            
            console.log('Dropzone files:', menuEditDropzone.files.length);
            
            var menuname = $('#menuname').val().trim();
            
            if (!menuname) {
                alert('Menu Name is required');
                return false;
            }
            
            var formData = new FormData();
            formData.append('menuid', $('input[name="menuid"]').val());
            formData.append('menuname', $('#menuname').val());
            formData.append('menuparent', $('#menuparent').val());
            formData.append('menupage', $('#menupage').val());
            formData.append('menulink', $('#menulink').val());
            
            // Append file if selected
            if (menuEditDropzone.files.length > 0) {
                var file = menuEditDropzone.files[0];
                console.log('Appending file:', file.name, 'Size:', file.size);
                formData.append('menuimage', file);
            } else {
                console.log('No file selected - keeping existing image');
            }
            
            $.ajax({
                url: "<?php echo base_url(); ?>dashboard/menu/update",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Server response:', response);
                    if (response.success) {
                        alert(response.success);
                        window.location.href = "<?php echo base_url(); ?>dashboard/menu";
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
    });
</script>