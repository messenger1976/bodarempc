<div class="content allcooperative_officers">
    <div class="container-fluid">
        <!-- Department Filter Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="departmentFilter" class="mr-2"><strong>Filter by Department:</strong></label>
                        <select id="departmentFilter" name="department" class="form-control" onchange="this.form.submit();">
                            <option value="">All Departments</option>
                            <?php 
                            if(isset($departments) && !empty($departments)) {
                                foreach($departments as $dept) {
                                    $selected = ($department_filter == $dept->departmentname) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($dept->departmentname) . '" ' . $selected . '>' . htmlspecialchars($dept->departmentname) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <?php
        $num = 1;
        $breaker = 3; //How many cols inside a row?
        foreach ($cooperative_officers as $row) {
            if ($num == 1)
                echo '<div class="row">'; //First col, so open the row.
            ?>

            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-avatar">							
                        <img class="committee img" src="<?php echo base_url(); ?>images/<?php if($row->profileimage){ echo "cooperative_officers/profile/" . $row->profileimage; }else{ echo "avatar.png"; } ?>">
                    </div>

                    <div class="content">
                        <h6 class="category text-gray"><?php echo $row->position; ?></h6>
                        <h4 class="card-title"><?php echo $row->fname . " " . $row->lname; ?></h4>
                        <h6 class="category text-muted"><?php echo $row->department ? $row->department : 'N/A'; ?></h6>
                        <p class="card-content speech"><?php echo word_limiter(strip_tags($row->speech), 20); ?></p>

                        <div class="col-md-12 action-btn">
                            <a href="<?php echo base_url(); ?>dashboard/cooperative_officers/view/<?php echo $row->cooperative_officersid; ?>" class="btn btn-primary btn-round"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                            <a href="<?php echo base_url(); ?>dashboard/cooperative_officers/edit/<?php echo $row->cooperative_officersid; ?>" class="btn btn-warning btn-round"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                            <a href="<?php echo base_url(); ?>dashboard/cooperative_officers/delete/<?php echo $row->cooperative_officersid; ?>" class="btn btn-danger btn-round delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $num++;
            if ($num > $breaker) {
                echo '</div>';
                $num = 1;
            }
        }
        ?>
        
    </div>
    <div class="col-md-12">
        <?php echo $pagination; ?>
    </div>
</div>
