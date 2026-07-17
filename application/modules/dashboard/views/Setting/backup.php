<div class="content">
    <div class="container-fluid">

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">backup</i> Backup Settings</h4>
                        <p class="category">Manual backup policy enabled</p>
                    </div>
                    <div class="card-content">
                        <a href="<?php echo base_url('dashboard/setting/createBackup'); ?>" class="btn btn-primary">
                            <i class="material-icons">archive</i> Create Manual Backup
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">folder</i> Available Backup Files</h4>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Modified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($backupFiles)) { ?>
                                    <?php foreach ($backupFiles as $file) { ?>
                                        <tr>
                                            <td><?php echo $file['name']; ?></td>
                                            <td><?php echo number_format($file['size'] / 1024, 2); ?> KB</td>
                                            <td><?php echo $file['modified']; ?></td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="<?php echo base_url('dashboard/setting/downloadBackup/' . rawurlencode($file['name'])); ?>">
                                                    <i class="material-icons">download</i> Download
                                                </a>
                                                <a class="btn btn-info btn-sm" href="<?php echo base_url('dashboard/setting/dryRunBackup/' . rawurlencode($file['name'])); ?>">
                                                    <i class="material-icons">fact_check</i> Dry Run
                                                </a>
                                                <a class="btn btn-warning btn-sm" href="<?php echo base_url('dashboard/setting/restoreBackup/' . rawurlencode($file['name'])); ?>" onclick="return confirm('Restore this backup now? A pre-restore snapshot will be created.');">
                                                    <i class="material-icons">restore</i> Restore
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="<?php echo base_url('dashboard/setting/deleteBackup/' . rawurlencode($file['name'])); ?>" onclick="return confirm('Delete this backup file?');">
                                                    <i class="material-icons">delete</i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4">No backup files found.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
