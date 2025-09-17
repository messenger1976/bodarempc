<div class="content gusers allseminars">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-1 col-md-10 seminars">
                <?php
                if ($this->uri->segment(4)) {
                    $i = $this->uri->segment(4);
                } else {
                    $i = "";
                } foreach ($seminars as $row) {
                    $i++;
                    ?>
                    <div class="card card-product">
                        <div class="card-image">						
                            <img class="img" style="height:320px;" src="<?php echo base_url(); ?>images/seminar/banner/<?php
                            if ($row->seminarbanner) {
                                echo $row->seminarbanner;
                            } else {
                                echo "banner.jpg";
                            }
                            ?> ">
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                            </div>
                            <h4 class="card-title">
                                <a href="<?php echo base_url(); ?>dashboard/seminar/view/<?php echo $row->seminarid; ?>"><?php echo word_limiter($row->seminartitle, 5); ?></a>
                            </h4>
                            <div class="card-description">
                                <?php echo word_limiter($row->seminardescription, 70); ?>
                            </div>
                        </div>
                        <div class="card-footer">						
                            <div class="pull-left">
                                <!-- <div class="price">
                                        <h5><i class="material-icons">toc</i> ID - <?php echo $row->seminarid; ?></h5>
                                </div> -->

                                <div class="price">
                                    <h5><i class="material-icons">date_range</i> <?php echo $this->lang->line('dash_gpanel_duration'); ?> - <?php echo $row->seminarstart; ?> <?php echo $this->lang->line('dash_gpanel_to'); ?> <?php echo $row->seminarend; ?></h5>
                                </div>

                                <div class="price">
                                    <h5><i class="material-icons">place</i> <?php echo $this->lang->line('dash_gpanel_location'); ?> - <?php echo $row->seminarlocation; ?></h5>
                                </div>

                                <div class="price">
                                    <h5><i class="material-icons">people</i> <?php echo $this->lang->line('dash_gpanel_tregistration'); ?> - ( <?php
                                        $seminarid = $row->seminarid;
                                        $this->db->like('selectedseminarid', $seminarid);
                                        $this->db->from('seminarregistration');
                                        echo $this->db->count_all_results();
                                        ?> )</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">		
                            <div class="pull-right">
                                <a href="<?php echo base_url(); ?>dashboard/seminar/view/<?php echo $row->seminarid; ?>" class="btn btn-primary"><i class="material-icons">call_made</i> <?php echo $this->lang->line('dash_gpanel_view'); ?></a>
                                <a href="<?php echo base_url(); ?>dashboard/seminar/edit/<?php echo $row->seminarid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                <a href="<?php echo base_url(); ?>dashboard/seminar/delete/<?php echo $row->seminarid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                            </div>
                        </div>

                    </div>
                <?php } ?>
                <?php echo $pagination; ?>
            </div>



        </div>
    </div>
</div>