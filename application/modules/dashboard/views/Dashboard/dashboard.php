
<?php $user_position = $this->session->userdata('user_position');?> 
<div class="content">
    <div class="container-fluid">
        <?php if($user_position == "Admin"){ ?>          
        <div class="row">
            <div class="col-md-offset-0 col-md-12">
                <div class="card card-stats">
                    <div class="gIconColor card-header card-header-icon" data-background-color="blue">
                        <i class="material-icons">timeline</i> 
                    </div>
                    <div class="card-content">
                        <h4 class="card-title"><?php echo $this->lang->line('dash_finchart'); ?>
                        </h4>
                    </div>
                    <div id="simpleBarChart" class="ct-chart"></div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_user'); ?></p>
                        <h3 class="title"><?php echo $user; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $user; ?> <?php echo $this->lang->line('dash_users'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_committee'); ?></p>
                        <h3 class="title"><?php echo $committee; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $committee; ?> <?php echo $this->lang->line('dash_committee'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_member'); ?></p>
                        <h3 class="title"><?php echo $member; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $member; ?> <?php echo $this->lang->line('dash_members'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <?php }else{ ?>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_cassets'); ?></p>
                        <h3 class="title"><?php echo $this->lang->line('dash_money'); ?>50,000</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> This Week Added <?php echo $this->lang->line('dash_money'); ?>20,000 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_cassets'); ?></p>
                        <h3 class="title"><?php echo $this->lang->line('dash_money'); ?>50,000</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> This Week Added <?php echo $this->lang->line('dash_money'); ?>20,000 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_cassets'); ?></p>
                        <h3 class="title"><?php echo $this->lang->line('dash_money'); ?>50,000</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> This Week Added <?php echo $this->lang->line('dash_money'); ?>20,000 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_cassets'); ?></p>
                        <h3 class="title"><?php echo $this->lang->line('dash_money'); ?>50,000</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> This Week Added <?php echo $this->lang->line('dash_money'); ?>20,000 
                        </div>
                    </div>
                </div>
            </div>
        </div>            
        <?php } ?>
    </div>
</div>

